<x-app-layout>
   @livewire('tabel-user')
   <div id="userModal"
      class="scale-0 transition-all duration-300 overflow-y-auto overflow-x-hidden fixed top-1/2 z-50 w-[22rem] md:w-[30rem] h-fit max-h-full -translate-y-1/2 left-1/2 -translate-x-1/2">
      <div class="relative p-2 w-full">
         <!-- Modal content -->
         <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
               class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
               <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Tambah Data User
               </h3>
               <button id="closeModalBtn" type="button" data-modal-target="userModal"
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
            <form class="p-4 md:p-5" action="{{ route('admin.tambah-user') }}" method="POST">
               @csrf
               <div class="grid gap-4 mb-4 grid-cols-2">
                  <div class="col-span-2">
                     <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                     <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="John Doe" required="">
                  </div>
                  <div class="col-span-2">
                     <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                     <input type="email" name="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="john@doe.com" required="">
                  </div>
                  <div class="col-span-2 md:col-span-1">
                     <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                     <input type="password" name="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required>
                  </div>
                  <div class="col-span-2 md:col-span-1">
                     <label for="password_confirmation"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
                     <input type="password_confirmation" name="password_confirmation" id="password_confirmation"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required>
                  </div>
                  <div class="col-span-2">
                     <label for="role"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                     <select name="role" id="role"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="manager">Manager</option>
                     </select>
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
   <div id="userModalEdit"
      class="scale-0 transition-all duration-300 overflow-y-auto overflow-x-hidden fixed top-1/2 z-50 w-[22rem] md:w-[30rem] h-fit max-h-full -translate-y-1/2 left-1/2 -translate-x-1/2">
      <div class="relative p-2 w-full max-h-full">
         <!-- Modal content -->
         <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
               class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
               <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Edit Data User
               </h3>
               <button id="closeModalBtn" type="button" data-modal-target="userModalEdit"
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
            <form class="p-4 md:p-5" action="{{ route('admin.update-user') }}" method="POST">
               @csrf
               @method('PUT')
               <input id="inputHidden" type="hidden" name="user_id" value="">
               <div class="grid gap-4 mb-4 grid-cols-2">
                  <div class="col-span-2">
                     <label for="nameEdit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                     <input type="text" name="name" id="nameEdit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="John Doe" required="">
                  </div>
                  <div class="col-span-2">
                     <label for="emailEdit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                     <input type="email" name="email" id="emailEdit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="john@doe.com" required="">
                  </div>
                  <div class="col-span-2 md:col-span-1">
                     <label for="passwordEdit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                     <input type="password" name="password" id="passwordEdit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                  </div>
                  <div class="col-span-2 md:col-span-1">
                     <label for="password_confirmationEdit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi
                        Password</label>
                     <input type="password" name="password_confirmation" id="password_confirmationEdit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                  </div>
                  <div class="col-span-2">
                     <label for="roleEdit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                     <select name="role" id="roleEdit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="manager">Manager</option>
                     </select>
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
      function confirmDelete(id) {
         Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus dan tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
         }).then((result) => {
            if (result.isConfirmed) {
               document.getElementById(`delete-form-${id}`).submit();
            }
         });
      }

      document.addEventListener('DOMContentLoaded', () => {
         const editButtons = document.querySelectorAll('.edit-user-button');
         editButtons.forEach(button => {
            button.addEventListener('click', async (event) => {
               const userId = event.currentTarget.dataset.id;

               try {
                  const response = await fetch(`api/users/${userId}/show`);
                  const data = await response.json();

                  if (response.ok) {
                     document.getElementById('inputHidden').value = data.id;
                     document.getElementById('nameEdit').value = data.name;
                     document.getElementById('passwordEdit').value = data.password;
                     document.getElementById('password_confirmationEdit').value = data.password;
                     document.getElementById('emailEdit').value = data.email;
                     document.getElementById('roleEdit').value = data.role;
                  };
               } catch (error) {
                  console.log(error);
               }
            });
         });
      });
   </script>
</x-script>
