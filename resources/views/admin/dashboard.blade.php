<x-app-layout>
   <div class="w-full grid md:grid-cols-3 gap-4">
      @for ($i = 1; $i <= 6; $i++)
         <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <svg class="w-7 h-7 text-gray-500 dark:text-gray-400 mb-3" viewBox="0 0 24 24" width="24" height="24"
               stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
               class="css-i6dzq1">
               <polyline points="21 8 21 21 3 21 3 8"></polyline>
               <rect x="1" y="3" width="22" height="5"></rect>
               <line x1="10" y1="12" x2="14" y2="12"></line>
            </svg>
            <h5 class="mt-2 mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Kabel
            </h5>
            <p class="font-normal text-gray-500 dark:text-gray-400">Pengembalian Hari ini: <span
                  class="font-bold ml-2.5">
                  10</span></p>
            <p class="font-normal text-gray-500 dark:text-gray-400">Pengembalian Bulan ini: <span class="font-bold">
                  10</span></p>
         </div>
      @endfor
   </div>

</x-app-layout>
