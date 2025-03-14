<x-app-layout>
   <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Tombol Kembali -->
      <div class="mb-6">
         @php $url = Auth::user()->role === 'admin' ? route('admin.dashboard') : route('manager.dashboard') @endphp
         <a href="{{ $url }}"
            class="inline-flex items-center text-sm text-[#136782] dark:text-[#5ab4d4] hover:text-[#0e4e63] dark:hover:text-[#4a9db8]">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
               </path>
            </svg>
            Kembali
         </a>
      </div>

      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border dark:shadow-md dark:border-none">
         <!-- Judul Halaman -->
         <h1 class="text-2xl sm:text-3xl font-bold text-gray-700 dark:text-gray-200 mb-6">Semua Aktivitas</h1>

         <!-- Daftar Aktivitas -->
         <ul class="space-y-4">
            @foreach ($activityLogs as $activity)
               <li
                  class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 sm:p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                  <div class="mb-2 sm:mb-0">
                     <!-- Deskripsi Aktivitas -->
                     <p class="text-sm sm:text-base text-gray-700 dark:text-gray-200 capitalize">
                        {{ $activity->deskripsi }}
                     </p>

                     <!-- Material -->
                     @if ($activity->pekerjaan_id !== null)
                        <p class="text-sm sm:text-base text-gray-700 dark:text-gray-200 mt-1">
                           @php
                              $data = [];

                              foreach ($activity->pekerjaan->materialDikembalikans as $material) {
                                  $data[] =
                                      $material->material->nama .
                                      ' ' .
                                      $material->jumlah .
                                      ' ' .
                                      $material->material->satuan;
                              }

                              $dataList = implode(', ', $data);
                           @endphp
                           Material: <span>{{ $dataList }}</span>
                        </p>
                     @elseif ($activity->material_bekas_id !== null)
                        <p class="text-sm sm:text-base text-gray-700 dark:text-gray-200 capitalize">
                           {{ $activity->deskripsi }}
                        </p>
                     @endif

                     <!-- Role dan Nama User -->
                     <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 capitalize mt-1">
                        {{ $activity->user->role }} - {{ $activity->user->name }}
                     </p>
                  </div>

                  <!-- Tanggal dan Waktu -->
                  <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                     {{ \Illuminate\Support\Carbon::parse($activity->created_at)->translatedFormat('d M Y, H:i') }}
                  </p>
               </li>
            @endforeach
         </ul>

         <!-- Pagination -->
         <div class="mt-4">
            {{ $activityLogs->links() }}
         </div>
      </div>
   </div>
</x-app-layout>
