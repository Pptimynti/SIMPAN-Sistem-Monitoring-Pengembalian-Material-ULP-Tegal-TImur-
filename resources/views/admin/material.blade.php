<x-app-layout>
   @livewire('tabel-material')
</x-app-layout>
<x-script>
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         @if (session('success'))
            Swal.fire({
               title: "Berhasil!",
               icon: "success",
               draggable: true
            });
         @elseif (session('error'))
            Swal.fire({
               title: "Gagal!",
               icon: "error",
               draggable: true
            });
         @endif
      });
   </script>
</x-script>
