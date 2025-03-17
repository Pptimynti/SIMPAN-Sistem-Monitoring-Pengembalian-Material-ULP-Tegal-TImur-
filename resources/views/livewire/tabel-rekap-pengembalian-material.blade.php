<div>
   <!-- Header Section -->
   <div class="mb-8">
      <h1 class="text-3xl font-bold text-[#1e243a] dark:text-white">Rekap Data Pengembalian Material</h1>
      @if ($filterBy && $startDate && $endDate)
         @php $filteran = $filterBy === 'tanggal_pk' ? 'Tanggal PK' : 'Tanggal Pengembalian' @endphp
         <p class="text-gray-600 dark:text-gray-400 mt-2">
            Rekap data pengembalian material berdasarkan Tanggal PK periode
            {{ \Illuminate\Support\Carbon::parse($startDate)->isoFormat('dddd, D MMMM YYYY') }} -
            {{ \Illuminate\Support\Carbon::parse($endDate)->isoFormat('dddd, D MMMM YYYY') }}.
         </p>
      @else
         <p class="text-gray-600 dark:text-gray-400 mt-2">Rekap data pengembalian material keseluruhan.
         </p>
      @endif
   </div>

   <!-- Filter and Search Section -->
   <div class="flex flex-col sm:flex-row gap-4 mb-4">
      <!-- Per Page Selector -->
      <div class="w-full sm:w-48">
         <select wire:model.live.debounce.100ms="perPage" id="perPage"
            class="w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500">
            <option value="5">5 per halaman</option>
            <option value="10">10 per halaman</option>
            <option value="50">50 per halaman</option>
         </select>
      </div>

      <!-- Filter By -->
      <div class="w-full sm:w-48">
         <select name="filterBy" wire:model.live.debounce.150ms="filterBy"
            class="w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500">
            <option value="" selected disabled>Opsi Filter</option>
            <option value="tanggal_pk">Tanggal PK</option>
            <option value="created_at">Tanggal Pengembalian</option>
         </select>
      </div>

      <!-- Date Range -->
      <div class="flex flex-col sm:flex-row sm:items-center gap-2">
         <div class="relative w-full sm:w-44">
            <input id="datepicker-range-start" name="start" type="date" wire:model.live.debounce.150ms="startDate"
               class="w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500">
         </div>
         <span class="text-gray-500 text-sm">to</span>
         <div class="relative w-full sm:w-44">
            <input id="datepicker-range-end" name="end" type="date" wire:model.live.debounce.150ms="endDate"
               min="{{ $startDate }}"
               class="w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500">
         </div>
      </div>

      <!-- Search Bar -->
      <div class="w-full sm:w-96 relative">
         <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
               viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
         </div>
         <input wire:model.live.debounce.100ms="search" type="text" id="table-search"
            class="w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500"
            placeholder="Cari data...">
      </div>
   </div>

   <!-- Table Section -->
   @if ($pekerjaans->count() > 0)
      <div class="relative overflow-x-auto rounded-lg shadow-lg border border-gray-300 dark:border-gray-700">
         <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700">
               <tr>
                  <th scope="col" class="px-6 py-3 border">No</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Tanggal</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">No Agenda</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Tanggal PK</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Petugas</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Nama Pelanggan</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Mutasi</th>
                  <th scope="col" class="px-6 py-3 min-w-72 border text-left" colspan="3">Material Dikembalikan
                  </th>
                  @if (Auth::user()->role === 'admin')
                     <th scope="col" class="px-6 py-3 border">Aksi</th>
                  @endif
               </tr>
               <tr>
                  <th scope="col" class="px-6 py-3 border" colspan="7"></th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Nama</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Jumlah</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Gambar</th>
                  @if (Auth::user()->role === 'admin')
                     <th scope="col" class="px-6 py-3 border"></th>
                  @endif
               </tr>
            </thead>
            <tbody>
               @php $no = ($pekerjaans->currentPage() - 1) * $pekerjaans->perPage(); @endphp
               @foreach ($pekerjaans as $pekerjaan)
                  @php $firstRow = true; @endphp
                  @foreach ($pekerjaan->materialDikembalikans as $materialD)
                     <tr class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                        @if ($firstRow)
                           <th scope="row" class="px-6 py-5 font-medium text-gray-900 dark:text-white border"
                              rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ ++$no }}
                           </th>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ \Illuminate\Support\Carbon::parse($pekerjaan->created_at)->isoFormat('D MMM Y') }}
                           </td>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $pekerjaan->no_agenda }}
                           </td>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ \Illuminate\Support\Carbon::parse($pekerjaan->tanggal_pk)->isoFormat('D MMM Y') }}
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
                        <td class="px-6 py-5 border text-center">{{ $materialD->material->nama }}</td>
                        <td class="px-6 py-5 font-bold text-gray-800 dark:text-white border text-center">
                           {{ $materialD->jumlah . ' ' . $materialD->material->satuan }}
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
                           @if (Auth::user()->role === 'admin')
                              <td class="px-6 py-5 text-center border"
                                 rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                                 <a href="{{ route('admin.laporan.detail.pengembalian-material', $pekerjaan->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                              </td>
                           @endif
                           @php $firstRow = false; @endphp
                        @endif
                     </tr>
                  @endforeach
               @endforeach
            </tbody>
         </table>
      </div>

      <!-- Download Buttons -->
      @if (Auth::user()->role === 'admin')
         <div class="mt-4 flex gap-2">
            <button wire:click="export" type="button"
               class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#217346] rounded-lg hover:bg-[#217346]/90 focus:ring-4 focus:outline-none focus:ring-green-300">
               <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                  id="Microsoft-Excel-Logo--Streamline-Ultimate" height="24" width="24">
                  <desc>Microsoft Excel Logo Streamline Icon: https://streamlinehq.com</desc>
                  <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" d="M15.12 12h8.13"
                     stroke-width="1.5"></path>
                  <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" d="M15.12 7h8.13"
                     stroke-width="1.5"></path>
                  <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" d="m4 9 5 6"
                     stroke-width="1.5"></path>
                  <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" d="m9 9 -5 6"
                     stroke-width="1.5"></path>
                  <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" d="M15.13 2.25V17h8.12"
                     stroke-width="1.5"></path>
                  <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                     d="M7 18v3c0 0.2652 0.10536 0.5196 0.29289 0.7071C7.48043 21.8946 7.73478 22 8 22h14.25c0.2652 0 0.5196 -0.1054 0.7071 -0.2929s0.2929 -0.4419 0.2929 -0.7071V3c0 -0.26522 -0.1054 -0.51957 -0.2929 -0.70711C22.7696 2.10536 22.5152 2 22.25 2H8c-0.26522 0 -0.51957 0.10536 -0.70711 0.29289C7.10536 2.48043 7 2.73478 7 3v3"
                     stroke-width="1.5"></path>
                  <path stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"
                     d="M1.75 6h10s1 0 1 1v10s0 1 -1 1h-10s-1 0 -1 -1V7s0 -1 1 -1Z" stroke-width="1.5"></path>
               </svg>
               Download EXCEL
            </button>
         </div>
      @endif
   @else
      <div class="flex flex-col items-center justify-center h-[27rem] text-gray-600">
         <svg class="w-16 h-16 text-gray-400 mb-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
            fill="none" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
         </svg>
         <h2 class="text-xl font-semibold">Data Tidak Ditemukan</h2>
         <p class="text-gray-500 mt-2 text-center">Coba gunakan kata kunci lain atau tambahkan data.</p>
      </div>
   @endif

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
