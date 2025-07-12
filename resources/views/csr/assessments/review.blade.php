<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Review Penilaian CSR') }}
            </h2>
            <a href="{{ route('csr-assessments.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Detail Penilaian (Read-only) -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Penilaian</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Perusahaan</p>
                                    <p class="mt-1">{{ $assessment->company->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Indikator</p>
                                    <p class="mt-1">
                                        {{ $assessment->indicator->code }} - {{ $assessment->indicator->name }}
                                        @if($assessment->indicator->is_iso_26000)
                                            <span class="text-yellow-500">★</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500">Skor Perusahaan</p>
                                <p class="mt-1">
                                    <span class="px-2 py-1 text-sm font-semibold rounded-full
                                        {{ $assessment->score === 0 ? 'bg-red-100 text-red-800' : 
                                           ($assessment->score === 1 ? 'bg-yellow-100 text-yellow-800' : 
                                           ($assessment->score === 2 ? 'bg-blue-100 text-blue-800' : 
                                            'bg-green-100 text-green-800')) }}">
                                        {{ $assessment->score }}/3
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Catatan Perusahaan</p>
                                <p class="mt-1">{{ $assessment->notes }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Pendukung -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen Pendukung</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if(!empty($assessment->uploaded_documents))
                                <ul class="divide-y divide-gray-200">
                                    @foreach($assessment->uploaded_documents as $document)
                                        <li class="py-3 flex justify-between items-center">
                                            <span class="text-sm text-gray-600">{{ $document['name'] }}</span>
                                            <a href="{{ Storage::url($document['path']) }}" 
                                               target="_blank"
                                               class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                Download
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">Tidak ada dokumen pendukung</p>
                            @endif
                        </div>
                    </div>

                    <!-- Form Review -->
                    <form method="POST" action="{{ route('csr-assessments.submit-review', $assessment) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Skor Review -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Skor Review</label>
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

                        <!-- Catatan Review -->
                        <div>
                            <label for="review_notes" class="block text-sm font-medium text-gray-700">
                                Catatan Review
                            </label>
                            <textarea id="review_notes" name="review_notes" rows="4" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('review_notes') }}</textarea>
                            @error('review_notes')
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
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
