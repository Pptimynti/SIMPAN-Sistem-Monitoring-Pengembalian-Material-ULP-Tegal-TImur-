<div class="flex gap-4 w-full justify-between">
   <div class="w-full">
      <div class="flex flex-wrap items-center justify-between pb-2 md:pb-4">
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
      <div class="relative overflow-x-auto sm:rounded-lg rounded-lg shadow border border-gray-300 dark:border-gray-700">
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
                     Satuan
                  </th>
                  <th scope="col" class="px-6 py-3">
                     Action
                  </th>
               </tr>
            </thead>
            <tbody>
               @foreach ($materials as $material)
                  <tr
                     class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                     <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $loop->iteration }}
                     </th>
                     <td class="px-6 py-4">
                        {{ $material->nama }}
                     </td>
                     <td class="px-6 py-4">
                        {{ $material->satuan }}
                     </td>
                     <td class="px-6 py-4">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
   <div class="w-[40rem] pt-[3.4rem]">
      <form method="POST" action="{{ route('admin.tambah-material') }}"
         class="mx-auto p-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg shadow border border-gray-300 dark:border-gray-700 md:mb-4"
         enctype="multipart/form-data">
         @csrf
         <h1 class="font-bold mb-4 text-lg max-w-60">Tambah Data Material</h1>

         <div class="mb-3">
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Material</label>
            <input type="text" name="nama" required
               class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
         </div>

         <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
            <input type="text" name="satuan" required
               class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
         </div>

         <button type="submit"rounded-lg shadow border border-gray-300 dark:border-gray-700
            class="mt-4 w-full text-white bg-[#136782] hover:bg-[#11495c] focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Submit
         </button>
      </form>
   </div>
</div>
