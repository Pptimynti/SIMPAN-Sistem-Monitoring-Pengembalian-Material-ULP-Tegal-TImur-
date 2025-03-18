<div>
   <!-- Header Section -->
   <div class="mb-8">
      <h1 class="text-3xl font-bold text-[#1e243a] dark:text-white">Halaman Material Return</h1>
      <p class="text-gray-600 dark:text-gray-400 mt-2">Selamat datang kembali! Berikut ringkasan data material return dan
         history penggunaan.</p>
   </div>

   <!-- Search and Filter Section -->
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

      <!-- Search Input -->
      <div class="w-full sm:w-96 relative">
         <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
               viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
         </div>
         <input type="text" id="table-search" wire:model.live.debounce.100ms="search"
            class="w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500"
            placeholder="Cari material...">
      </div>
   </div>

   <!-- Main Content Section -->
   <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Material Bekas Table -->
      <div
         class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border overflow-hidden dark:shadow-md dark:border-none">
         <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Daftar Material Bekas</h2>
            @if ($materialBekas->count() > 0)
               <div class="overflow-x-auto">
                  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                     <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700">
                        <tr>
                           <th scope="col" class="px-6 py-3">No</th>
                           <th scope="col" class="px-6 py-3">Nama Material</th>
                           <th scope="col" class="px-6 py-3 min-w-44">Stok Awal</th>
                           <th scope="col" class="px-6 py-3">Stok Digunakan</th>
                           <th scope="col" class="px-6 py-3 min-w-44">Stok Tersedia</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($materialBekas as $return)
                           <tr
                              class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                              <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}
                              </td>
                              <td class="px-6 py-4">{{ $return->material->nama }}</td>
                              <td class="px-6 py-4">
                                 {{ $return->material->materialDikembalikans->sum('jumlah') == 0 ? $return->stok_manual : $return->material->materialDikembalikans->sum('jumlah') + $return->stok_manual . ' ' . $return->material->satuan }}
                              </td>
                              <td class="px-6 py-4">{{ $return->telah_digunakan . ' ' . $return->material->satuan }}
                              </td>
                              <td class="px-6 py-4 font-bold text-[#136782] dark:text-[#5ab4d4]">
                                 {{ $return->stok_tersedia . ' ' . $return->material->satuan }}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="mt-4">
                  {{ $materialBekas->links() }}
               </div>
            @else
               <div class="flex flex-col items-center justify-center py-10 text-gray-500 dark:text-gray-400">
                  <svg class="w-16 h-16 mb-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                     <circle cx="11" cy="11" r="8"></circle>
                     <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                  </svg>
                  <h2 class="text-xl font-semibold">Tidak ada data ditemukan</h2>
                  <p class="text-center">Coba gunakan kata kunci lain atau tambahkan data.</p>
               </div>
            @endif
         </div>
      </div>

      <!-- History Penggunaan Section -->
      <div
         class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border overflow-hidden dark:shadow-md dark:border-none">
         <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">History Penggunaan</h2>
            @if ($activityLogs->count() > 0)
               <div class="overflow-x-auto">
                  <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                     <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700">
                        <tr>
                           <th scope="col" class="px-6 py-3">No</th>
                           <th scope="col" class="px-6 py-3">Tanggal</th>
                           <th scope="col" class="px-6 py-3">Material Digunakan</th>
                           <th scope="col" class="px-6 py-3">Jumlah</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $no = ($activityLogs->currentPage() - 1) * $activityLogs->perPage(); @endphp
                        @foreach ($activityLogs as $activity)
                           <tr
                              class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                              <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ ++$no }}
                              </td>
                              <td class="px-6 py-4">
                                 {{ \Illuminate\Support\Carbon::parse($activity->created_at)->isoFormat('D MMM Y') }}
                              </td>
                              <td class="px-6 py-4">{{ $activity->materialBekas->material->nama }}</td>
                              <td class="px-6 py-4">
                                 {{ $activity->jumlah . ' ' . $activity->materialBekas->material->satuan }}</td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="mt-4">
                  {{ $activityLogs->links() }}
               </div>
            @else
               <div class="text-gray-500 dark:text-gray-400 py-10 text-center">Belum ada history penggunaan.</div>
            @endif
         </div>
      </div>
   </div>

   <!-- Admin Notifications -->
   @if (Auth::user()->role === 'admin')
      <div class="mt-8 space-y-4">
         <div
            class="bg-[#e0f2f1] border-l-4 border-[#136782] text-[#136782] p-4 rounded-lg dark:bg-[#0f2528] dark:text-white">
            <p class="font-semibold">Ingin menggunakan material return?</p>
            <p class="text-sm mt-1">Material return adalah material yang telah dikembalikan dan bisa digunakan kembali
               untuk kebutuhan lain.</p>
            <button data-modal-target="returnModal"
               class="mt-3 text-sm font-medium text-[#136782] hover:underline dark:text-yellow-300">
               Isi Form Penggunaan Material Return
            </button>
         </div>

         <div
            class="bg-[#e0f2f1] border-l-4 border-[#136782] text-[#136782] p-4 rounded-lg dark:bg-[#0f2528] dark:text-white">
            <p class="font-semibold">Ingin menambahkan atau menyesuaikan stok manual?</p>
            <p class="text-sm mt-1">Stok manual digunakan untuk mencatat material yang belum terdata di sistem atau
               material tambahan yang masuk di luar pengembalian otomatis.</p>
            <button data-modal-target="manualStockModal"
               class="mt-3 text-sm font-medium text-[#136782] hover:underline dark:text-yellow-300">
               Isi Form Stok Manual
            </button>
         </div>
      </div>
   @endif
</div>
