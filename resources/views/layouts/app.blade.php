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

      .loader {
         width: 70px;
         aspect-ratio: 1;
         background:
            radial-gradient(farthest-side, #ffa516 90%, #0000) center/16px 16px,
            radial-gradient(farthest-side, green 90%, #0000) bottom/12px 12px;
         background-repeat: no-repeat;
         animation: l17 1s infinite linear;
         position: relative;
      }

      .loader::before {
         content: "";
         position: absolute;
         width: 8px;
         aspect-ratio: 1;
         inset: auto 0 16px;
         margin: auto;
         background: #ccc;
         border-radius: 50%;
         transform-origin: 50% calc(100% + 10px);
         animation: inherit;
         animation-duration: 0.5s;
      }

      @keyframes l17 {
         100% {
            transform: rotate(1turn)
         }
      }

      .form-loader {
         width: 50px;
         padding: 8px;
         aspect-ratio: 1;
         border-radius: 50%;
         background: #25b09b;
         --_m:
            conic-gradient(#0000 10%, #000),
            linear-gradient(#000 0 0) content-box;
         -webkit-mask: var(--_m);
         mask: var(--_m);
         -webkit-mask-composite: source-out;
         mask-composite: subtract;
         animation: l3 1s infinite linear;
      }

      @keyframes l3 {
         to {
            transform: rotate(1turn)
         }
      }

      .ts-control {
         padding: 0.625rem !important;
         background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1)) !important;
         border: 1px solid rgb(209 213 219) !important;
         border-radius: 0.5rem !important;
         color: rgb(17 24 39) !important;
         font-size: 0.875rem !important;
         font-family: 'Poppins', sans-serif !important;
         font-weight: 500 !important;
      }

      .dark .ts-control {
         background-color: rgb(55 65 81) !important;
         border: 1px solid rgb(75 85 99) !important;
         color: rgb(255 255 255) !important;
         font-family: 'Poppins', sans-serif !important;
         font-weight: 500 !important;
      }

      .ts-control::placeholder {
         color: rgb(107 114 128) !important;
      }

      .dark .ts-control::placeholder {
         color: rgb(255 255 255) !important;
      }

      .ts-dropdown {
         background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1)) !important;
         border: 1px solid rgb(209 213 219) !important;
         border-radius: 0.5rem !important;
         padding: 0.5rem !important;
         box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
      }

      .dark .ts-dropdown {
         background-color: rgb(55 65 81) !important;
         border: 1px solid rgb(75 85 99) !important;
      }

      .ts-dropdown .option {
         padding: 0.625rem !important;
         color: rgb(17 24 39) !important;
         font-size: 0.875rem !important;
         border-radius: 0.375rem !important;
         font-family: 'Poppins', sans-serif !important;
         font-weight: 500 !important;
      }

      .dark .ts-dropdown .option {
         background-color: rgb(31 41 55) !important;
         color: rgb(255 255 255) !important;
         font-family: 'Poppins', sans-serif !important;
         font-weight: 500 !important;
      }

      .dark .ts-dropdown .option:hover {
         background-color: rgb(75 85 99) !important;
      }
   </style>
</head>

