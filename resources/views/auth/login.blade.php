<x-guest-layout>
   <div class="min-h-screen flex items-center justify-center p-4 bg-cover bg-center"
      style="background-image: url('{{ asset('images/bg-login.jpg') }}')">
      <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
         <!-- Header Section -->
         <div class="bg-gradient-to-r from-blue-600 to-purple-700 p-6 md:p-8 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
               <div>
                  <h1 class="text-white font-bold text-2xl md:text-3xl leading-tight">SIMPAN</h1>
                  <!-- Ukuran teks diperbesar -->
                  <p class="text-white font-semibold text-sm md:text-base leading-tight">
                     Sistem Monitoring Pengembalian Material
                  </p>
                  <p class="text-blue-200 text-xs md:text-sm">
                     Login to manage material returns for PLN ULP Tegal Timur
                  </p>
               </div>
            </div>

         </div>

         <!-- Form Section -->
         <div class="p-6 md:p-8">
            <form method="POST" action="{{ route('login') }}">
               @csrf
               <!-- Email Input -->
               <div class="mb-4 md:mb-6">
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                  <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                     class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                     placeholder="Enter your email">
                  @if ($errors->has('email'))
                     <p class="text-sm text-red-500 mt-2">{{ $errors->first('email') }}</p>
                  @endif
               </div>

               <!-- Password Input -->
               <div class="mb-4 md:mb-6">
                  <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                  <input id="password" type="password" name="password" required autocomplete="current-password"
                     class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                     placeholder="Enter your password">
                  @if ($errors->has('password'))
                     <p class="text-sm text-red-500 mt-2">{{ $errors->first('password') }}</p>
                  @endif
                  <a href="{{ route('password.request') }}"
                     class="text-xs md:text-sm text-blue-500 hover:text-blue-700 mt-2 block">Forgot your password?</a>
               </div>

               <!-- Remember Me Checkbox -->
               <div class="flex items-center mb-4 md:mb-6">
                  <input id="remember_me" type="checkbox" name="remember"
                     class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                  <label for="remember_me" class="ml-2 text-xs md:text-sm text-gray-700">Remember me</label>
               </div>

               <!-- Submit Button -->
               <button type="submit"
                  class="w-full bg-gradient-to-r from-blue-600 to-purple-700 text-white py-2 md:py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                  Login
               </button>
            </form>
         </div>
      </div>
   </div>
</x-guest-layout>
