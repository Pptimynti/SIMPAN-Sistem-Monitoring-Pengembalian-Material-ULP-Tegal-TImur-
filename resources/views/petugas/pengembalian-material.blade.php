<x-app-layout>
   @livewire('tabel-pengembalian-material-petugas')
</x-app-layout>
<x-script>
   <script>
      let tambahBtn = document.getElementById('tambahBtn');
      tambahBtn.addEventListener('click', function() {
         window.location.href = this.dataset.url;
      })
   </script>
   <script>
      document.addEventListener("DOMContentLoaded", function() {
         @if (session('success'))
            Swal.fire({
               title: "{{ session('success') }}",
               icon: "success",
               draggable: true
            });
         @endif
      });
   </script>
</x-script>
<x-script>
   <script>
      let imagesLink = document.querySelectorAll('.materialImages');
      let overlayModal = document.getElementById('overlayModal');
      let modalImage = document.getElementById('modalImage');
      let containerModal = document.getElementById('containerModal');
      imagesLink.forEach(image => {
         image.addEventListener('click', function(event) {
            event.stopPropagation();
            let src = this.dataset.src;
            containerModal.classList.remove('pointer-events-none');
            overlayModal.classList.remove('opacity-0');
            overlayModal.classList.add('opacity-70');
            modalImage.classList.remove('-translate-y-[99rem]');
            modalImage.classList.add('-translate-y-1/2');

            modalImage.setAttribute('src', src);
         });
      });

      document.addEventListener('click', function(event) {
         if (!modalImage.contains(event.target)) {
            containerModal.classList.add('pointer-events-none');
            overlayModal.classList.add('opacity-0');
            overlayModal.classList.remove('opacity-70');
            modalImage.classList.add('-translate-y-[99rem]');
            modalImage.classList.remove('-translate-y-1/2');
         }
      });
   </script>
</x-script>