<body x-cloak x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode === true }"
   class="antialiased">
   <div class="min-h-screen bg-gray-100 dark:bg-gray-800 dark:text-white">
      {{-- @include('layouts.navigation') --}}

      <!-- Heading -->
      <div
         class="inset-x-0 top-0 fixed bg-[#136782] h-16 flex justify-between p-4 items-center dark:bg-gray-700 shadow-lg z-10">
         <button id="toggleSB" type="button" class="p-2 rounded-lg hover:bg-[#0e4d63] transition-colors">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2" fill="none"
               stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
               <line x1="3" y1="12" x2="21" y2="12"></line>
               <line x1="3" y1="6" x2="21" y2="6"></line>
               <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
         </button>
         <div class="flex items-center gap-4">
            <button @click="darkMode=!darkMode" type="button"
               class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-zinc-200 dark:bg-zinc-700 w-11 focus:outline-none focus:ring-2 focus:ring-neutral-700 focus:ring-offset-2 dark:border-white hover:bg-zinc-300 dark:hover:bg-zinc-600"
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
            <div class="flex items-center">
               <div>
                  <button type="button"
                     class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 hover:bg-gray-700 transition-colors"
                     aria-expanded="false" data-dropdown-toggle="dropdown-user">
                     <span class="sr-only">Open user menu</span>
                     @php $urlGambar = Auth::user()->role === 'admin' ? asset('storage/images/woman.png') : (Auth::user()->role === 'manager' ? asset('storage/images/profile.png') : asset('storage/images/petugas.png')) @endphp
                     <img class="w-8 h-8 rounded-full" src="{{ $urlGambar }}" alt="user photo">
                  </button>
               </div>
               <div
                  class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                  id="dropdown-user">
                  <div class="px-4 py-3" role="none">
                     <p class="text-sm text-gray-900 dark:text-white" role="none">
                        {{ Auth::user()->name }}
                     </p>
                     <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                        {{ Auth::user()->email }}
                     </p>
                  </div>
                  <ul class="py-1" role="none">
                     <li>
                        @php $url = Auth::user()->role === 'admin' ? route('admin.profile-edit') : (Auth::user()->role === 'manager' ? route('manager.profile-edit') : route('petugas.profile-edit')) @endphp
                        <button id="profileButton" type="button" data-url="{{ $url }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left"
                           role="menuitem">User Profile</button>
                     </li>
                     <li>
                        <form action="{{ route('logout') }}" method="POST"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                           @csrf
                           <button class="w-full block text-left" type="submit" role="menuitem">Sign out</button>
                        </form>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>

      <!-- Sidebar -->
      <div id="sidebar"
         class="fixed inset-y-0 w-72 bg-[#1e243a] p-4 -translate-x-72 transition-all duration-150 z-20 lg:translate-x-0 dark:bg-gray-600 lg:transition-none lg:duration-0">
         <div class="w-full flex items-center gap-3">
            <img src="{{ asset('images/pln.png') }}" alt="Logo PLN" class="w-20 h-20">

            <div>
               <!-- Judul SIMPAN -->
               <h1 class="text-white font-bold text-xl leading-tight">SIMPAN</h1>

               <h2 class="text-white font-semibold text-sm leading-tight mt-1">
                  Sistem Monitoring Pengembalian Material
               </h2>

               <p class="text-white font-light text-xs mt-1">
                  ULP Tegal Timur
               </p>
            </div>
         </div>
         <div class="w-full border-[.5px] border-white mt-4"></div>
         <div class="w-full mt-4">
            <!-- Menu -->
            <div id="dashboard"
               @php $dashboardUrl = Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'petugas' ? route('petugas.dashboard') : (Auth::user()->role === 'manager' ? route('manager.dashboard') : null)); @endphp
               @if ($dashboardUrl) data-url="{{ $dashboardUrl }}" @endif role="button"
               class="w-full flex gap-4 items-center group py-2 mb-3">

               <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                  fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
               </svg>

               <p class="text-white text-lg group-hover:text-blue-gray-200">Dashboard</p>
            </div>
            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager')
               @if (Auth::user()->role === 'admin')
                  <div id="materials" data-url="{{ route('admin.daftar-material') }}" role="button"
                     class="w-full flex gap-4 items-center group py-2 mb-3">
                     <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                     </svg>
                     <p class="text-white text-lg group-hover:text-blue-gray-200">Data Material</p>
                  </div>
                  <div id="users" data-url="{{ route('admin.users') }}" role="button"
                     class="w-full flex gap-4 items-center group py-2 mb-3">
                     <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                     </svg>
                     <p class="text-white text-lg group-hover:text-blue-gray-200">Data User</p>
                  </div>
                  <div id="pengembalianMaterial" data-url="{{ route('admin.pengembalian-material') }}"
                     role="button" class="w-full flex gap-4 items-center group py-2 mb-3">
                     <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="9 10 4 15 9 20"></polyline>
                        <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                     </svg>
                     <p class="text-white text-lg group-hover:text-blue-gray-200">Pengembalian Material</p>
                  </div>
               @endif
               @php $stokUrl = Auth::user()->role === 'admin' ? route('admin.material-return') : (Auth::user()->role === 'manager' ? route('manager.stok-material-return') : null) @endphp
               <div id="stokMaterialReturn" data-url="{{ $stokUrl }}" role="button"
                  class="w-full flex gap-4 items-center group py-2 mb-3">
                  <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                     <polyline points="21 8 21 21 3 21 3 8"></polyline>
                     <rect x="1" y="3" width="22" height="5"></rect>
                     <line x1="10" y1="12" x2="14" y2="12"></line>
                  </svg>
                  <p class="text-white text-lg group-hover:text-blue-gray-200">Stok Material Return</p>
               </div>
               @php $rekapUrl = Auth::user()->role === 'admin' ? route('admin.laporan.pengembalian-material') : (Auth::user()->role === 'manager' ? route('manager.rekap-pengembalian') : null) @endphp
               <div id="rekap" data-url="{{ $rekapUrl }}" role="button"
                  class="w-full flex gap-4 items-center group py-2 mb-3">
                  <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                     <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                     <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                  </svg>
                  <p class="text-white text-lg group-hover:text-blue-gray-200">Rekap Data</p>
               </div>
            @else
               <div id="pengembalianMaterialPetugas" data-url="{{ route('petugas.pengembalian-material') }}"
                  role="button" class="w-full flex gap-4 items-center group py-2 mb-3">
                  <svg viewBox="0 0 24 24" width="24" height="24" stroke="white" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                     <polyline points="9 10 4 15 9 20"></polyline>
                     <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                  </svg>
                  <p class="text-white text-lg group-hover:text-blue-gray-200">Pengembalian Material</p>
               </div>
            @endif
         </div>
      </div>

      <!-- Overlay -->
      <div id="overlay"
         class="inset-x-0 inset-y-0 fixed bg-black opacity-0 transition-opacity duration-150 pointer-events-none z-10">
      </div>

      <!-- Page Content -->
      <main class="px-2 pt-20 pb-10 md:px-4 md:pt-24 md:pb-12 lg:ml-72">
         {{ $slot }}
      </main>

      <!-- Footer -->
      <div class="mt-8 text-center text-sm text-gray-600 ml-72 py-4">
         <p>© 2025 SIMPAN | PLN ULP Tegal Timur. All rights reserved.</p>
      </div>

      <!-- Preloader -->
      <div id="preloader"
         class="inset-0 bg-white fixed z-[999] flex justify-center items-center transition-opacity duration-500">
         <div class="loader"></div>
      </div>

      <!-- Form Loader -->
      <div id="formLoader"
         class="inset-0 bg-white fixed z-[999] hidden justify-center items-center transition-opacity duration-500">
         <div class="form-loader"></div>
      </div>
   </div>
   @livewireScripts
   <script>
      let btnToggleSB = document.getElementById('toggleSB');
      let sidebar = document.getElementById('sidebar');
      let overlay = document.getElementById('overlay');

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

      document.getElementById("DOMContentLoaded", function() {
         let form = document.querySelectorAll('.form-submit');
         let preloader = document.getElementById('formLoader');

         form.addEventListener('submit', function() {
            preloader.classList.remove('hidden');
            preloader.classList.add('flex');
         });
      });

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

      let links = document.querySelectorAll(
         '#dashboard, #pengembalianMaterial, #rekap, #pengembalianMaterialPetugas, #users, #stokMaterialReturn, #materials, #profileButton',
      );

      links.forEach(btn => {
         btn.addEventListener('click', function() {
            let link = this.dataset.url;
            window.location.href = link;
         })
      });


      window.addEventListener("load", function() {
         let preloader = document.querySelector('#preloader');

         if (preloader) {
            preloader.classList.add("opacity-0");

            setTimeout(() => {
               preloader.classList.add("hidden");
            }, 500);
         }
      });

      const showModal = (modal) => {
         modal.classList.remove('scale-0');
         modal.classList.add('scale-1');

         const overlay = document.createElement('div');
         overlay.classList.add('fixed', 'inset-0', 'bg-black', 'opacity-65', 'z-20', 'transition-opacity',
            'duration-300');
         overlay.id = 'modalOverlay';
         document.body.appendChild(overlay);

         overlay.addEventListener('click', () => closeModal(modal));
      };

      const closeModal = (modal) => {
         modal.classList.add('scale-0');
         modal.classList.remove('scale-1');

         const overlay = document.getElementById('modalOverlay');
         if (overlay) {
            overlay.classList.remove('opacity-65');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.remove(), 300);
         }
      };

      const toggleModal = (event) => {
         const targetModalId = event.currentTarget.getAttribute('data-modal-target');
         const modal = document.getElementById(targetModalId);

         if (!modal) return;

         const isOpen = modal.classList.contains('scale-1');

         if (isOpen) {
            closeModal(modal);
         } else {
            showModal(modal);
         }
      };

      document.querySelectorAll('[data-modal-target]').forEach(button => {
         button.addEventListener('click', toggleModal);
      });
   </script>
</body>

</html>
