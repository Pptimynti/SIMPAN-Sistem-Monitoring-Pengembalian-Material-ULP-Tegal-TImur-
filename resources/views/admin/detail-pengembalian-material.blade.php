<x-app-layout>
   <div class="relative rounded-md overflow-x-auto shadow sm:rounded-lg mt-2 border border-gray-200">
      <table class="w-full text-sm text-gray-500 dark:text-gray-400 dark:border-gray-700">
         <tbody>
            <tr>
               <th scope="row"
                  class="px-6 py-3 min-w-32 border text-left bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
                  No Agenda</th>
               <td class="px-6 py-5 border">{{ $pekerjaan->no_agenda }}</td>
            </tr>
            <tr>
               <th scope="row"
                  class="px-6 py-3 min-w-32 border text-left bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
                  No PK</th>
               <td class="px-6 py-5 border">{{ $pekerjaan->no_pk }}</td>
            </tr>
            <tr>
               <th scope="row"
                  class="px-6 py-3 min-w-32 border text-left bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
                  Tanggal PK</th>
               <td class="px-6 py-5 border">{{ $pekerjaan->tanggal_pk }}</td>
            </tr>
            <tr>
               <th scope="row"
                  class="px-6 py-3 min-w-32 border text-left bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
                  Petugas</th>
               <td class="px-6 py-5 border">{{ $pekerjaan->petugas }}</td>
            </tr>
            <tr>
               <th scope="row"
                  class="px-6 py-3 min-w-32 border text-left bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
                  Nama Pelanggan</th>
               <td class="px-6 py-5 border">{{ $pekerjaan->nama_pelanggan }}</td>
            </tr>
            <tr>
               <th scope="row"
                  class="px-6 py-3 min-w-32 border text-left bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
                  Mutasi</th>
               <td class="px-6 py-5 border">{{ $pekerjaan->mutasi }}</td>
            </tr>
            <tr>
               <th scope="row"
                  class="px-6 py-3 min-w-32 border text-left bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-400">
                  Material Dikembalikan</th>
               <td class="px-6 py-5 border">
                  <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                     <thead>
                        <tr>
                           <th class="px-6 py-3 min-w-32 border">Nama</th>
                           <th class="px-6 py-3 min-w-20 border">Jumlah</th>
                           <th class="px-6 py-3 min-w-32 border">Gambar</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($pekerjaan->materialDikembalikans as $materialD)
                           <tr>
                              <td class="px-6 py-5 border text-center">{{ $materialD->material->nama }}</td>
                              <td class="px-6 py-5 font-bold text-gray-800 dark:text-white border text-center">
                                 {{ $materialD->jumlah . ' ' . $materialD->material->satuan }}</td>
                              <td class="px-6 py-5 border">
                                 <div class="flex flex-wrap gap-2 justify-center">
                                    @foreach ($materialD->gambarMaterials as $gambar)
                                       <img role="button" data-src="{{ asset($gambar->gambar) }}"
                                          src="{{ asset(asset('storage/' . $gambar->gambar)) }}"
                                          alt="{{ $materialD->nama }}"
                                          class="materialImages w-20 h-20 object-cover rounded border">
                                    @endforeach
                                 </div>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>

      <!-- Modal Material Image -->
      <div id="containerModal" class="fixed z-20 inset-x-0 inset-y-0 pointer-events-none">
         <div id="overlayModal"
            class="fixed z-20 inset-x-0 inset-y-0 bg-black opacity-0 backdrop-blur-sm transition-opacity duration-300 pointer-events-none">
         </div>
         <img id="modalImage" src=""
            class="p-4 w-[30rem] h-[30rem] relative z-30 left-1/2 -translate-x-1/2 top-1/2 -translate-y-[99rem] transition-all duration-300">
         </img>
      </div>
   </div>

   <div class="mt-2 w-24">
      <a href="{{ route('admin.laporan.pengembalian-material') }}"
         class="flex items-center w-full sm:w-auto gap-2 px-2 py-2.5 text-sm font-medium text-center text-white bg-[#136782] rounded-lg hover:bg-[#155a71] focus:ring-4 focus:outline-none focus:ring-blue-300">
         <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
         </svg>
         <span class="whitespace-nowrap">Kembali</span>
      </a>
   </div>
</x-app-layout>
