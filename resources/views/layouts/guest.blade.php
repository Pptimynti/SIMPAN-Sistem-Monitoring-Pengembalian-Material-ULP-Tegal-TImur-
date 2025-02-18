<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Laravel') }}</title>

   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   <!-- Scripts -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])

   <style>
      /* HTML: <div class="loader"></div> */
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
   </style>
</head>

<body class="font-inter text-gray-900 antialiased">
   <div class="min-h-screen pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
      <div class="w-full bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
         {{ $slot }}
      </div>
   </div>

   <!-- Preloader -->
   <div id="preloader"
      class="inset-0 bg-white fixed z-[999] flex justify-center items-center transition-opacity duration-500">
      <div class="loader"></div>
   </div>

   <script>
      window.addEventListener("load", function() {
         let preloader = document.querySelector('#preloader');

         if (preloader) {
            preloader.classList.add("opacity-0");

            setTimeout(() => {
               preloader.classList.add("hidden");
            }, 500);
         }
      });
   </script>
</body>

</html>
