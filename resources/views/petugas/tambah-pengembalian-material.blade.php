<x-app-layout>
   <form method="POST" action="{{ route('petugas.tambah.pengembalian-material') }}"
      class="max-w-sm mx-auto p-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg shadow border border-gray-300 dark:border-gray-700 md:max-w-lg"
      enctype="multipart/form-data">
      @csrf
      <h1 class="font-bold mb-4 text-lg max-w-60">Tambah Data Pengembalian Material</h1>

      <div class="mb-3">
         <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Agenda</label>
         <input type="text" name="no_agenda" required
            class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <div class="mb-2">
         <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Petugas</label>
         <input type="text" name="petugas" required
            class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <div class="mb-2">
         <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan</label>
         <input type="text" name="nama_pelanggan" required maxlength="30"
            class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <div class="mb-3">
         <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Mutasi</label>
         <input type="text" name="mutasi" required
            class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <div id="materialContainer">
         <div class="grid grid-cols-2 gap-3 material-item">
            <div class="col-span-1">
               <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Material</label>
               <input type="text" name="material_dikembalikan[0][nama]" required
                  class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div class="col-span-1">
               <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
               <input type="number" name="material_dikembalikan[0][jumlah]" required min="1"
                  class="shadow-xs bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div class="col-span-2">
               <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Gambar</label>
               <input type="file" name="material_dikembalikan[0][gambar][]" multiple
                  class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 focus:ring-blue-500 focus:border-blue-500" />
            </div>
         </div>
      </div>

      <button id="tambahMaterialBtn" type="button"
         class="mb-2 mt-3 w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-500 font-medium rounded-lg text-sm px-3 py-1.5 text-center">
         Tambah Material
      </button>

      <button type="submit"
         class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
         Submit
      </button>
   </form>
</x-app-layout>
<x-script>
   <script>
      document.getElementById('tambahMaterialBtn').addEventListener('click', function() {
         let container = document.getElementById('materialContainer');
         let index = document.querySelectorAll('.material-item').length;

         let newMaterial = document.createElement('div');
         newMaterial.classList.add('grid', 'grid-cols-2', 'gap-3', 'rounded-md', 'mt-3',
            'material-item');

         newMaterial.innerHTML = `
                <div class="col-span-1">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Material</label>
                    <input type="text" name="material_dikembalikan[${index}][nama]" required
                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="col-span-1">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                    <input type="number" name="material_dikembalikan[${index}][jumlah]" required min="1"
                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                </div>
                <div class="col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Gambar</label>
                    <input type="file" name="material_dikembalikan[${index}][gambar][]" multiple
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" />
                </div>
                <button type="button" class="mt-2 px-3 py-1.5 text-white bg-red-600 hover:bg-red-700 rounded-md text-sm removeMaterial">Hapus</button>
            `;

         container.appendChild(newMaterial);

         // Tambahkan event listener untuk tombol hapus
         newMaterial.querySelector('.removeMaterial').addEventListener('click', function() {
            newMaterial.remove();
         });
      });
   </script>
   <script>
      @if (session('success'))
         Swal.fire({
            title: "Drag me!",
            icon: "success",
            draggable: true
         });
      @else
         Swal.fire({
            title: "Gagal!",
            icon: "warning",
            draggable: true
         });
      @endif
   </script>

</x-script>
