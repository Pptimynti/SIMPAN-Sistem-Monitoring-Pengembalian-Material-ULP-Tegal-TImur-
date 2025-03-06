<x-app-layout>
   @livewire('tabel-pengembalian-material')
</x-app-layout>
<x-script>
   <script>
      function confirmDelete(id) {
         Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus dan tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
         }).then((result) => {
            if (result.isConfirmed) {
               document.getElementById(`delete-form-${id}`).submit();
            }
         });
      }

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

      if (modalImage) {
         document.addEventListener('click', function(event) {
            if (!modalImage.contains(event.target)) {
               containerModal.classList.add('pointer-events-none');
               overlayModal.classList.add('opacity-0');
               overlayModal.classList.remove('opacity-70');
               modalImage.classList.add('-translate-y-[99rem]');
               modalImage.classList.remove('-translate-y-1/2');
            }
         });
      }


      document.getElementById('tambahBtn').addEventListener('click', (event) => {
         window.location.href = event.currentTarget.dataset.url;
      });
   </script>
</x-script>
