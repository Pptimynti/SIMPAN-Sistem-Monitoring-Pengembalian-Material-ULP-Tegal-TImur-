<div>
   <div class="flex flex-col gap-2 md:gap-32 md:flex-row md:items-center lg:justify-between">
      <div class="pb-4 bg-white dark:bg-gray-800 md:pt-3 flex flex-col md:flex-row items-center w-full gap-2">
         <div class="flex items-center gap-2 w-full">
            <div class="md:pt-1">
               <select wire:model.live.debounce.100ms="perPage" id="perPage"
                  class="text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="50">50</option>
               </select>
            </div>
            <div class="md:hidden">
               <div class="pt-1">
                  <button id="openModalBtn" data-modal-target="userModal" type="button"
                     data-tooltip-target="tooltip-right" data-tooltip-placement="right"
                     class="flex items-center w-auto gap-2 px-3 py-2.5 text-sm font-medium text-center text-white bg-[#136782] rounded-lg hover:bg-[#155a71] focus:ring-4 focus:outline-none focus:ring-blue-300 md:hidden">
                     <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                     </svg>
                     <span class="whitespace-nowrap">Tambah User</span>
                  </button>
               </div>
            </div>
         </div>
         <div class="w-full">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative mt-1">
               <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                  </svg>
               </div>
               <input wire:model.live.debounce.100ms="search" type="text" id="table-search"
                  class="block ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5"
                  placeholder="Search for items">
            </div>
         </div>
      </div>
   </div>
   @if ($users->count() > 0)
      <div class="relative overflow-x-auto rounded-lg shadow border border-gray-300 dark:border-gray-700">
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
               @foreach ($users as $user)
                  <tr
                     class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                     <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $loop->iteration }}
                     </th>
                     <td class="px-6 py-4">
                        {{ $user->name }}
                     </td>
                     <td class="px-6 py-4">
                        {{ $user->email }}
                     </td>
                     <td class="px-6 py-4">
                        {{ $user->role }}
                     </td>
                     <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center h-full gap-2">
                           <button type="submit" data-modal-target="userModalEdit" data-id="{{ $user->id }}"
                              class="edit-user-button font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center gap-1">
                              <svg class="w-4 h-4" viewBox="0 0 24 24" width="24" height="24"
                                 stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round">
                                 <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                 <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                              </svg>
                              <span>Edit</span>
                           </button>
                           <form action="{{ route('admin.hapus-user', $user->id) }}" method="POST"
                              id="delete-form-{{ $user->id }}">
                              @csrf
                              @method('DELETE')
                              <button type="button" onclick="confirmDelete('{{ $user->id }}')"
                                 class="flex items-center gap-1 font-medium text-red-600 dark:text-red-500 hover:underline">
                                 <div class="flex items-center">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                       stroke-width="2" fill="none" stroke-linecap="round"
                                       stroke-linejoin="round" class="css-i6dzq1 w-4 h-4">
                                       <polyline points="3 6 5 6 21 6"></polyline>
                                       <path
                                          d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                       </path>
                                       <line x1="10" y1="11" x2="10" y2="17"></line>
                                       <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    <span>Hapus</span>
                                 </div>
                              </button>
                           </form>
                        </div>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      <div class="mt-2">
         {{ $users->links() }}
      </div>
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
