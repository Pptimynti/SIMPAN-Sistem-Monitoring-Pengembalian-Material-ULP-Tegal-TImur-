<?php

namespace App\Services\Implementations;

use App\Models\ActivityLog;
use App\Models\GambarMaterial;
use App\Models\Material;
use App\Models\MaterialBekas;
use App\Models\MaterialDikembalikan;
use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Log;

class PekerjaanService implements PekerjaanInterface
{

    public function hapusPekerjaan(int $idPekerjaan): bool
    {
        try {
            Log::info('Mulai menghapus pekerjaan dengan ID: ' . $idPekerjaan);

            // Ambil dulu total jumlah material dikembalikan sebelum data dihapus
            $materials = MaterialDikembalikan::where('pekerjaan_id', $idPekerjaan)
                ->select('material_id', DB::raw('SUM(jumlah) as total_jumlah'))
                ->groupBy('material_id')
                ->get();

            Log::info('Material dikembalikan ditemukan: ', $materials->toArray());

            // Hapus data pekerjaan setelah data material disimpan
            Pekerjaan::findOrFail($idPekerjaan)->delete();
            Log::info('Pekerjaan dengan ID ' . $idPekerjaan . ' berhasil dihapus');

            // Update stok material bekas
            foreach ($materials as $material) {
                $materialBekas = MaterialBekas::where('material_id', $material->material_id)->first();
                $totalJumlahDikembalikan = MaterialDikembalikan::where('material_id', $material->material_id)->sum('jumlah');

                if ($totalJumlahDikembalikan == 0 && ($materialBekas->stok_manual ?? 0) == 0) {
                    Log::info('Menghapus material bekas karena semua pekerjaan terhapus dan stok manual kosong', ['material_id' => $material->material_id]);
                    $materialBekas->delete();
                    continue;
                }

                $telahDigunakan = $materialBekas->telah_digunakan ?? 0;
                $stokManual = $materialBekas->stok_manual ?? 0;

                // Hitung ulang stok tersedia dengan mempertimbangkan material telah digunakan
                $stokTersedia = max(0, ($totalJumlahDikembalikan - $telahDigunakan) + $stokManual);

                MaterialBekas::updateOrCreate(
                    ['material_id' => $material->material_id],
                    ['stok_tersedia' => $stokTersedia]
                );

                Log::info('Stok material bekas diupdate', [
                    'material_id' => $material->material_id,
                    'total_jumlah_dikembalikan' => $totalJumlahDikembalikan,
                    'telah_digunakan' => $telahDigunakan,
                    'stok_manual' => $stokManual,
                    'stok_tersedia' => $stokTersedia
                ]);
            }
            return true;
        } catch (Exception $e) {
            Log::warning('Gagal menghapus pekerjaan: ' . $e->getMessage());
            return false;
        }
    }


