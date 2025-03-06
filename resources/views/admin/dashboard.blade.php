<x-app-layout>
    <h2 class="text-3xl font-semibold mb-6 text-[#1e243a] dark:text-white">Dashboard Admin</h2>

    {{-- Manajemen User --}}
    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
       <div class="bg-[#136782] text-white p-5 rounded-lg">
          <h3 class="text-xl font-semibold">Jumlah Admin</h3>
          <p class="text-3xl mt-2">{{ $adminCount }}</p>
       </div>
       <div class="bg-[#136782] text-white p-5 rounded-lg">
          <h3 class="text-xl font-semibold">Jumlah Petugas</h3>
          <p class="text-3xl mt-2">{{ $petugasCount }}</p>
       </div>
       <div class="bg-[#136782] text-white p-5 rounded-lg">
          <h3 class="text-xl font-semibold">Jumlah Manager</h3>
          <p class="text-3xl mt-2">{{ $managerCount }}</p>
       </div>
    </div>

    {{-- Ringkasan Stok Material Bekas (Tabel) --}}
    <div class="mt-10">
       <h3 class="text-2xl font-semibold mb-4 text-[#1e243a] dark:text-white">Total Stok Material Bekas</h3>
       <div class="relative overflow-x-auto shadow border sm:rounded-lg w-full">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
             <thead class="text-xs text-white uppercase bg-[#136782] dark:bg-gray-700">
                <tr>
                   <th scope="col" class="px-6 py-3">No</th>
                   <th scope="col" class="px-6 py-3">Nama</th>
                   <th scope="col" class="px-6 py-3">Stok Awal</th>
                   <th scope="col" class="px-6 py-3">Stok Digunakan</th>
                   <th scope="col" class="px-6 py-3">Stok Tersedia</th>
                </tr>
             </thead>
             <tbody>
                @foreach ($materialBekas as $return)
                   <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800 border-b dark:border-gray-700">
                      <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</th>
                      <td class="px-6 py-4">{{ $return->material->nama }}</td>
                      <td class="px-6 py-4">{{ $return->material->materialDikembalikans->sum('jumlah') == 0 ? $return->stok_manual : $return->material->materialDikembalikans->sum('jumlah') + $return->stok_manual }}</td>
                      <td class="px-6 py-4">{{ $return->telah_digunakan }}</td>
                      <td class="px-6 py-4 font-bold text-black dark:text-white text-lg">{{ $return->stok_tersedia }}</td>
                   </tr>
                @endforeach
             </tbody>
          </table>
       </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="mt-10">
       <h3 class="text-2xl font-semibold mb-4 text-[#1e243a] dark:text-white">Aktivitas Terbaru</h3>
       <ul class="mt-4">
          @foreach ($activityLogs as $activity)
             <li class="border-b border-gray-300 dark:border-gray-700 p-2">
                <span class="capitalize">{{ $activity->user->role . ' ' . $activity->user->name }}</span>
                <span>{{ $activity->deskripsi }}</span>
                <span>pada tanggal {{ \Illuminate\Support\Carbon::parse($activity->created_at)->translatedFormat('l, d F Y') }}</span>
                <span>jam {{ \Illuminate\Support\Carbon::parse($activity->created_at)->translatedFormat('H:i') }}</span>
             </li>
          @endforeach
       </ul>
    </div>

    {{-- Statistik Pengembalian --}}
    <div class="mt-10">
       <h3 class="text-2xl font-semibold mb-4 text-[#1e243a] dark:text-white">Statistik Pengembalian Material Bekas</h3>
       <div class="bg-[#f1f5f9] dark:bg-gray-800 p-5 rounded-lg">
          <p class="dark:text-white">Grafik atau tabel frekuensi pengembalian akan ditampilkan di sini.</p>
       </div>
    </div>
 </x-app-layout>
