<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lengkapi Profil Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <p class="mb-4">
                        Selamat datang, <strong>{{ $user->name }}</strong>!
                        Silakan lengkapi data pokok perusahaan Anda di bawah ini untuk melanjutkan.
                    </p>

                    {{-- Arahkan form ke route yang sudah kita buat --}}
                    <form method="POST" action="{{ route('company.profile.store') }}">
                        @csrf

                        <!-- Nama Perusahaan -->
                        <div>
                            <x-input-label for="company_name" :value="__('Nama Perusahaan')" />
                            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" required autofocus />
                        </div>

                        <!-- Alamat -->
                        <div class="mt-4">
                            <x-input-label for="address" :value="__('Alamat Lengkap')" />
                            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="mt-4">
                            <x-input-label for="phone_number" :value="__('Nomor Telepon Perusahaan')" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan dan Lanjutkan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
