<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Rekap Pengembalian Material</title>
</head>

<body>
   <h2 class="text-center font-bold text-lg">
      Rekap Pengembalian Material PLN ULP Tegal Timur
   </h2>
   <h3 class="text-center text-md">
      Per Hari {{ \Illuminate\Support\Carbon::now()->isoFormat('dddd, D MMM Y') }}
   </h3>
   <table class="mt-24" border="1" cellspacing="0" cellpadding="5" width="100%">
      <thead>
         <tr>
            <th>No</th>
            <th>No Agenda</th>
            <th>Petugas</th>
            <th>Nama Pelanggan</th>
            <th>Mutasi</th>
            <th colspan="3" align="left">Material Dikembalikan</th>
         </tr>
         <tr>
            <th colspan="5"></th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Gambar</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($pekerjaans as $pekerjaan)
            @php $firstRow = true; @endphp
            @foreach ($pekerjaan->materialDikembalikans as $materialD)
               <tr>
                  @if ($firstRow)
                     <th rowspan="{{ count($pekerjaan->materialDikembalikans) }}">{{ $loop->parent->iteration }}</th>
                     <td rowspan="{{ count($pekerjaan->materialDikembalikans) }}">{{ $pekerjaan->no_agenda }}</td>
                     <td rowspan="{{ count($pekerjaan->materialDikembalikans) }}">{{ $pekerjaan->petugas }}</td>
                     <td rowspan="{{ count($pekerjaan->materialDikembalikans) }}">{{ $pekerjaan->nama_pelanggan }}</td>
                     <td rowspan="{{ count($pekerjaan->materialDikembalikans) }}">{{ $pekerjaan->mutasi }}</td>
                  @endif
                  <td>{{ $materialD->material->nama }}</td>
                  <td><strong>x{{ $materialD->jumlah }}</strong></td>
                  <td class="text-center">
                     @foreach ($materialD->gambarMaterials as $gambar)
                        @php
                           $path = storage_path('app/public/' . $gambar->gambar);
                           if (file_exists($path)) {
                               $type = pathinfo($path, PATHINFO_EXTENSION);
                               $data = file_get_contents($path);
                               $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                           } else {
                               $base64 = null;
                           }
                        @endphp
                        @if ($base64)
                           <img src="{{ $base64 }}" alt="{{ $materialD->nama }}" width="100" height="100">
                        @else
                           <p>Gambar tidak ditemukan</p>
                        @endif
                     @endforeach
                  </td>
                  @php $firstRow = false; @endphp
               </tr>
            @endforeach
         @endforeach
      </tbody>
   </table>
</body>

</html>
