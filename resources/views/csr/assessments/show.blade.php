<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Penilaian CSR') }}
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
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Informasi Perusahaan -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Perusahaan</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nama Perusahaan</p>
                                <p class="mt-1">{{ $assessment->company->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tanggal Penilaian</p>
                                <p class="mt-1">{{ $assessment->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Indikator -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Indikator</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Kategori</p>
                                    <p class="mt-1">{{ $assessment->indicator->category->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Kode</p>
                                    <p class="mt-1">{{ $assessment->indicator->code }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Nama Indikator</p>
                                <p class="mt-1">
                                    {{ $assessment->indicator->name }}
                                    @if($assessment->indicator->is_iso_26000)
                                        <span class="text-yellow-500">★</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Deskripsi</p>
                                <p class="mt-1">{{ $assessment->indicator->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Penilaian -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Hasil Penilaian</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Skor</p>
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
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="mt-1">
                                        <span class="px-2 py-1 text-sm font-semibold rounded-full
                                            {{ $assessment->status === 'draft' ? 'bg-gray-100 text-gray-800' :
                                               ($assessment->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' :
                                                'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($assessment->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Catatan</p>
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

                    <!-- Informasi Review -->
                    @if($assessment->status === 'reviewed')
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Review</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Reviewer</p>
                                    <p class="mt-1">{{ $assessment->reviewer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Tanggal Review</p>
                                    <p class="mt-1">{{ $assessment->reviewed_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            @can('submit', $assessment)
    <form action="{{ route('csr-assessments.submit', $assessment) }}" 
          method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <button type="submit" 
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                onclick="return confirm('Apakah Anda yakin ingin submit penilaian ini untuk direview?')">
            Submit untuk Review
        </button>
    </form>
@endcan

            </div>
        </div>
    </div>
</x-app-layout>
