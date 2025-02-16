<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

   <title>{{ config('app.name', 'Laravel') }}</title>

   <!-- Fonts -->
   <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Playfair+Display:wght@400..700&display=swap"
      rel="stylesheet">

   <!-- Scripts -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])

   <!--Livewire -->
   @livewireStyles

   <style>
      [x-cloak] {
         display: none !important;
      }
   </style>
</head>

<body x-cloak x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode === true }"
   class="antialiased">
   <div class="min-h-screen bg-white dark:bg-gray-800 dark:text-white">
      {{-- @include('layouts.navigation') --}}

      <!-- Heading -->
      <div class="inset-x-0 top-0 bg-[#136782] h-16 flex justify-between p-2 items-center dark:bg-gray-700 md:p-4">
         <button id="toggleSB" type="button">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2" fill="none"
               stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
               <line x1="3" y1="12" x2="21" y2="12"></line>
               <line x1="3" y1="6" x2="21" y2="6"></line>
               <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
         </button>
         <div class="flex items-center">
            <button @click="darkMode=!darkMode" type="button"
               class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-zinc-200 dark:bg-zinc-700 w-11 focus:outline-none focus:ring-2 focus:ring-neutral-700 focus:ring-offset-2 dark:border-white"
               role="switch" aria-checked="false">
               <span class="sr-only">Use setting</span>
               <span
                  class="relative inline-block w-5 h-5 transition duration-500 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none dark:translate-x-5 ring-0">
                  <span
                     class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-500 ease-in opacity-100 dark:opacity-0 dark:duration-100 dark:ease-out"
                     aria-hidden="true">
                     <svg xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-sun w-4 h-4 text-neutral-700" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path
                           d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7">
                        </path>
                     </svg>
                  </span>
                  <span
                     class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-100 ease-out opacity-0 dark:opacity-100 dark:duration-200 dark:ease-in"
                     aria-hidden="true">
                     <svg xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-moon w-4 h-4 text-neutral-700" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                     </svg>
                  </span>
               </span>
            </button>
            <div class="flex items-center ms-3">
               <div>
                  <button type="button"
                     class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                     aria-expanded="false" data-dropdown-toggle="dropdown-user">
                     <span class="sr-only">Open user menu</span>
                     <img class="w-8 h-8 rounded-full" src="" alt="user photo">
                  </button>
               </div>
               <div
                  class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                  id="dropdown-user">
                  <div class="px-4 py-3" role="none">
                     <p class="text-sm text-gray-900 dark:text-white" role="none">
                        Neil Sims
                     </p>
                     <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                        neil.sims@flowbite.com
                     </p>
                  </div>
                  <ul class="py-1" role="none">
                     <li>
                        <a href="#"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                           role="menuitem">Dashboard</a>
                     </li>
                     <li>
                        <a href="#"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                           role="menuitem">Settings</a>
                     </li>
                     <li>
                        <a href="#"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                           role="menuitem">Earnings</a>
                     </li>
                     <li>
                        <a href="#"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                           role="menuitem">Sign out</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>

      <!-- Sidebar -->
      <div id="sidebar"
         class="fixed inset-y-0 w-72 bg-[#1e243a] p-4 -translate-x-72 transition-all duration-150 z-20">
         <div class="w-full flex gap-2">
            <img src="{{ asset('images/pln.png') }}" alt="" class="w-14 h-14">
            <div>
               <h1 class="text-white font-bold leading-5">MONITORING MATERIAL SISTEM</h1>
               <p class="text-sm text-white font-light">ULP Tegal Timur</p>
            </div>
         </div>
         <div class="w-full border-[.5px] border-white mt-4"></div>
         <div class="w-full mt-4">
            <!-- Menu -->
            <div id="dashboard" data-url="{{ route('admin.dashboard') }}" role="button"
               class="w-full flex gap-4 items-center group py-2 mb-3">
               <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                  fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
               </svg>
               <p class="text-white text-lg group-hover:text-blue-gray-200">Dashboard</p>
            </div>
            <div id="pengembalianMaterial" data-url="{{ route('admin.pengembalian-material') }}" role="button"
               class="w-full flex gap-4 items-center group py-2 mb-3">
               <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                  fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                  <polyline points="9 10 4 15 9 20"></polyline>
                  <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
               </svg>
               <p class="text-white text-lg group-hover:text-blue-gray-200">Pengembalian Material</p>
            </div>
            <div id="rekap" data-url="{{ route('admin.laporan.pengembalian-material') }}" role="button"
               class="w-full flex gap-4 items-center group py-2 mb-3">
               <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                  fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                  <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
               </svg>
               <p class="text-white text-lg group-hover:text-blue-gray-200">Rekapan</p>
            </div>
         </div>
      </div>

      <!-- Overlay -->
      <div id="overlay"
         class="inset-x-0 inset-y-0 fixed bg-black opacity-0 transition-opacity duration-150 pointer-events-none z-10">
      </div>

      <!-- Page Content -->
      <main class="px-2 py-4 md:py-6 md:px-4">
         {{ $slot }}
      </main>
   </div>
   @livewireScripts
   <script>
      let btnToggleSB = document.getElementById('toggleSB');
      let sidebar = document.getElementById('sidebar');
      let overlay = document.getElementById('overlay');

      btnToggleSB.addEventListener('click', function() {
         sidebar.classList.remove('-translate-x-72');
         sidebar.classList.add('translate-x-0');
         overlay.classList.remove('opacity-0');
         overlay.classList.add('opacity-70');
      });

      document.addEventListener('click', function(event) {
         if (!sidebar.contains(event.target) && !btnToggleSB.contains(event.target)) {
            sidebar.classList.add('-translate-x-72');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('opacity-0');
            overlay.classList.remove('opacity-70');
         }
      });

      let links = document.querySelectorAll('#dashboard, #pengembalianMaterial, #rekap');
      links.forEach(btn => {
         btn.addEventListener('click', function() {
            let link = this.dataset.url;
            window.location.href = link;
         })
      });
   </script>
</body>

</html>
