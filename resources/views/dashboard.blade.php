c<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard CSR') }}
            </h2>
         </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>   
            <!-- Date Filter -->
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-4">
                <div>
                    <x-input-label for="start_date" value="{{ __('From') }}" />
                    <x-text-input type="date" 
                        name="start_date" 
                        value="{{ request('start_date', now()->startOfYear()->format('Y-m-d')) }}"
                        class="mt-1 block w-40" />
                </div>
                
                <div>
                    <x-input-label for="end_date" value="{{ __('To') }}" />
                    <x-text-input type="date" 
                        name="end_date" 
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
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Total Assessments</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $statistics['total_assessments'] ?? 0 }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Average Score</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $statistics['average_score'] ?? 0 }}/3</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Completed Reviews</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $statistics['completed_reviews'] ?? 0 }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Pending Reviews</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $statistics['pending_reviews'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Timeline Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">CSR Score Trend</h3>
                    <canvas id="timelineChart"></canvas>
                </div>

                <!-- Category Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Category Scores</h3>
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Timeline Chart
        const timelineData = @json($timelineData ?? []);
        const timelineCtx = document.getElementById('timelineChart').getContext('2d');
        new Chart(timelineCtx, {
            type: 'line',
            data: {
                labels: timelineData.map(item => item.month ?? []),
                datasets: [{
                    label: 'Average Score',
                    data: timelineData.map(item => item.average_score ?? 0),
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

        // Category Chart (if you have category data)
        const categoryData = @json($categoryScores ?? []);
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categoryData.map(item => item.category_name ?? []),
                datasets: [{
                    label: 'Category Scores',
                    data: categoryData.map(item => item.average_score ?? 0),
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
    </script>
    @endpush
</x-app-layout>
