<x-app-layout>
   <div class="flex items-center">
      <div class="pt-3">
         <button id="tambahBtn" data-url="{{ route('petugas.halaman.tambah.pengembalian-material') }}"
            class="text-white bg-[#136782] hover:bg-[#136782]/90 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1 me-2 mb-2 dark:bg-[#136782] dark:hover:bg-[#136782] focus:outline-none dark:focus:ring-bg-[#136782]"
            type="button" data-url="{{ route('petugas.halaman.tambah.pengembalian-material') }}">
            <svg class="w-7 h-7" viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
               fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
               <line x1="12" y1="5" x2="12" y2="19"></line>
               <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
         </button>
      </div>
      <div class="bg-white dark:bg-gray-800 w-full">
         <label for="table-search" class="sr-only">Search</label>
         <div class="relative mt-1">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
               </svg>
            </div>
            <input type="text" id="table-search"
               class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 md:w-80"
               placeholder="Search for items">
         </div>
      </div>
   </div>
   <div class="relative rounded-md overflow-x-auto shadow sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
         <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
               <th scope="col" class="px-6 py-3">
                  No
               </th>
               <th scope="col" class="px-6 py-3 min-w-32">
                  No Agenda
               </th>
               <th scope="col" class="px-6 py-3 min-w-32">
                  Petugas
               </th>
               <th scope="col" class="px-6 py-3 min-w-32">
                  Nama Pelanggan
               </th>
               <th scope="col" class="px-6 py-3 min-w-32">
                  Mutasi
               </th>
               <th scope="col" class="px-6 py-3 min-w-72">
                  Material Dikembalikan
               </th>
               <th scope="col" class="px-6 py-3">
                  <span class="sr-only">Detail</span>
               </th>
            </tr>
         </thead>
         <tbody>
            <tr
               class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
               <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  1
               </th>
               <td class="px-6 py-4">
                  AGND12345
               </td>
               <td class="px-6 py-4">
                  Dhika
               </td>
               <td class="px-6 py-4">
                  Mahar
               </td>
               <td class="px-6 py-4">
                  Pemasangan Baru
               </td>
               <td class="px-6 py-4">
                  <div class="grid grid-cols-3 gap-2 items-start">
                     <img src="URL_GAMBAR" alt="Material 1" class="w-20 h-20 object-cover rounded border">
                     <div>
                        <p class="font-semibold text-gray-900 dark:text-white">Material 1</p>
                     </div>
                     <span class="font-bold text-gray-800 dark:text-white">x1</span>
                  </div>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</x-app-layout>
<x-script>
   <script>
      let tambahBtn = document.getElementById('tambahBtn');
      tambahBtn.addEventListener('click', function() {
         window.location.href = this.dataset.url;
      })
   </script>
</x-script>
