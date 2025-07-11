<x-dashboard-layout>
    <!-- Success Message Component -->
    <x-success-message />
    
    <!-- Page Header -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-500 rounded-2xl shadow-xl mb-4">
            <i class="fas fa-chart-line text-white text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
        <p class="text-gray-700">Welcome back! Here's your overview</p>
    </div>

    <!-- Statistics Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-chart-bar text-yellow-500 mr-2"></i>
            Key Statistics
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="text-3xl font-extrabold text-yellow-500">{{ $stats['totalPlots'] }}</div>
                <div class="text-gray-800 mt-2 font-semibold">Total Plots</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="text-3xl font-extrabold text-yellow-500">{{ $stats['availablePlots'] }}</div>
                <div class="text-gray-800 mt-2 font-semibold">Available</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="text-3xl font-extrabold text-yellow-500">{{ $stats['reservedPlots'] }}</div>
                <div class="text-gray-800 mt-2 font-semibold">Reserved</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="text-3xl font-extrabold text-yellow-500">{{ $stats['soldPlots'] }}</div>
                <div class="text-gray-800 mt-2 font-semibold">Sold</div>
            </div>
            @php
                $statsList = [
                    ['label' => 'Total Users', 'value' => $stats['totalUsers'], 'icon' => 'fa-users'],
                    ['label' => 'Reservations', 'value' => $stats['totalReservations'], 'icon' => 'fa-calendar-check'],
                    ['label' => 'Inquiries', 'value' => $stats['totalInquiries'], 'icon' => 'fa-comments'],
                    ['label' => 'Reviews', 'value' => $stats['totalReviews'], 'icon' => 'fa-star'],
                    ['label' => 'New Inquiries', 'value' => $stats['newInquiries'], 'icon' => 'fa-bell'],
                ];
            @endphp
            @foreach($statsList as $stat)
                <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500 transition-transform transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold text-yellow-500">{{ $stat['value'] }}</div>
                            <div class="text-gray-800 text-sm font-semibold">{{ $stat['label'] }}</div>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas {{ $stat['icon'] }} text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Charts Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-chart-pie text-yellow-500 mr-2"></i>
            Analytics & Insights
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Plot Status Distribution -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-pie text-yellow-500 mr-2"></i>
                    Plot Status Distribution
                </h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="plotStatusChart" width="300" height="300"></canvas>
                </div>
            </div>
            <!-- Inquiry Status Distribution -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-doughnut text-yellow-500 mr-2"></i>
                    Inquiry Status Distribution
                </h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="inquiryStatusChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-2"></i>
            Quick Actions
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('admin.plots.create') }}" 
               class="flex flex-col items-center p-6 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-all duration-200 transform hover:-translate-y-1 shadow">
                <i class="fas fa-plus text-yellow-500 text-3xl mb-3"></i>
                <span class="text-sm font-semibold text-yellow-500">Add Plot</span>
            </a>
            <a href="{{ route('admin.plots.index') }}" 
               class="flex flex-col items-center p-6 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-all duration-200 transform hover:-translate-y-1 shadow">
                <i class="fas fa-list text-yellow-500 text-3xl mb-3"></i>
                <span class="text-sm font-semibold text-yellow-500">View Plots</span>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" 
               class="flex flex-col items-center p-6 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-all duration-200 transform hover:-translate-y-1 shadow">
                <i class="fas fa-comments text-yellow-500 text-3xl mb-3"></i>
                <span class="text-sm font-semibold text-yellow-500">Inquiries</span>
            </a>
            <a href="{{ route('admin.users.index') }}" 
               class="flex flex-col items-center p-6 bg-yellow-50 rounded-xl hover:bg-yellow-100 transition-all duration-200 transform hover:-translate-y-1 shadow">
                <i class="fas fa-users text-yellow-500 text-3xl mb-3"></i>
                <span class="text-sm font-semibold text-yellow-500">Users</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-clock text-yellow-500 mr-2"></i>
            Recent Activity
        </h2>
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-comments text-yellow-500 mr-2"></i>
                    Recent Inquiries
                </h3>
                <a href="{{ route('admin.inquiries.index') }}" class="text-yellow-500 hover:text-yellow-600 text-sm font-semibold">
                    View All
                </a>
            </div>
            <div class="space-y-4">
                @forelse($recentInquiries->take(5) as $inquiry)
                    <div class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-200">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-yellow-500"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $inquiry->name }}</div>
                            <div class="text-sm text-gray-800">{{ Str::limit($inquiry->message, 50) }}</div>
                            <div class="text-xs text-gray-700 mt-1">{{ $inquiry->created_at->diffForHumans() }}</div>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-500">
                            {{ ucfirst($inquiry->status) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p>No recent inquiries</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Advanced Analytics Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
            Advanced Insights
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Most Viewed Plots -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-eye text-yellow-500 mr-2"></i> Most Viewed Plots
                </h3>
                <ul class="space-y-2">
                    @foreach($mostViewedPlots as $plot)
                        <li class="flex justify-between items-center text-sm">
                            <span class="font-medium text-gray-800">{{ $plot->title }}</span>
                            <span class="text-yellow-500 font-bold">{{ $plot->views }} views</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Plots with Most Reservations -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-users text-yellow-500 mr-2"></i> Most Reserved Plots
                </h3>
                <ul class="space-y-2">
                    @foreach($plotsMostReservations as $plot)
                        <li class="flex justify-between items-center text-sm">
                            <span class="font-medium text-gray-800">{{ $plot->title }}</span>
                            <span class="text-yellow-500 font-bold">{{ $plot->reservations_count }} reservations</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Average Time to Sale -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-clock text-yellow-500 mr-2"></i> Avg. Time to Sale
                </h3>
                <div class="text-2xl font-bold text-yellow-500">
                    @if($avgTimeToSale !== null)
                        {{ $avgTimeToSale }} days
                    @else
                        <span class="text-gray-500 text-base">No data</span>
                    @endif
                </div>
            </div>
            <!-- Recent Sales -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex items-center">
                    <i class="fas fa-handshake text-yellow-500 mr-2"></i> Recent Sales
                </h3>
                <ul class="space-y-2">
                    @foreach($recentSales as $plot)
                        <li class="flex justify-between items-center text-sm">
                            <span class="font-medium text-gray-800">{{ $plot->title }}</span>
                            <span class="text-yellow-500">{{ $plot->updated_at->format('M d, Y') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Charts JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Plot Status Chart
        const plotStatusCtx = document.getElementById('plotStatusChart').getContext('2d');
        new Chart(plotStatusCtx, {
            type: 'pie',
            data: {
                labels: @json($statusLabels),
                datasets: [{
                    data: @json($statusCounts),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(107, 114, 128, 0.8)'
                    ],
                    borderColor: [
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(107, 114, 128, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Inquiry Status Chart
        const inquiryStatusCtx = document.getElementById('inquiryStatusChart').getContext('2d');
        new Chart(inquiryStatusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($inquiryStatusLabels),
                datasets: [{
                    data: @json($inquiryStatusCounts),
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(107, 114, 128, 0.8)'
                    ],
                    borderColor: [
                        'rgba(245, 158, 11, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(107, 114, 128, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
</x-dashboard-layout>
