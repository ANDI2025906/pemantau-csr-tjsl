<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Penilaian CSR') }}
            </h2>
            @can('create', App\Models\CsrAssessment::class)
            <a href="{{ route('csr-assessments.create') }}" 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Penilaian
            </a>
            @endcan
        </div>
    </x-slot>
<!-- Di dalam table -->
<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    @can('view', $assessment)
        <a href="{{ route('csr-assessments.show', $assessment) }}" 
           class="text-indigo-600 hover:text-indigo-900 mr-3">
            Detail
        </a>
    @endcan
    
    @can('review', $assessment)
        <a href="{{ route('csr-assessments.review', $assessment) }}"
           class="text-blue-600 hover:text-blue-900 mr-3">
            Review
        </a>
    @endcan
    
    @can('delete', $assessment)
        <form action="{{ route('csr-assessments.destroy', $assessment) }}" 
              method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-900"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus penilaian ini?')">
                Hapus
            </button>
        </form>
    @endcan
</td>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Perusahaan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Indikator
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Skor
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($assessments as $assessment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $assessment->company->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $assessment->indicator->category->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $assessment->indicator->name }}
                                            @if($assessment->indicator->is_iso_26000)
                                                <span class="text-yellow-500">★</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $assessment->score === 0 ? 'bg-red-100 text-red-800' : 
                                                   ($assessment->score === 1 ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($assessment->score === 2 ? 'bg-blue-100 text-blue-800' : 
                                                    'bg-green-100 text-green-800')) }}">
                                                {{ $assessment->score }}/3
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $assessment->status === 'draft' ? 'bg-gray-100 text-gray-800' :
                                                   ($assessment->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' :
                                                    'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($assessment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('csr-assessments.show', $assessment) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                Detail
                                            </a>
                                            @if(auth()->user()->role === 'reviewer' && $assessment->status === 'submitted')
                                                <a href="{{ route('csr-assessments.review', $assessment) }}"
                                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                                    Review
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data penilaian
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $assessments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
