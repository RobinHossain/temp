@if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
            @endif
        @endauth
    </div>
@endif

<script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo"></x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('form_submit') }}">
        @csrf

        <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <x-label for="phone" :value="__('Phone Number')" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Desired Budget -->
            <div class="mt-4">
                <x-label for="budget" :value="__('Desired Budget')" />

                <x-input id="budget" class="block mt-1 w-full" type="number" name="budget" :value="old('budget')" required />
            </div>

            <!-- Message -->
            <div class="mt-4">
                <x-label for="message" :value="__('Message')" />
                <textarea name="message" class="block mt-1 w-full" name="message" required></textarea>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4">
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>


@if ($alertFm = Session::get('error'))
    <script type="text/javascript">
        swal({
            title:'Error!',
            icon: 'error',
            text:"{{Session::get('error')}}",
            type:'error',
            timer:7000
        }).then((value) => {
        }).catch(swal.noop);
    </script>
@endif

@if ($alertFm = Session::get('success'))
    <script type="text/javascript">
        swal({
            title:'Dene!',
            icon: 'success',
            text:"{{Session::get('success')}}",
            timer:5000,
            type:'success'
        }).then((value) => {
        }).catch(swal.noop);
    </script>
@endif