    public function tambahPekerjaan(array $data): bool
    {
        $validator = Validator::make($data, [
            'no_agenda' => 'required',
            'no_pk' => 'required',
            'tanggal_pk' => 'required|date',
            'petugas' => 'required',
            'nama_pelanggan' => 'required|max:30',
            'mutasi' => 'required',

            'material_dikembalikan' => 'required|array',
            'material_dikembalikan.*.material_id' => 'required|exists:materials,id',
            'material_dikembalikan.*.jumlah' => 'required|integer|min:1',

            'material_dikembalikan.*.gambar' => 'required|array',
            'material_dikembalikan.*.gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validator->fails()) {
            Log::error('Validasi error : ' . $validator->errors());
        }

        $validatedData = $validator->validated();
        Log::info('Keren : ', $validatedData);

        try {
            DB::beginTransaction();
            $pekerjaan = Pekerjaan::create([
                'no_agenda' => $validatedData['no_agenda'],
                'no_pk' => $validatedData['no_pk'],
                'tanggal_pk' => $validatedData['tanggal_pk'],
                'petugas' => $validatedData['petugas'],
                'nama_pelanggan' => $validatedData['nama_pelanggan'],
                'mutasi' => $validatedData['mutasi']
            ]);

            foreach ($validatedData['material_dikembalikan'] as $material) {
                $materialDikembalikan = MaterialDikembalikan::create([
                    'pekerjaan_id' => $pekerjaan['id'],
                    'material_id' => $material['material_id'],
                    'jumlah' => $material['jumlah']
                ]);

                if (isset($material['gambar'])) {
                    foreach ($material['gambar'] as $gambar) {
                        $file = $gambar->store('images', 'public');

                        GambarMaterial::create([
                            'material_dikembalikan_id' => $materialDikembalikan->id,
                            'gambar' => $file
                        ]);
                    }
                }
            }

            $materials = MaterialDikembalikan::select('material_id', DB::raw('SUM(jumlah) as total_jumlah'))
                ->groupBy('material_id')
                ->get();

            foreach ($materials as $material) {
                $materialBekas = MaterialBekas::where('material_id', $material->material_id)->first();
                $telahDigunakan = $materialBekas->telah_digunakan ?? 0;
                $stokManual = $materialBekas->stok_manual ?? 0;
                MaterialBekas::updateOrCreate(
                    ['material_id' => $material->material_id],
                    ['stok_tersedia' => $material->total_jumlah - $telahDigunakan + $stokManual]
                );
            }

            $user = Auth::user();

            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Tambah Pengembalian',
                'deskripsi' => "melakukan pengembalian material"
            ]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::warning('Gagal memabahkan pekerjaan' . $e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function updatePekerjaan(int $idPekerjaan, array $data): bool
    {
        Log::debug('Request Data: ' . json_encode($data));

        $validator = Validator::make($data, [
            'no_agenda' => 'required',
            'no_pk' => 'required',
            'tanggal_pk' => 'required|date',
            'petugas' => 'required',
            'nama_pelanggan' => 'required|max:30',
            'mutasi' => 'required',
            'material_dikembalikan' => 'required|array',
            'material_dikembalikan.*.id' => 'nullable|exists:material_dikembalikans,id',
            'material_dikembalikan.*.material_id' => 'required|exists:materials,id',
            'material_dikembalikan.*.jumlah' => 'required|integer|min:1',
            'material_dikembalikan.*.gambar' => 'nullable|array',
            'material_dikembalikan.*.gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        if ($validator->fails()) {
            Log::error('Validasi error: ' . json_encode($validator->errors()));
            return false;
        }

        $validatedData = $validator->validated();
        Log::info('Data Valid: ', $validatedData);

        try {
            DB::beginTransaction();

            $pekerjaan = Pekerjaan::findOrFail($idPekerjaan);
            $pekerjaan->update(['no_agenda' => $validatedData['no_agenda'], 'no_pk' => $validatedData['no_pk'], 'tanggal_pk' => $validatedData['tanggal_pk'], 'petugas' => $validatedData['petugas'], 'nama_pelanggan' => $validatedData['nama_pelanggan'], 'mutasi' => $validatedData['mutasi']]);

            $materialIds = [];

            foreach ($validatedData['material_dikembalikan'] as $material) {
                if (isset($material['id'])) {
                    $existingMaterial = MaterialDikembalikan::findOrFail($material['id']);
                    $existingMaterial->update([
                        'material_id' => $material['material_id'],
                        'jumlah' => $material['jumlah']
                    ]);
                    $materialDikembalikan = $existingMaterial;
                } else {
                    $newMaterial = MaterialDikembalikan::create([
                        'pekerjaan_id' => $pekerjaan->id,
                        'material_id' => $material['material_id'],
                        'jumlah' => $material['jumlah']
                    ]);
                    $materialDikembalikan = $newMaterial;
                }

                $materialIds[] = $materialDikembalikan->id;

                if (isset($material['gambar'])) {
                    $gambarLama = GambarMaterial::where('material_dikembalikan_id', $materialDikembalikan->id)->get();
                    foreach ($gambarLama as $gbr) {
                        Storage::disk('public')->delete($gbr->gambar);
                        $gbr->delete();
                    }

                    foreach ($material['gambar'] as $gambar) {
                        $file = $gambar->store('images', 'public');
                        GambarMaterial::create(['material_dikembalikan_id' => $materialDikembalikan->id, 'gambar' => $file]);
                    }
                }
            }

            MaterialDikembalikan::where('pekerjaan_id', $pekerjaan->id)->whereNotIn('id', $materialIds)->delete();

            $materials = MaterialDikembalikan::select('material_id', DB::raw('SUM(jumlah) as total_jumlah'))
                ->groupBy('material_id')
                ->get();

            foreach ($materials as $material) {
                $materialBekas = MaterialBekas::where('material_id', $material->material_id)->first();
                $telahDigunakan = $materialBekas->telah_digunakan ?? 0;
                $stokManual = $materialBekas->stok_manual ?? 0;
                MaterialBekas::updateOrCreate(
                    ['material_id' => $material->material_id],
                    ['stok_tersedia' => $material->total_jumlah - $telahDigunakan + $stokManual]
                );
            }

            Log::info('materialBekas', ['materialBekas' => $materials]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error('Gagal memperbarui pekerjaan: ' . $e->getMessage());
            DB::rollBack();
            return false;
        }
    }



}
