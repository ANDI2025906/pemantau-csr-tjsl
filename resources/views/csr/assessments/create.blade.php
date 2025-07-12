<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Penilaian CSR') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('csr-assessments.store') }}" 
                          enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Pilih Indikator -->
                        <div>
                            <label for="indicator_id" class="block text-sm font-medium text-gray-700">
                                Pilih Indikator
                            </label>
                            <select id="indicator_id" name="indicator_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Indikator</option>
                                @foreach($indicators as $categoryName => $categoryIndicators)
                                    <optgroup label="{{ $categoryName }}">
                                        @foreach($categoryIndicators as $indicator)
                                            <option value="{{ $indicator->id }}">
                                                {{ $indicator->code }} - {{ $indicator->name }}
                                                @if($indicator->is_iso_26000) ★ @endif
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('indicator_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Skor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Skor</label>
                            <div class="mt-2 space-y-2">
                                @foreach(range(0, 3) as $score)
                                    <div class="flex items-center">
                                        <input type="radio" name="score" value="{{ $score }}" 
                                               id="score_{{ $score }}" required
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="score_{{ $score }}" class="ml-3">
                                            <span class="block text-sm text-gray-700">
                                                {{ $score }} - 
                                                @switch($score)
                                                    @case(0)
                                                        Tidak ada implementasi
                                                        @break
                                                    @case(1)
                                                        Implementasi sebagian
                                                        @break
                                                    @case(2)
                                                        Implementasi penuh
                                                        @break
                                                    @case(3)
                                                        Implementasi melebihi standar
                                                        @break
                                                @endswitch
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('score')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Catatan Penilaian
                            </label>
                            <textarea id="notes" name="notes" rows="4" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Dokumen -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Upload Dokumen Pendukung
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="documents" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload files</span>
                                            <input id="documents" name="documents[]" type="file" class="sr-only" multiple>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, DOC, DOCX, JPG, JPEG, PNG hingga 10MB
                                    </p>
                                </div>
                            </div>
                            @error('documents')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('csr-assessments.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 active:bg-gray-50 active:text-gray-800">
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:border-blue-700 active:bg-blue-800">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
