<div>
   <div class="flex flex-col gap-2 md:flex-row md:items-center lg:justify-between">
      <!-- Date Range Picker -->
      <div class="flex items-center gap-2 w-full">
         <div class="relative w-full">
            <!-- Start Date Input -->
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor" viewBox="0 0 20 20">
                  <path
                     d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
               </svg>
            </div>
            <input id="datepicker-range-start" name="start" type="date" wire:model.live.debounce.100ms="startDate"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
         </div>

         <!-- To Text -->
         <span class="text-gray-500">to</span>

         <!-- End Date Input -->
         <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path
                     d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
               </svg>
            </div>
            <input id="datepicker-range-end" name="end" type="date" wire:model.live.debounce.100ms="endDate"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
         </div>
      </div>

      <!-- Search Bar -->
      <div class="pb-4 bg-white dark:bg-gray-800 md:pt-2">
         <label for="table-search" class="sr-only">Search</label>
         <div class="relative mt-1">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
               </svg>
            </div>
            <input wire:model.live.debounce.100ms="search" type="text" id="table-search"
               class="block ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5 md:w-80"
               placeholder="Search for items">
         </div>
      </div>
   </div>
   @if ($pekerjaans->count() > 0)
      <div class="relative rounded-md overflow-x-auto shadow sm:rounded-lg mt-2 border border-gray-200">
         <table class="w-full text-sm text-gray-500 dark:text-gray-400 dark:border-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
               <tr>
                  <th scope="col" class="px-6 py-3 border">No</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">No Agenda</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Petugas</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Nama Pelanggan</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Mutasi</th>
                  <th scope="col" class="px-6 py-3 min-w-72 border text-left" colspan="3">Material Dikembalikan
                  </th>
                  <th scope="col" class="px-6 py-3 border">Aksi</th>
               </tr>
               <tr>
                  <th scope="col" class="px-6 py-3 border" colspan="5"></th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Nama</th>
                  <th scope="col" class="px-6 py-3 min-w-20 border">Jumlah</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Gambar</th>
                  <th scope="col" class="px-6 py-3 border"></th>
               </tr>
            </thead>
            <tbody>
               @foreach ($pekerjaans as $pekerjaan)
                  @php $firstRow = true; @endphp
                  @foreach ($pekerjaan->materialDikembalikans as $materialD)
                     <tr class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                        @if ($firstRow)
                           <th scope="row" class="px-6 py-5 font-medium text-gray-900 dark:text-white border"
                              rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $loop->parent->iteration }}
                           </th>
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
                                 <img role="button" data-src="{{ asset('storage/' . $gambar->gambar) }}"
                                    src="{{ asset('storage/' . $gambar->gambar) }}" alt="{{ $materialD->nama }}"
                                    class="materialImages w-20 h-20 object-cover rounded border">
                              @endforeach
                           </div>
                        </td>
                        @if ($firstRow)
                           <td class="px-6 py-5 text-center border"
                              rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              <a href="{{ route('admin.laporan.detail.pengembalian-material', $pekerjaan->id) }}"
                                 class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                           </td>
                           @php $firstRow = false; @endphp
                        @endif
                     </tr>
                  @endforeach
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
         <button type="button" wire:click="cetak_pdf"
            class="text-white bg-[#FF0000] hover:bg-[#FF0000]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
            <svg class="w-4 h-4 me-2" viewBox="0 0 24 24" width="24" height="24" stroke="white"
               stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
               <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
               <polyline points="14 2 14 8 20 8"></polyline>
               <line x1="16" y1="13" x2="8" y2="13"></line>
               <line x1="16" y1="17" x2="8" y2="17"></line>
               <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            Download PDF
         </button>
         <button wire:click="export" type="button"
            class="text-white bg-[#217346] hover:bg-[#217346]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
            <svg class="w-4 h-4 me-2" viewBox="0 0 24 24" width="24" height="24" stroke="white"
               stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
               <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
               <polyline points="14 2 14 8 20 8"></polyline>
               <line x1="16" y1="13" x2="8" y2="13"></line>
               <line x1="16" y1="17" x2="8" y2="17"></line>
               <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            Download EXCEL
         </button>
      </div>
   @else
      <div class="flex flex-col items-center justify-center h-[27rem] text-gray-600">
         <svg class="w-16 h-16 text-gray-400 mb-4" viewBox="0 0 24 24" width="24" height="24"
            stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
            class="css-i6dzq1">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
         </svg>
         <h2 class="text-xl font-semibold">Hasil Tidak Ditemukan</h2>
         <p class="text-gray-500 mt-2 text-center">Coba gunakan kata kunci lain atau tambahkan data.</p>
      </div>
   @endif
</div>
