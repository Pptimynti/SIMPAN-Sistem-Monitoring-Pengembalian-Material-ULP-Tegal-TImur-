<div>
   <div class="flex items-center justify-between pb-2 md:pb-4">
      <div>
         <button id="tmbhUserBtn" data-url="{{ route('admin.halaman-tambah-user') }}" type="button"
            data-tooltip-target="tooltip-bottom" data-tooltip-placement="bottom"
            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-center text-white bg-[#136782] rounded-lg hover:bg-[#155a71] focus:ring-4 focus:outline-none focus:ring-blue-300">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
               stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
               <line x1="12" y1="5" x2="12" y2="19"></line>
               <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <p class="hidden md:block">Tambah User</p>
         </button>
         <div id="tooltip-bottom" role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700 md:hidden">
            Tambah User
            <div class="tooltip-arrow" data-popper-arrow></div>
         </div>
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
         <input type="text" id="table-search"
            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search for items">
      </div>
   </div>
   <div class="relative overflow-x-auto rounded-lg shadow border border-gray-300 dark:border-gray-700">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
         <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
               <th scope="col" class="px-6 py-3">
                  No
               </th>
               <th scope="col" class="px-6 py-3">
                  Nama
               </th>
               <th scope="col" class="px-6 py-3">
                  Email
               </th>
               <th scope="col" class="px-6 py-3">
                  Role
               </th>
               <th scope="col" class="px-6 py-3">
                  Action
               </th>
            </tr>
         </thead>
         <tbody>
            <tr
               class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
               <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  1
               </th>
               <td class="px-6 py-4">
                  Silver
               </td>
               <td class="px-6 py-4">
                  Laptop
               </td>
               <td class="px-6 py-4">
                  Laptop
               </td>
               <td class="px-6 py-4">
                  <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
               </td>
            </tr>
            <tr
               class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
               <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  2
               </th>
               <td class="px-6 py-4">
                  White
               </td>
               <td class="px-6 py-4">
                  Laptop PC
               </td>
               <td class="px-6 py-4">
                  Laptop PC
               </td>
               <td class="px-6 py-4">
                  <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
               </td>
            </tr>
            <tr
               class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
               <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  3
               </th>
               <td class="px-6 py-4">
                  Black
               </td>
               <td class="px-6 py-4">
                  Accessories
               </td>
               <td class="px-6 py-4">
                  Accessories
               </td>
               <td class="px-6 py-4">
                  <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
