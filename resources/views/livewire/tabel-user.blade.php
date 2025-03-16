<div>
   <!-- Header Section -->
   <div class="mb-8">
      <h1 class="text-3xl font-bold text-[#1e243a] dark:text-white">Manajemen User</h1>
      <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola data user dengan mudah dan efisien.</p>
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
            placeholder="Cari user...">
      </div>

      <!-- Add User Button -->
      <div class="w-full sm:w-auto">
         <button id="openModalBtn" data-modal-target="userModal" type="button"
            class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-[#136782] rounded-lg hover:bg-[#155a71] focus:ring-4 focus:outline-none focus:ring-blue-300">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
               stroke-linecap="round" stroke-linejoin="round">
               <line x1="12" y1="5" x2="12" y2="19"></line>
               <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Tambah User</span>
         </button>
      </div>
   </div>

   <!-- User Table -->
   <div class="bg-white dark:bg-gray-800 shadow-sm border overflow-hidden dark:shadow-md dark:border-none">
      <div class="p-6">
         <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Daftar User</h2>
         @if ($users->count() > 0)
            <div class="overflow-x-auto">
               <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                  <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700">
                     <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php $no = ($users->currentPage() - 1) * $users->perPage(); @endphp
                     @foreach ($users as $user)
                        <tr
                           class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                           <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $no++ }}</td>
                           <td class="px-6 py-4">{{ $user->name }}</td>
                           <td class="px-6 py-4">{{ $user->email }}</td>
                           <td class="px-6 py-4 capitalize">{{ $user->role }}</td>
                           <td class="px-6 py-4">
                              <div class="flex items-center gap-2">
                                 <!-- Edit Button -->
                                 <button type="button" data-modal-target="userModalEdit" data-id="{{ $user->id }}"
                                    class="edit-user-button flex items-center gap-1 text-blue-600 dark:text-blue-500 hover:underline">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                       fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                       <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    <span>Edit</span>
                                 </button>

                                 <!-- Delete Button -->
                                 <form action="{{ route('admin.hapus-user', $user->id) }}" method="POST"
                                    id="delete-form-{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $user->id }}')"
                                       class="flex items-center gap-1 text-red-600 dark:text-red-500 hover:underline">
                                       <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                          stroke-width="2" fill="none" stroke-linecap="round"
                                          stroke-linejoin="round">
                                          <polyline points="3 6 5 6 21 6"></polyline>
                                          <path
                                             d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                          </path>
                                          <line x1="10" y1="11" x2="10" y2="17"></line>
                                          <line x1="14" y1="11" x2="14" y2="17"></line>
                                       </svg>
                                       <span>Hapus</span>
                                    </button>
                                 </form>
                              </div>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
            <div class="mt-4">
               {{ $users->links() }}
            </div>
         @else
            <div class="flex flex-col items-center justify-center py-10 text-gray-500 dark:text-gray-400">
               <svg class="w-16 h-16 mb-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                  fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
               </svg>
               <h2 class="text-xl font-semibold">Tidak ada data ditemukan</h2>
               <p class="text-center">Coba gunakan kata kunci lain atau tambahkan data.</p>
            </div>
         @endif
      </div>
   </div>
</div>
