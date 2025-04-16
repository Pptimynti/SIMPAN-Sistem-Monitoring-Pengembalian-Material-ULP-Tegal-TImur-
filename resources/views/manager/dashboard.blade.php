<x-app-layout>
   <!-- Header -->
   <div class="mb-8">
      <h1 class="text-3xl sm:text-4xl font-bold text-[#1e243a] dark:text-white">Dashboard Manager</h1>
      <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-2">
         Selamat datang kembali, Manager! Berikut ringkasan aktivitas dan data terbaru.
      </p>
   </div>

   <!-- Statistik Utama -->
   <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
      <!-- Kartu Total Material Sisa -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Total Material</h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">{{ $totalMaterial }}</p>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
               </svg>
            </div>
         </div>
      </div>

      <!-- Kartu Material Sisa Dipakai Kembali -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Material Dipakai Kembali
               </h3>
               <div class="flex items-end gap-2">
                  <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">
                     {{ $totalMaterialBekasDipake }}</p>
               </div>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                  </path>
               </svg>
            </div>
         </div>
      </div>

      <!-- Kartu Persentase Material Dipakai Kembali -->
      <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
         <div class="flex items-center justify-between">
            <div>
               <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Material Return</h3>
               <p class="text-2xl sm:text-3xl font-bold text-[#136782] dark:text-[#5ab4d4]">
                  {{ $materialBekas->count() }}</p>
            </div>
            <div class="p-2 sm:p-3 bg-[#136782] rounded-full">
               <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                  </path>
               </svg>
            </div>
         </div>
      </div>
   </div>

   <!-- Grafik Tren Penggunaan Material Sisa -->
   <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border dark:shadow-md dark:border-none mb-8">
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

   <!-- Tabel Detail Material Sisa yang Sudah Dipakai Kembali -->
   @if ($materialSisa->count() > 0)
      <div
         class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border dark:shadow-md dark:border-none mb-8">
         <h3 class="text-lg sm:text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Material Sisa yang Sudah
            Dipakai Kembali</h3>
         <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Nama Material</th>
                     <th scope="col" class="px-4 py-2 sm:px-6 sm:py-3">Jumlah</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($materialSisa as $ms)
                     <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-4 py-2 sm:px-6 sm:py-4">{{ $ms->material->nama }}</td>
                        <td class="px-4 py-2 sm:px-6 sm:py-4 font-bold text-[#136782] dark:text-[#5ab4d4]">
                           {{ $ms->telah_digunaka . ' ' . $ms->material->satuan }}</td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   @endif

   <!-- Aktivitas Terbaru -->
   <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border dark:shadow-md dark:border-none">
      <div class="flex justify-between items-center mb-4">
         <h3 class="text-lg sm:text-xl font-semibold text-gray-700 dark:text-gray-200">Aktivitas Terbaru</h3>
         <a href="{{ route('manager.semua-aktivitas') }}"
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
   </div>
</x-app-layout>
<script>
   document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('materialChart');
      let materialChart;

      const fetchData = (bulan = '') => {
         fetch(`/manager/statistik-material?bulan=${bulan}`, {
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
