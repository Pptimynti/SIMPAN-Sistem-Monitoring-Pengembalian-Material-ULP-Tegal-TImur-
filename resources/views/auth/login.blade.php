<x-guest-layout>
   <div class="bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/bg-login.jpg') }}')">
      <div class="h-screen flex justify-center items-center">
         <div class="bg-white mx-4 p-8 rounded shadow-md w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Login</h1>
            <form method="POST" action="{{ route('login') }}">
               @csrf
               <!-- Email Address -->
               <div class="mb-6">
                  <x-input-label for="email" :value="__('Email Address')" />
                  <x-text-input id="email"
                     class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     type="email" name="email" :value="old('email')" required autofocus
                     placeholder="Enter your email address" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
               </div>
               <!-- Password -->
               <div class="mb-6">
                  <x-input-label for="password" :value="__('Password')" />
                  <x-text-input id="password"
                     class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     type="password" name="password" required autocomplete="current-password"
                     placeholder="Enter your password" />
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  <a class="text-sm text-blue-500 hover:text-blue-700 block mt-2"
                     href="{{ route('password.request') }}">Forgot your password?</a>
               </div>
               <!-- Remember Me -->
               <div class="flex items-center mb-6">
                  <label for="remember_me" class="inline-flex items-center">
                     <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                     <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                  </label>
               </div>
               <!-- Submit Button -->
               <div class="flex justify-center mb-4">
                  <x-primary-button
                     class="w-full py-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                     {{ __('Login') }}
                  </x-primary-button>
               </div>
            </form>
         </div>
      </div>
   </div>
</x-guest-layout>
