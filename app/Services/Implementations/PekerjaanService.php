<?php

namespace App\Services\Implementations;

use App\Models\GambarMaterial;
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
        Log::debug('Request : ' . json_encode($data));
        $validator = Validator::make($data, [
            'no_agenda' => 'required',
            'petugas' => 'required',
            'nama_pelanggan' => 'required|max:30',
            'mutasi' => 'required',

            'material_dikembalikan' => 'required|array',
            'material_dikembalikan.*.nama' => 'required|string|max:50',
            'material_dikembalikan.*.jumlah' => 'required|integer|min:1',

            'material_dikembalikan.*.gambar' => 'required|array',
            'material_dikembalikan.*.gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
                'petugas' => $validatedData['petugas'],
                'nama_pelanggan' => $validatedData['nama_pelanggan'],
                'mutasi' => $validatedData['mutasi']
            ]);

            foreach ($validatedData['material_dikembalikan'] as $material) {
                $materialDikembalikan = MaterialDikembalikan::create([
                    'pekerjaan_id' => $pekerjaan['id'],
                    'nama' => $material['nama'],
                    'jumlah' => $material['jumlah']
                ]);

                Log::info("Material ID: " . $materialDikembalikan->id);

                if (isset($material['gambar'])) {
                    foreach ($material['gambar'] as $gambar) {
                        $file = $gambar->store('images', 'public');
                        Log::info("Variabel gambar: " . json_encode($gambar));
                        Log::info("Variabel file: " . $file);

                        GambarMaterial::create([
                            'material_dikembalikan_id' => $materialDikembalikan->id,
                            'gambar' => $file
                        ]);
                    }
                }
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
            'petugas' => 'required',
            'nama_pelanggan' => 'required|max:30',
            'mutasi' => 'required',

            'material_dikembalikan' => 'required|array',
            'material_dikembalikan.*.id' => 'nullable|exists:material_dikembalikans,id',
            'material_dikembalikan.*.nama' => 'required|string|max:50',
            'material_dikembalikan.*.jumlah' => 'required|integer|min:1',

            'material_dikembalikan.*.gambar' => 'nullable|array',
            'material_dikembalikan.*.gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            Log::debug('Pekerjaan ditemukan: ', $pekerjaan->toArray());

            $pekerjaan->update([
                'no_agenda' => $validatedData['no_agenda'],
                'petugas' => $validatedData['petugas'],
                'nama_pelanggan' => $validatedData['nama_pelanggan'],
                'mutasi' => $validatedData['mutasi']
            ]);
            Log::info('Pekerjaan berhasil diperbarui', ['id' => $pekerjaan->id]);

            $materialIds = [];

            foreach ($validatedData['material_dikembalikan'] as $material) {
                if (isset($material['id'])) {
                    $existingMaterial = MaterialDikembalikan::findOrFail($material['id']);
                    Log::debug('Material ditemukan untuk update: ', $existingMaterial->toArray());

                    $existingMaterial->update([
                        'nama' => $material['nama'],
                        'jumlah' => $material['jumlah']
                    ]);
                    $materialDikembalikan = $existingMaterial;
                } else {
                    $newMaterial = MaterialDikembalikan::create([
                        'pekerjaan_id' => $pekerjaan->id,
                        'nama' => $material['nama'],
                        'jumlah' => $material['jumlah']
                    ]);
                    Log::info('Material baru dibuat: ', $newMaterial->toArray());
                    $materialDikembalikan = $newMaterial;
                }

                $materialIds[] = $materialDikembalikan->id;
                Log::debug('Material ID saat ini: ' . json_encode($materialIds));

                if (isset($material['gambar'])) {
                    $gambarLama = GambarMaterial::where('material_dikembalikan_id', $materialDikembalikan->id)->get();
                    Log::debug('Menghapus gambar lama: ', $gambarLama->toArray());

                    foreach ($gambarLama as $gbr) {
                        Storage::disk('public')->delete($gbr->gambar);
                        $gbr->delete();
                    }

                    foreach ($material['gambar'] as $gambar) {
                        $filepath = $gambar->store('images', 'public');
                        GambarMaterial::create([
                            'material_dikembalikan_id' => $materialDikembalikan->id,
                            'gambar' => $filepath
                        ]);
                        Log::info('Gambar baru disimpan: ' . $filepath);
                    }
                }
            }

            MaterialDikembalikan::where('pekerjaan_id', $pekerjaan->id)
                ->whereNotIn('id', $materialIds)
                ->delete();
            Log::info('Material yang tidak ada di daftar terbaru telah dihapus.');

            DB::commit();
            Log::info('Transaksi berhasil!');
            return true;

        } catch (Exception $e) {
            Log::error('Gagal memperbarui pekerjaan: ' . $e->getMessage());
            DB::rollBack();
            return false;
        }
    }


}
