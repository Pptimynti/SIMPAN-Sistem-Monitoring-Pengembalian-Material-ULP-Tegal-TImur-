<div>
   <div class="flex flex-col gap-4 md:flex-row">
      <!-- Tombol Tambah dan Filter Halaman Sejajar -->
      @if (Auth::user()->role === 'admin' && Auth::user()->role === 'petugas')
         @php $url = Auth::user()->role === 'admin' ? route('admin.halaman-tambah-pengembalian-material') : route('petugas.halaman.tambah.pengembalian-material') @endphp
         <button id="tambahBtn" data-url="{{ $url }}"
            class="flex items-center w-full sm:w-auto gap-2 px-3 py-2.5 text-sm font-medium text-center text-white bg-[#136782] rounded-lg hover:bg-[#155a71] focus:ring-4 focus:outline-none focus:ring-blue-300">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
               stroke-linecap="round" stroke-linejoin="round">
               <line x1="12" y1="5" x2="12" y2="19"></line>
               <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span class="whitespace-nowrap">Tambah Data</span>
         </button>
      @endif
      <div class="flex flex-col sm:flex-row sm:items-center gap-2">
         <div class="w-full sm:w-auto">
            <select wire:model.live.debounce.100ms="perPage" id="perPage"
               class="text-sm text-gray-900 border border-gray-300 rounded-lg w-full sm:w-20 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5">
               <option value="5">5</option>
               <option value="10">10</option>
               <option value="50">50</option>
            </select>
         </div>
      </div>

      <!-- Filter Full Width -->
      <div class="w-full md:w-fit">
         <select name="filterBy" wire:model.live.debounce.150ms="filterBy"
            class="inline-flex items-center bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm p-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 w-full md:w-fit">
            <option value="" selected disabled>Opsi Filter</option>
            <option value="tanggal_pk">Tanggal PK</option>
            <option value="created_at">Tanggal Pengembalian Material</option>
         </select>
      </div>

      <!-- Tanggal Berjejer -->
      <div class="flex flex-col sm:flex-row sm:items-center gap-2">
         <div class="relative w-full sm:w-44">
            <input id="datepicker-range-start" name="start" type="date" wire:model.live.debounce.150ms="startDate"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
         </div>
         <span class="text-gray-500">to</span>
         <div class="relative w-full sm:w-44">
            <input id="datepicker-range-end" name="end" type="date" wire:model.live.debounce.150ms="endDate"
               min="{{ $startDate }}"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
         </div>
      </div>

      <!-- Search Bar -->
      <div class="w-full md:w-80">
         <div class="relative">
            <input wire:model.live.debounce.100ms="search" type="text" id="table-search"
               class="block ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 p-2.5"
               placeholder="Search for items">
         </div>
      </div>
   </div>

   @if ($pekerjaans->count() > 0)
      <div class="relative rounded-md overflow-x-auto shadow sm:rounded-lg mt-2 md:mt-4">
         <table class="w-full text-sm text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
            <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700 dark:text-gray-400">
               <tr>
                  <th scope="col" class="px-6 py-3 border">No</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">No Agenda</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">No PK</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Tanggal PK</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Petugas</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Nama Pelanggan</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Mutasi</th>
                  <th scope="col" class="px-6 py-3 min-w-72 border text-left" colspan="3">Material Dikembalikan
                  </th>
                  @if (Auth::user()->role === 'admin')
                     <th scope="col" class="px-6 py-3 border">Aksi</th>
                  @endif
               </tr>
               <tr>
                  <th scope="col" class="px-6 py-3 border" colspan="7"></th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Nama</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Jumlah</th>
                  <th scope="col" class="px-6 py-3 min-w-32 border">Gambar</th>
                  @if (Auth::user()->role === 'admin')
                     <th scope="col" class="px-6 py-3 border"></th>
                  @endif
               </tr>
            </thead>
            <tbody>
               @foreach ($pekerjaans as $pekerjaan)
                  @php $firstRow = true; @endphp
                  @foreach ($pekerjaan->materialDikembalikans as $materialD)
                     <tr class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                        @if ($firstRow)
                           <th scope="row" class="px-6 py-5 font-medium text-gray-900 dark:text-white border"
                              rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $loop->parent->iteration }}
                           </th>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $pekerjaan->no_agenda }}
                           </td>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $pekerjaan->no_pk }}
                           </td>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ \Illuminate\Support\Carbon::parse($pekerjaan->tanggal_pk)->isoFormat('D MMM Y') }}
                           </td>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $pekerjaan->petugas }}
                           </td>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $pekerjaan->nama_pelanggan }}
                           </td>
                           <td class="px-6 py-5 border" rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                              {{ $pekerjaan->mutasi }}
                           </td>
                        @endif
                        <td class="px-6 py-5 border">{{ $materialD->material->nama }}</td>
                        <td class="px-6 py-5 font-bold text-gray-800 dark:text-white border">
                           {{ $materialD->jumlah . ' ' . $materialD->material->satuan }}
                        </td>
                        <td class="px-6 py-5 border">
                           <div class="flex flex-wrap gap-2">
                              @foreach ($materialD->gambarMaterials as $gambar)
                                 <img role="button" data-src="{{ asset('storage/' . $gambar->gambar) }}"
                                    src="{{ asset('storage/' . $gambar->gambar) }}" alt="{{ $materialD->nama }}"
                                    class="materialImages w-20 h-20 object-cover rounded border">
                              @endforeach
                           </div>
                        </td>
                        @if ($firstRow)
                           @if (Auth::user()->role === 'admin')
                              <td class="px-6 py-5 text-center border"
                                 rowspan="{{ count($pekerjaan->materialDikembalikans) }}">
                                 <div class="flex items-center justify-center h-full gap-2">
                                    <a href="{{ route('admin.edit.pengembalian-material', $pekerjaan->id) }}"
                                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center gap-1">
                                       <svg class="w-4 h-4" viewBox="0 0 24 24" width="24" height="24"
                                          stroke="currentColor" stroke-width="2" fill="none"
                                          stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                       </svg>
                                       Edit
                                    </a>
                                    <form action="{{ route('admin.hapus.pengembalian-material', $pekerjaan->id) }}"
                                       method="POST" id="delete-form-{{ $pekerjaan->id }}">
                                       @csrf
                                       @method('DELETE')
                                       <button type="button" onclick="confirmDelete('{{ $pekerjaan->id }}')"
                                          class="font-medium text-red-600 dark:text-red-500 hover:underline flex items-center gap-1">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" class="w-5 h-5">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                          </svg>
                                          Hapus
                                       </button>
                                    </form>
                                 </div>
                              </td>
                           @endif
                           @php $firstRow = false; @endphp
                        @endif
                     </tr>
                  @endforeach
               @endforeach
            </tbody>
         </table>
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
