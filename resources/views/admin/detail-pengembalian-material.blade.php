<x-app-layout>
   <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
      <!-- Tombol Kembali -->
      <div class="mb-6">
         <a href="{{ url()->previous() }}"
            class="inline-flex items-center text-sm text-[#136782] dark:text-[#5ab4d4] hover:text-[#0e4e63] dark:hover:text-[#4a9db8]">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
               </path>
            </svg>
            Kembali
         </a>
      </div>

      <!-- Header Section -->
      <div class="mb-8">
         <h1 class="text-3xl font-bold text-[#1e243a] dark:text-white">Detail Pengembalian Material</h1>
         <p class="text-gray-600 dark:text-gray-400 mt-2">Lihat detail lengkap pengembalian material, termasuk informasi
            pekerjaan dan material yang dikembalikan.</p>
      </div>

      <!-- Detail Section -->
      <div
         class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
         <table class="w-full text-sm text-gray-500 dark:text-gray-400">
            <tbody>
               <!-- No Agenda -->
               <tr class="border-b dark:border-gray-700">
                  <th scope="row"
                     class="px-6 py-4 font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">No Agenda
                  </th>
                  <td class="px-6 py-4">{{ $pekerjaan->no_agenda }}</td>
               </tr>
               <!-- Tanggal PK -->
               <tr class="border-b dark:border-gray-700">
                  <th scope="row"
                     class="px-6 py-4 font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">Tanggal PK
                  </th>
                  <td class="px-6 py-4">{{ $pekerjaan->tanggal_pk }}</td>
               </tr>
               <!-- Petugas -->
               <tr class="border-b dark:border-gray-700">
                  <th scope="row"
                     class="px-6 py-4 font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">Petugas
                  </th>
                  <td class="px-6 py-4">{{ $pekerjaan->petugas }}</td>
               </tr>
               <!-- Nama Pelanggan -->
               <tr class="border-b dark:border-gray-700">
                  <th scope="row"
                     class="px-6 py-4 font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">Nama
                     Pelanggan</th>
                  <td class="px-6 py-4">{{ $pekerjaan->nama_pelanggan }}</td>
               </tr>
               <!-- Mutasi -->
               <tr class="border-b dark:border-gray-700">
                  <th scope="row"
                     class="px-6 py-4 font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">Mutasi</th>
                  <td class="px-6 py-4">{{ $pekerjaan->mutasi }}</td>
               </tr>
               <!-- Material Dikembalikan -->
               <tr>
                  <th scope="row"
                     class="px-6 py-4 font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">Material
                     Dikembalikan</th>
                  <td class="px-6 py-4">
                     <div class="overflow-x-auto">
                        <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                           <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700">
                              <tr>
                                 <th class="px-6 py-3 min-w-32 border">Nama</th>
                                 <th class="px-6 py-3 min-w-20 border">Jumlah</th>
                                 <th class="px-6 py-3 min-w-32 border">Gambar</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($pekerjaan->materialDikembalikans as $materialD)
                                 <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">{{ $materialD->material->nama }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-white text-center">
                                       {{ $materialD->jumlah . ' ' . $materialD->material->satuan }}
                                    </td>
                                    <td class="px-6 py-4">
                                       <div class="flex flex-wrap gap-2 justify-center">
                                          @foreach ($materialD->gambarMaterials as $gambar)
                                             <img role="button" data-src="{{ asset('storage/' . $gambar->gambar) }}"
                                                src="{{ asset('storage/' . $gambar->gambar) }}"
                                                alt="{{ $materialD->nama }}"
                                                class="materialImages w-20 h-20 object-cover rounded-lg border cursor-pointer hover:shadow-lg transition-shadow">
                                          @endforeach
                                       </div>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>

      <!-- Modal for Image Preview -->
      <div id="containerModal" class="fixed z-20 inset-x-0 inset-y-0 pointer-events-none">
         <div id="overlayModal"
            class="fixed z-20 inset-x-0 inset-y-0 bg-black opacity-0 backdrop-blur-sm transition-opacity duration-300 pointer-events-none">
         </div>
         <img id="modalImage" src=""
            class="p-4 w-[30rem] h-[30rem] relative z-30 left-1/2 -translate-x-1/2 top-1/2 -translate-y-[99rem] transition-all duration-300">
         </img>
      </div>
   </div>
</x-app-layout>
