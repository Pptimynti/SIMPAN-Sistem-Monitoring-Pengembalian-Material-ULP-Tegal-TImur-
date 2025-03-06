<div>
   <div class="max-w-3xl pb-2 md:pb-4 flex gap-2 items-center justify-between">
      <div class="">
         <select wire:model.live.debounce.100ms="perPage" id="perPage"
            class="text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="50">50</option>
         </select>
      </div>
      <label for="table-search" class="sr-only">Search</label>
      <div class="relative">
         <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
               viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"></path>
            </svg>
         </div>
         <input type="text" id="table-search" wire:model.live.debounce.100ms="search"
            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 md:w-80"
            placeholder="Search for items">
      </div>
   </div>
   @if ($materialBekas->count() > 0)
      <div class="relative overflow-x-auto shadow border sm:rounded-lg max-w-3xl">
         <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700 dark:text-gray-400">
               <tr>
                  <th scope="col" class="px-6 py-3">
                     No
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Nama
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Stok Awal
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Stok Digunakan
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Stok Tersedia
                  </th>
               </tr>
            </thead>
            <tbody>
               @foreach ($materialBekas as $return)
                  <tr
                     class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                     <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $loop->iteration }}
                     </th>
                     <td class="px-6 py-4">
                        {{ $return->material->nama }}
                     </td>
                     <td class="px-6 py-4">
                        {{ $return->material->materialDikembalikans->sum('jumlah') == 0 ? $return->stok_manual : $return->material->materialDikembalikans->sum('jumlah') + $return->stok_manual }}
                     </td>
                     <td class="px-6 py-4">
                        {{ $return->telah_digunakan }}
                     </td>
                     <td class="px-6 py-4 font-bold text-black text-lg">
                        {{ $return->stok_tersedia }}
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <div class="mt-2">
         {{ $materialBekas->links() }}
      </div>
      @if (Auth::user()->role === 'admin')
         <div
            class="bg-[#e0f2f1] border-l-4 border-[#136782] text-[#136782] p-4 rounded-lg mt-4 max-w-3xl dark:bg-[#0f2528] dark:text-white">
            <p class="font-semibold">Ingin menggunakan material return?</p>
            <p class="text-sm mt-1">Material return adalah material yang telah dikembalikan dan bisa digunakan kembali
               untuk kebutuhan lain. Material ini bisa dipakai untuk mengurangi kebutuhan material baru sehingga lebih
               efisien dan hemat biaya.</p>
            <button data-modal-target="returnModal"
               class="mt-3 text-sm font-medium text-[#136782] hover:underline dark:text-yellow-300">Isi Form Penggunaan
               Material Return</button>
         </div>
         <div
            class="bg-[#e0f2f1] border-l-4 border-[#136782] text-[#136782] p-4 rounded-lg mt-4 max-w-3xl dark:bg-[#0f2528] dark:text-white">
            <p class="font-semibold">Ingin menambahkan atau menyesuaikan stok manual?</p>
            <p class="text-sm mt-1">Stok manual digunakan untuk mencatat material yang belum terdata di sistem atau
               material tambahan yang masuk di luar pengembalian otomatis. Jika input jumlah penambahan stok manual
               kosong, maka dianggap bernilai 0. Jika diisi, maka jumlah tersebut akan menjadi stok manual yang
               tercatat, menyesuaikan dengan data yang diinput.</p>
            <button data-modal-target="manualStockModal"
               class="mt-3 text-sm font-medium text-[#136782] hover:underline dark:text-yellow-300">Isi Form Stok
               Manual</button>
         </div>
      @endif
   @else
      <div class="flex flex-col items-center justify-center h-[27rem] text-gray-600">
         <svg class="w-16 h-16 text-gray-400 mb-4" viewBox="0 0 24 24" width="24" height="24"
            stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
            class="css-i6dzq1">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
         </svg>
         <h2 class="text-xl font-semibold">Tidak ada data ditemukan</h2>
         <p class="text-gray-500 mt-2 text-center">Coba gunakan kata kunci lain atau tambahkan data.</p>
      </div>
   @endif
</div>
