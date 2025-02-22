<?php

namespace App\Services\Implementations;

use App\Models\GambarMaterial;
use App\Models\Material;
use App\Models\MaterialBekas;
use App\Models\MaterialDikembalikan;
use App\Models\Pekerjaan;
use App\Services\PekerjaanInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Log;

class PekerjaanService implements PekerjaanInterface
{

    /**
     * @inheritDoc
     */
    public function hapusPekerjaan(int $idPekerjaan): bool
    {
        return Pekerjaan::findOrFail($idPekerjaan)->delete();
    }

    /**
     * @inheritDoc
     */
    public function tambahPekerjaan(array $data): bool
    {
        // Log::info("Tanggal PK: " . $data['tanggal_pk']->toDateTimeString());
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

                MaterialBekas::updateOrCreate(
                    ['material_id' => $material['material_id']],
                    ['stok' => \DB::raw('stok + ' . $material['jumlah'])]
                );
            }

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
                    $existingMaterial->update(['material_id' => $material['material_id'], 'jumlah' => $material['jumlah']]);
                    $materialDikembalikan = $existingMaterial;
                } else {
                    $newMaterial = MaterialDikembalikan::create(['pekerjaan_id' => $pekerjaan->id, 'material_id' => $material['material_id'], 'jumlah' => $material['jumlah']]);
                    MaterialBekas::updateOrCreate(['material_id' => $newMaterial['material_id']], ['stok' => DB::raw('COALESCE(stok, 0) + ' . $newMaterial['jumlah'])]);
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

                $materialBekas = MaterialBekas::where('material_id', $material['material_id'])->first();
                if ($materialBekas) {
                    $stok_sekarang = $materialBekas->stok;
                    $stok_baru = $material['jumlah'];
                    $selisih = $stok_baru - $stok_sekarang;

                    if ($selisih != 0) {
                        $materialBekas->update(['stok' => DB::raw('stok + ' . $selisih)]);
                    }
                }
            }

            MaterialDikembalikan::where('pekerjaan_id', $pekerjaan->id)->whereNotIn('id', $materialIds)->delete();

            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error('Gagal memperbarui pekerjaan: ' . $e->getMessage());
            DB::rollBack();
            return false;
        }
    }



}
