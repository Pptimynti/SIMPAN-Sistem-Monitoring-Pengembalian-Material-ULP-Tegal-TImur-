<x-app-layout>
   @livewire('tabel-user')
</x-app-layout>
<x-script>
   <script>
      let tmbhUserBtn = document.getElementById('tmbhUserBtn');

      tmbhUserBtn.addEventListener('click', function() {
         window.location.href = this.dataset.url;
      });
   </script>
</x-script>
