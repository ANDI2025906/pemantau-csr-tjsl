<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Pokok Perusahaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="company-profile-form" method="POST" action="{{ route('company.profile.store') }}" class="space-y-6">
                        @csrf

                        <!-- Informasi Dasar -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">{{ __('Informasi Dasar') }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nama Perusahaan -->
                                <div>
                                    <x-input-label for="company_name" :value="__('Nama Perusahaan')" />
                                    <x-text-input id="company_name" name="company_name" type="text" 
                                        class="mt-1 block w-full" :value="old('company_name', $profile->company_name ?? '')" />
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <x-input-label for="category" :value="__('Kategori')" />
                                    <select id="category" name="category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Pilih Kategori</option>
                                        <option value="BUMN" {{ old('category', $details->category ?? '') == 'BUMN' ? 'selected' : '' }}>BUMN</option>
                                        <option value="BUMD" {{ old('category', $details->category ?? '') == 'BUMD' ? 'selected' : '' }}>BUMD</option>
                                        <option value="SWASTA" {{ old('category', $details->category ?? '') == 'SWASTA' ? 'selected' : '' }}>SWASTA</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>

                                <!-- Jenis Usaha -->
                                <div>
                                    <x-input-label for="business_type" :value="__('Jenis Usaha')" />
                                    <x-text-input id="business_type" name="business_type" type="text" 
                                        class="mt-1 block w-full" :value="old('business_type', $details->business_type ?? '')" />
                                    <x-input-error :messages="$errors->get('business_type')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">{{ __('Lokasi') }}</h3>

                            <!-- Kantor Pusat -->
                            <div class="space-y-4">
                                <h4 class="font-medium">{{ __('Kantor Pusat') }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="head_office_province" :value="__('Provinsi')" />
                                        <select id="head_office_province" name="head_office_province" 
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}" 
                                                    {{ old('head_office_province', $details->head_office_province ?? '') == $province->id ? 'selected' : '' }}>
                                                    {{ $province->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('head_office_province')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="head_office_city" :value="__('Kota/Kabupaten')" />
                                        <select id="head_office_city" name="head_office_city" 
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">Pilih Kota/Kabupaten</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('head_office_city')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Unit Operasional -->
                            <div class="space-y-4">
                                <h4 class="font-medium">{{ __('Unit Operasional') }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="operational_province" :value="__('Provinsi')" />
                                        <select id="operational_province" name="operational_province" 
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}"
                                                    {{ old('operational_province', $details->operational_province ?? '') == $province->id ? 'selected' : '' }}>
                                                    {{ $province->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('operational_province')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="operational_city" :value="__('Kota/Kabupaten')" />
                                        <select id="operational_city" name="operational_city" 
                                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">Pilih Kota/Kabupaten</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('operational_city')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">{{ __('Informasi Tambahan') }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="employee_count" :value="__('Jumlah Karyawan')" />
                                    <x-text-input id="employee_count" name="employee_count" type="number" 
                                        class="mt-1 block w-full" :value="old('employee_count', $details->employee_count ?? '')" />
                                    <x-input-error :messages="$errors->get('employee_count')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="established_year" :value="__('Tahun Berdiri')" />
                                    <x-text-input id="established_year" name="established_year" type="number" 
                                        class="mt-1 block w-full" :value="old('established_year', $details->established_year ?? '')" />
                                    <x-input-error :messages="$errors->get('established_year')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kontak -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">{{ __('Informasi Kontak') }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="contact_name" :value="__('Nama Kontak')" />
                                    <x-text-input id="contact_name" name="contact_name" type="text" 
                                        class="mt-1 block w-full" :value="old('contact_name', $details->contact_name ?? '')" />
                                    <x-input-error :messages="$errors->get('contact_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="contact_position" :value="__('Jabatan')" />
                                    <x-text-input id="contact_position" name="contact_position" type="text" 
                                        class="mt-1 block w-full" :value="old('contact_position', $details->contact_position ?? '')" />
                                    <x-input-error :messages="$errors->get('contact_position')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="contact_phone" :value="__('Nomor Telepon')" />
                                    <x-text-input id="contact_phone" name="contact_phone" type="tel" 
                                        class="mt-1 block w-full" :value="old('contact_phone', $details->contact_phone ?? '')" />
                                    <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="contact_email" :value="__('Email')" />
                                    <x-text-input id="contact_email" name="contact_email" type="email" 
                                        class="mt-1 block w-full" :value="old('contact_email', $details->contact_email ?? '')" />
                                    <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headOfficeProvince = document.getElementById('head_office_province');
            const headOfficeCity = document.getElementById('head_office_city');
            const operationalProvince = document.getElementById('operational_province');
            const operationalCity = document.getElementById('operational_city');

            async function loadCities(provinceId, citySelect) {
                if (!provinceId) {
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    return;
                }

                try {
                    const response = await fetch(`/api/cities/${provinceId}`);
                    const cities = await response.json();
                    
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = `${city.type} ${city.name}`;
                        citySelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error loading cities:', error);
                }
            }

            headOfficeProvince.addEventListener('change', function() {
                loadCities(this.value, headOfficeCity);
            });

            operationalProvince.addEventListener('change', function() {
                loadCities(this.value, operationalCity);
            });

            // Load initial cities if provinces are selected
            if (headOfficeProvince.value) {
                loadCities(headOfficeProvince.value, headOfficeCity);
            }
            if (operationalProvince.value) {
                loadCities(operationalProvince.value, operationalCity);
            }
        });
    </script>
    @endpush
</x-app-layout>
