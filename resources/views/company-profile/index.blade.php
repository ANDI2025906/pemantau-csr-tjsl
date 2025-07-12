<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($profile)
                        <div class="mb-4">
                            <h3 class="font-semibold mb-2">{{ __('Nama Perusahaan') }}</h3>
                            <p>{{ $profile->company_name }}</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-semibold mb-2">{{ __('Alamat') }}</h3>
                            <p>{{ $profile->address }}</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="font-semibold mb-2">{{ __('Nomor Telepon') }}</h3>
                            <p>{{ $profile->phone_number }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('company.profile.edit', $profile->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Edit Profil') }}
                            </a>
                        </div>
                    @else
                        <p>{{ __('Profil perusahaan belum dibuat.') }}</p>
                        <div class="mt-4">
                            <a href="{{ route('company.profile.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Buat Profil') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
