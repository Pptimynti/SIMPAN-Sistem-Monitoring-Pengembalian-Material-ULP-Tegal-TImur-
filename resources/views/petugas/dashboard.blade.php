<x-app-layout>
   <!-- Header -->
   <div class="bg-white p-6 rounded-lg shadow-md mb-4">
      <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, <span
            class="text-[#136782]">{{ Auth::user()->name }}</span></h1>
   </div>

   <!-- Quick Stats -->
   <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Pengembalian Material Hari
                  Ini
               </h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">
                  {{ $totalPengembalianMaterialByUser }}</p>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
               </svg>
            </div>
         </div>
      </div>
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Total Material
                  Dikembalikan
               </h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">
                  {{ $totalPengembalianMaterialByUser }}</p>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
               </svg>
            </div>
         </div>
      </div>
   </div>

   <!-- Daftar Pengembalian Terbaru -->
   <div class="bg-white p-6 rounded-lg shadow-md mb-8">
      <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Pengembalian Terbaru</h2>
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
         <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700">
            <tr>
               <th scope="col" class="px-6 py-3 border">No</th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Tanggal</th>
               <th scope="col" class="px-6 py-3 min-w-72 border text-left" colspan="3">Material Dikembalikan
               </th>
            </tr>
            <tr>
               <th scope="col" class="px-6 py-3 border" colspan="2"></th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Nama</th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Jumlah</th>
               <th scope="col" class="px-6 py-3 min-w-32 border">Gambar</th>
               @if (Auth::user()->role === 'admin')
                  <th scope="col" class="px-6 py-3 border"></th>
               @endif
            </tr>
         </thead>
         <tbody>
            @foreach ($pengembalianMaterial as $pengembalian)
               @php $firstRow = true; @endphp
               @foreach ($pengembalian->materialDikembalikans as $materialD)
                  <tr class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                     @if ($firstRow)
                        <th scope="row" class="px-6 py-5 font-medium text-gray-900 dark:text-white border"
                           rowspan="{{ count($pengembalian->materialDikembalikans) }}">
                           {{ $loop->parent->iteration }}
                        </th>
                        <td class="px-6 py-5 border" rowspan="{{ count($pengembalian->materialDikembalikans) }}">
                           {{ \Illuminate\Support\Carbon::parse($pengembalian->created_at)->isoFormat('D MMM Y') }}
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
                        @php $firstRow = false; @endphp
                     @endif
                  </tr>
               @endforeach
            @endforeach
         </tbody>
      </table>
   </div>
</x-app-layout>
