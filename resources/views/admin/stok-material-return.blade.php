<x-app-layout>
   @livewire('tabel-material-return')
   <!-- Form modal material return -->
   <div id="returnModal"
      class="scale-0 transition-all duration-300 overflow-y-auto overflow-x-hidden fixed top-1/2 z-50 w-[22rem] md:w-[30rem] h-fit max-h-full -translate-y-1/2 left-1/2 -translate-x-1/2">
      <div class="relative p-2 w-full">
         <!-- Modal content -->
         <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
               class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
               <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Menggunakan Material Return
               </h3>
               <button id="closeModalBtn" type="button" data-modal-target="returnModal"
                  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
               </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" action="{{ route('admin.menggunakan-material-return') }}" method="POST">
               @method('PUT')
               @csrf
               <div class="grid gap-4 mb-4 grid-cols-2">
                  <div class="col-span-2">
                     <label for="nama"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                     <select name="materialBekas_id" id="materialBekas_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                        @foreach ($materialBekas as $mb)
                           <option value="{{ $mb->id }}">{{ $mb->material->nama }}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-span-2">
                     <label for="jumlah"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                     <input type="text" name="jumlah" id="jumlah"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Jumlah yang ingin digunakan" required="">
                  </div>
               </div>
               <button type="submit"
                  class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Submit
               </button>
            </form>
         </div>
      </div>
   </div>

   <!-- Form modal stok manual -->
   <div id="manualStockModal"
      class="scale-0 transition-all duration-300 overflow-y-auto overflow-x-hidden fixed top-1/2 z-50 w-[22rem] md:w-[30rem] h-fit max-h-full -translate-y-1/2 left-1/2 -translate-x-1/2">
      <div class="relative p-2 w-full">
         <!-- Modal content -->
         <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
               class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
               <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Penyesuaian Stok Manual
               </h3>
               <button id="closeModalBtn" type="button" data-modal-target="manualStockModal"
                  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
               </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" action="{{ route('admin.menyesuaikan-stok-manual') }}" method="POST">
               @method('PUT')
               @csrf
               <div class="grid gap-4 mb-4 grid-cols-2">
                  <div class="col-span-2">
                     <label for="material_id"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Material</label>
                     <select name="material_id" id="material_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="" onchange="updateStokManual(this.value)">
                        <option disabled selected value="">Pilih material</option>
                        @foreach ($materials as $material)
                           <option value="{{ $material->id }}">{{ $material->nama }}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-span-2">
                     <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok
                        Manual</label>
                     <input type="number" name="jumlah" id="jumlahStokManual" value=""
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 placeholder:text-gray-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Jumlah yang ingin digunakan" required="">
                     <div
                        class="bg-[#e0f2f1] border-l-4 border-[#136782] text-[#136782] p-4 rounded-lg mt-4 max-w-2xl dark:bg-[#0f2528] dark:text-white">
                        <p class="text-sm">💡 Catatan: Jika ingin menambah stok, tambahkan angka ke jumlah saat ini.
                           Jika ingin mengurangi, kurangi angka tersebut. Pastikan untuk memeriksa kembali sebelum
                           menyimpan perubahan.</p>
                     </div>
                  </div>
               </div>
               <button type="submit"
                  class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Submit
               </button>
            </form>
         </div>
      </div>
   </div>
</x-app-layout>
<x-script>
   <script>
      async function updateStokManual(materialId) {
         try {
            const response = await fetch(`/admin/api/material-bekas/${materialId}`);

            const data = await response.json();
            document.getElementById('jumlahStokManual').value = data.stok_manual ?? 0;
         } catch (error) {
            document.getElementById('jumlahStokManual').value = 0;
         }
      }
   </script>
</x-script>
