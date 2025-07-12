<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard CSR') }}
            </h2>
            
            <!-- Filter Period -->
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-4">
                <div>
                    <x-input-label for="start_date" value="{{ __('Dari') }}" />
                    <x-text-input type="date" name="start_date" 
                        value="{{ request('start_date', now()->startOfYear()->format('Y-m-d')) }}" 
                        class="mt-1 block w-40" />
                </div>
                
                <div>
                    <x-input-label for="end_date" value="{{ __('Sampai') }}" />
                    <x-text-input type="date" name="end_date" 
                        value="{{ request('end_date', now()->format('Y-m-d')) }}" 
                        class="mt-1 block w-40" />
                </div>

                <div class="mt-6">
                    <x-primary-button type="submit">
                        {{ __('Filter') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->role === 'admin')
                <!-- Konten khusus Admin -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Manajemen Pengguna</h3>
                    <!-- Tambahkan konten admin -->
                </div>
            @endif
            
            @if(auth()->user()->role === 'perusahaan')
                <!-- Konten khusus Perusahaan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Status Penilaian CSR</h3>
                    <!-- Tambahkan konten perusahaan -->
                </div>
            @endif
            
            @if(auth()->user()->role === 'pemantau')
                <!-- Konten khusus Pemantau -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Perusahaan yang Perlu Direview</h3>
                    <!-- Tambahkan konten pemantau -->
                </div>
            @endif

            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Total Assessments</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $statistics['total_assessments'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Average Score</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $statistics['average_score'] }}/3</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Completed Reviews</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $statistics['completed_reviews'] }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Pending Reviews</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $statistics['pending_reviews'] }}</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Timeline Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Trend Skor CSR</h3>
                    <canvas id="timelineChart"></canvas>
                </div>

                <!-- Category Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Skor per Kategori</h3>
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- ISO 26000 Compliance -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Kepatuhan ISO 26000</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <p class="text-gray-600">Total Indikator</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $isoCompliance->total_assessments }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600">Compliant</p>
                        <p class="text-2xl font-bold text-green-600">{{ $isoCompliance->compliant_count }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600">Compliance Rate</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $isoCompliance->compliance_percentage }}%
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <canvas id="isoComplianceChart"></canvas>
                </div>
            </div>

            <!-- Pending Reviews Table (for reviewers) -->
            @if(auth()->user()->role === 'reviewer')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Pending Reviews</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Company
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Indicator
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Submitted
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendingReviews as $assessment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $assessment->company->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $assessment->indicator->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $assessment->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('assessments.show', $assessment) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">
                                                Review
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No pending reviews
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Timeline Chart
        const timelineCtx = document.getElementById('timelineChart').getContext('2d');
        new Chart(timelineCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($timelineData->pluck('month')) !!},
                datasets: [{
                    label: 'Average Score',
                    data: {!! json_encode($timelineData->pluck('average_score')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 3
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($categoryScores->pluck('category')) !!},
                datasets: [{
                    label: 'Average Score',
                    data: {!! json_encode($categoryScores->pluck('average_score')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 3
                    }
                }
            }
        });

        // ISO Compliance Chart
        const isoCtx = document.getElementById('isoComplianceChart').getContext('2d');
        new Chart(isoCtx, {
            type: 'doughnut',
            data: {
                labels: ['Compliant', 'Non-Compliant'],
                datasets: [{
                    data: [
                        {{ $isoCompliance->compliant_count }},
                        {{ $isoCompliance->total_assessments - $isoCompliance->compliant_count }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 99, 132, 0.5)'
                    ],
                    borderColor: [
                        'rgb(75, 192, 192)',
                        'rgb(255, 99, 132)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
