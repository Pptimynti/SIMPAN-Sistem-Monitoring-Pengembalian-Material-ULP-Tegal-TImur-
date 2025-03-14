<x-app-layout>
   <!-- Header -->
   <div class="mb-8">
      <h1 class="text-3xl sm:text-4xl font-bold text-[#1e243a] dark:text-white">Dashboard Admin</h1>
      <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-2">
         Selamat datang kembali, Admin! Berikut ringkasan aktivitas dan data terbaru.
      </p>
   </div>

   <!-- Statistik Pengguna -->
   <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <!-- Kartu Admin -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Admin</h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">{{ $adminCount }}</p>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
               </svg>
            </div>
         </div>
      </div>

      <!-- Kartu Petugas -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Petugas</h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">{{ $petugasCount }}</p>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                  </path>
               </svg>
            </div>
         </div>
      </div>

      <!-- Kartu Manager -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Manager</h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">{{ $managerCount }}</p>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                  </path>
               </svg>
            </div>
         </div>
      </div>

      <!-- Kartu Total Stok -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Total Material
               </h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">
                  {{ $totalMaterial }}</p>
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

   <!-- Grafik dan Tabel -->
   <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
      <!-- Grafik Pengembalian Material -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border dark:shadow-md dark:border-none">
         <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-700 dark:text-gray-200">
               Statistik Pengembalian Material
            </h3>
            <select id="filterBulan"
               class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600
               text-gray-900 dark:text-white text-sm rounded-lg p-2.5">
               <option value="">Semua Bulan</option>
               <option value="1">Januari</option>
               <option value="2">Februari</option>
               <option value="3">Maret</option>
               <option value="4">April</option>
               <option value="5">Mei</option>
               <option value="6">Juni</option>
               <option value="7">Juli</option>
               <option value="8">Agustus</option>
               <option value="9">September</option>
               <option value="10">Oktober</option>
               <option value="11">November</option>
               <option value="12">Desember</option>
            </select>
         </div>
         <div class="h-48 sm:h-64 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
            <canvas id="materialChart" class="w-full h-full">
            </canvas>
         </div>
      </div>

      <!-- Tabel Stok Material -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border dark:shadow-md dark:border-none">
         <h3 class="text-lg sm:text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Stok Material Bekas</h3>
         <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">No</th>
                     <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Nama Material</th>
                     <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Stok Tersedia</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($materialBekas as $return)
                     <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-4 py-2 sm:px-6 sm:py-4">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 sm:px-6 sm:py-4">{{ $return->material->nama }}</td>
                        <td class="px-4 py-2 sm:px-6 sm:py-4 font-bold text-[#136782] dark:text-[#5ab4d4]">
                           {{ $return->stok_tersedia }}</td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <!-- Aktivitas Terbaru -->
   <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border dark:shadow-md dark:border-none">
      <div class="flex justify-between items-center mb-4">
         <h3 class="text-lg sm:text-xl font-semibold text-gray-700 dark:text-gray-200">Aktivitas Terbaru</h3>
         <a href="{{ route('admin.semua-aktivitas') }}"
            class="text-sm sm:text-base text-[#136782] dark:text-[#5ab4d4] hover:underline">
            Lihat Semua Aktivitas
         </a>
      </div>
      <ul class="space-y-3">
         @foreach ($activityLogs as $activity)
            <li
               class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 sm:p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
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
   </div>
</x-app-layout>
<script>
   document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('materialChart');
      let materialChart;

      const fetchData = (bulan = '') => {
         fetch(`/admin/statistik-material?bulan=${bulan}`, {
               method: 'GET',
               headers: {
                  'X-Requested-With': 'XMLHttpRequest'
               }
            })
            .then(response => response.json())
            .then(data => {
               const labels = data.labels;
               const jumlah = data.jumlah;
               const satuan = data.satuan;

               if (materialChart) {
                  materialChart.destroy();
               }

               materialChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                     labels: labels,
                     datasets: [{
                        label: 'Jumlah Pengembalian Material',
                        data: jumlah,
                        backgroundColor: '#136782',
                        borderColor: '#1e243a',
                        borderWidth: 1,
                        borderRadius: 5
                     }]
                  },
                  options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     scales: {
                        x: {
                           ticks: {
                              callback: function(value, index) {
                                 let label = labels[index] || '';
                                 return label.length > 30 ? label.substring(0, 30) + '...' : label;
                              }
                           }
                        },
                        y: {
                           beginAtZero: true
                        }
                     },
                     plugins: {
                        tooltip: {
                           callbacks: {
                              label: function(context) {
                                 const index = context.dataIndex;
                                 const satuanItem = satuan[index] || '';
                                 const value = context.raw || 0;
                                 return `${value} ${satuanItem}`;
                              }
                           }
                        }
                     }
                  }
               });
            });
      }

      fetchData();

      const bulanSelect = document.getElementById('filterBulan');
      if (bulanSelect) {
         bulanSelect.addEventListener('change', function() {
            fetchData(this.value);
         });
      }
   });
</script>
