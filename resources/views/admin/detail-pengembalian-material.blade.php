<x-app-layout>
   <div class="relative rounded-md overflow-x-auto shadow sm:rounded-lg mt-2 border border-gray-200">
      <table class="w-full text-sm text-gray-500 dark:text-gray-400 dark:border-gray-700">
         <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
               <th scope="col" class="px-6 py-3 min-w-32 border">No Agenda</th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Petugas</th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Nama Pelanggan</th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Mutasi</th>
               <th scope="col" class="px-6 py-3 min-w-72 border text-left" colspan="3">Material Dikembalikan
               </th>
            </tr>
            <tr>
               <th scope="col" class="px-6 py-3 border" colspan="4"></th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Nama</th>
               <th scope="col" class="px-6 py-3 min-w-20 border">Jumlah</th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Gambar</th>
            </tr>
         </thead>
         <tbody>
            @php $firstRow = true; @endphp
            @foreach ($pekerjaan->materialDikembalikans as $materialD)
               <tr class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                  @if ($firstRow)
                     <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                        {{ $pekerjaan->no_agenda }}
                     </td>
                     <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                        {{ $pekerjaan->petugas }}
                     </td>
                     <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                        {{ $pekerjaan->nama_pelanggan }}
                     </td>
                     <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                        {{ $pekerjaan->mutasi }}
                     </td>
                  @endif
                  <td class="px-6 py-5 border text-center">{{ $materialD->nama }}</td>
                  <td class="px-6 py-5 font-bold text-gray-800 dark:text-white border text-center">
                     x{{ $materialD->jumlah }}
                  </td>
                  <td class="px-6 py-5 border">
                     <div class="flex flex-wrap gap-2 justify-center">
                        @foreach ($materialD->gambarMaterials as $gambar)
                           <img role="button" data-src="{{ asset($gambar->gambar) }}"
                              src="{{ asset($gambar->gambar) }}" alt="{{ $materialD->nama }}"
                              class="materialImages w-20 h-20 object-cover rounded border">
                        @endforeach
                     </div>
                  </td>
                  @php $firstRow = false; @endphp
               </tr>
            @endforeach
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
   <div class="mt-4 flex">
      <a href="{{ route('exportPdf.detail-pengembalian-material', $pekerjaan->id) }}" wire:click="cetak_pdf"
         class="text-white bg-[#FF0000] hover:bg-[#FF0000]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
         <svg class="w-4 h-4 me-2" viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
         </svg>
         Download PDF
      </a>
      <a href="{{ route('export.detail-pengembalian-material', $pekerjaan->id) }}" type="button"
         class="text-white bg-[#217346] hover:bg-[#217346]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
         <svg class="w-4 h-4 me-2" viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
            fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
         </svg>
         Download EXCEL
      </a>
   </div>
</x-app-layout>
