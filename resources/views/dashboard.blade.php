<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSSF {{ $user->role === 'admin' ? 'Admin' : 'Manager' }} Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            DEFAULT: '#800000',
                            light: '#9d2b2b'
                        },
                        gold: {
                            DEFAULT: '#FFD700',
                            light: '#fff0a8'
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                        'display': ['Poppins', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
        }
        
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        
        #chat-window::-webkit-scrollbar {
            width: 6px;
        }
        
        #chat-window::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        #chat-window::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }
        
        #chat-window::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        .dark #chat-window::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark #chat-window::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark #chat-window::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .message {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Theme transition for smooth mode switching */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
    <div class="min-h-screen p-6">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-maroon dark:text-maroon-light flex items-center font-display">
                        <i class="fas fa-chart-bar mr-3"></i> NSSF {{ $user->role === 'admin' ? 'Admin' : 'Manager' }} Dashboard
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Analysis of feedback for {{ $regionName }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Last updated: <span id="current-date"></span></p>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600">
                        <i class="fas fa-moon dark:hidden"></i>
                        <i class="fas fa-sun hidden dark:block"></i>
                    </button>
                    
                    <div class="h-10 w-10 rounded-full bg-maroon dark:bg-maroon-light flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-maroon dark:bg-maroon-light text-white px-4 py-2 rounded-lg hover:bg-maroon-light dark:hover:bg-maroon transition-all font-medium">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
            <div class="w-full h-1 bg-gradient-to-r from-maroon to-gold mt-4 rounded-full dark:from-maroon-light dark:to-gold-light"></div>
        </header>

        <!-- Filters -->
        <section class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 mb-6 card-hover">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="text-maroon dark:text-maroon-light font-semibold">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate ?? '' }}" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-gold dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div class="flex-1">
                    <label class="text-maroon dark:text-maroon-light font-semibold">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate ?? '' }}" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-gold dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-maroon dark:bg-maroon-light text-white px-4 py-3 rounded-lg hover:bg-maroon-light dark:hover:bg-maroon font-medium">Filter</button>
                    <a href="{{ route('feedback.export') }}?start_date={{ $startDate ?? '' }}&end_date={{ $endDate ?? '' }}" class="bg-gold dark:bg-gold-light text-maroon dark:text-maroon px-4 py-3 rounded-lg hover:bg-gold-light dark:hover:bg-gold font-medium">Export CSV</a>
                </div>
            </form>
        </section>

        <!-- Stats Cards -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-3 flex items-center">
                    <i class="fas fa-comment-dots mr-3 text-xl"></i> Total Feedbacks
                </h2>
                <p class="text-4xl font-bold">{{ $totalFeedbacks }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-3 flex items-center">
                    <i class="fas fa-star mr-3 text-xl"></i> Avg Satisfaction
                </h2>
                <p class="text-4xl font-bold">{{ number_format($averageSatisfaction, 1) }}/5</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-3 flex items-center">
                    <i class="fas fa-bullseye mr-3 text-xl"></i> Top Visit Reason
                </h2>
                <p class="text-2xl font-bold">{{ $topVisitReason }}</p>
            </div>
        </section>

        <!-- Analytics Section -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <!-- Gender Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-users mr-3"></i> Gender Distribution
                </h2>
                <div class="chart-container">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Membership Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-user-tag mr-3"></i> Membership Types
                </h2>
                <div class="chart-container">
                    <canvas id="membershipChart"></canvas>
                </div>
            </div>

            <!-- Visit Reason Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-clipboard-list mr-3"></i> Visit Reasons
                </h2>
                <div class="chart-container">
                    <canvas id="visitReasonChart"></canvas>
                </div>
            </div>

            <!-- Waiting Time Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-clock mr-3"></i> Waiting Time
                </h2>
                <div class="chart-container">
                    <canvas id="waitingTimeChart"></canvas>
                </div>
            </div>

            <!-- Satisfaction Time Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-smile mr-3"></i> Satisfaction with Time
                </h2>
                <div class="chart-container">
                    <canvas id="satisfactionTimeChart"></canvas>
                </div>
            </div>

            <!-- Needs Met Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-3"></i> Needs Met
                </h2>
                <div class="chart-container">
                    <canvas id="needsMetChart"></canvas>
                </div>
            </div>

            <!-- Service Quality Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-star-half-alt mr-3"></i> Service Quality
                </h2>
                <div class="chart-container">
                    <canvas id="serviceQualityChart"></canvas>
                </div>
            </div>

            <!-- Problem Handling Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-tools mr-3"></i> Problem Handling
                </h2>
                <div class="chart-container">
                    <canvas id="problemHandlingChart"></canvas>
                </div>
            </div>

            <!-- Staff Responsiveness Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-user-shield mr-3"></i> Staff Responsiveness
                </h2>
                <div class="chart-container">
                    <canvas id="staffResponsivenessChart"></canvas>
                </div>
            </div>

            <!-- Overall Satisfaction Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 border-l-4 border-gold dark:border-gold-light card-hover">
                <h2 class="text-lg font-semibold text-maroon dark:text-maroon-light mb-4 flex items-center">
                    <i class="fas fa-thumbs-up mr-3"></i> Overall Satisfaction
                </h2>
                <div class="chart-container">
                    <canvas id="overallSatisfactionChart"></canvas>
                </div>
            </div>
        </section>

        <!-- Recent Feedback Table -->
        <section class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 mb-10 card-hover">
            <h2 class="text-xl font-bold text-maroon dark:text-maroon-light mb-5 flex items-center font-display">
                <i class="fas fa-table mr-3"></i> Recent Feedbacks
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-maroon dark:bg-maroon-light text-white">
                            <th class="p-3 border dark:border-gray-700">ID</th>
                            <th class="p-3 border dark:border-gray-700">Gender</th>
                            <th class="p-3 border dark:border-gray-700">Membership</th>
                            <th class="p-3 border dark:border-gray-700">Visit Reason</th>
                            <th class="p-3 border dark:border-gray-700">Waiting Time</th>
                            <th class="p-3 border dark:border-gray-700">Satisfaction</th>
                            <th class="p-3 border dark:border-gray-700">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($recentFeedbacks->isEmpty())
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500 dark:text-gray-400">No feedback available.</td>
                            </tr>
                        @else
                            @foreach($recentFeedbacks as $feedback)
                                <tr class="{{ $loop->even ? 'bg-gold-light dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} hover:bg-gold dark:hover:bg-gray-600">
                                    <td class="p-3 border dark:border-gray-700">{{ $feedback->id }}</td>
                                    <td class="p-3 border dark:border-gray-700">{{ $feedback->gender }}</td>
                                    <td class="p-3 border dark:border-gray-700">{{ $feedback->membership }}</td>
                                    <td class="p-3 border dark:border-gray-700">{{ $feedback->visit_reason }}</td>
                                    <td class="p-3 border dark:border-gray-700">{{ $feedback->waiting_time }}</td>
                                    <td class="p-3 border dark:border-gray-700">{{ $feedback->overall_satisfaction }}</td>
                                    <td class="p-3 border dark:border-gray-700">{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Chatbot Section -->
        <section class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8 card-hover">
            <h2 class="text-xl font-bold text-maroon dark:text-maroon-light mb-5 flex items-center font-display">
                <i class="fas fa-robot mr-3"></i> AI Assistant
            </h2>
            <div id="chat-window" class="h-64 overflow-y-auto border rounded-lg p-4 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 mb-5">
                <div class="message text-left mb-4">
                    <span class="inline-block bg-gradient-to-r from-maroon to-maroon-light dark:from-maroon-light dark:to-maroon text-white px-4 py-2 rounded-lg rounded-bl-none max-w-[80%]">
                        Hello! I'm your AI assistant. Ask me about feedback analysis or anything else!
                    </span>
                </div>
            </div>
            <form id="chat-form" class="flex rounded-lg overflow-hidden shadow-sm">
                <input type="text" id="chat-input" class="flex-1 border border-gray-300 dark:border-gray-600 p-3 focus:outline-none focus:ring-2 focus:ring-gold dark:bg-gray-700 dark:text-white" placeholder="Ask the AI assistant..." required>
                <button type="submit" class="bg-gradient-to-r from-maroon to-maroon-light dark:from-maroon-light dark:to-maroon text-white px-5 py-3 hover:from-maroon-light hover:to-maroon dark:hover:from-maroon dark:hover:to-maroon-light transition-all duration-300 font-medium">
                    Send
                </button>
            </form>
        </section>

        <!-- Footer -->
        <footer class="text-center text-gray-500 dark:text-gray-400 text-sm pt-4 border-t border-gray-200 dark:border-gray-700 mt-8">
            <p>© 2025 Mfuko wa Taifa wa Hifadhi ya Jamii (NSSF). All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Set current date
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });

        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
        // Check for saved theme preference or respect OS preference
        if (localStorage.getItem('theme') === 'dark' || 
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            htmlElement.classList.add('dark');
        } else {
            htmlElement.classList.remove('dark');
        }
        
        themeToggle.addEventListener('click', () => {
            htmlElement.classList.toggle('dark');
            localStorage.setItem('theme', htmlElement.classList.contains('dark') ? 'dark' : 'light');
        });

        // Chart colors
        const chartColors = ['#800000', '#FFD700', '#9d2b2b', '#fff0a8', '#555555', '#FFB347'];

        // Chart configurations with dark mode support
        const getChartOptions = (isDark) => ({
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        boxWidth: 15, 
                        padding: 15,
                        color: isDark ? '#e5e7eb' : '#374151'
                    }
                }
            }
        });

        // Initialize charts with theme awareness
        const initCharts = () => {
            const isDark = htmlElement.classList.contains('dark');
            const gridColor = isDark ? '#374151' : '#e5e7eb';
            const textColor = isDark ? '#e5e7eb' : '#374151';
            
            const barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { 
                            drawBorder: false,
                            color: gridColor
                        },
                        ticks: {
                            color: textColor
                        }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: {
                            color: textColor
                        }
                    }
                },
                plugins: { 
                    legend: { display: false } 
                }
            };

            // Gender Chart
            new Chart(document.getElementById('genderChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($genderDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($genderDist)) !!}, backgroundColor: chartColors }]
                },
                options: getChartOptions(isDark)
            });

            // Membership Chart
            new Chart(document.getElementById('membershipChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($membershipDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($membershipDist)) !!}, backgroundColor: chartColors }]
                },
                options: getChartOptions(isDark)
            });

            // Visit Reason Chart
            new Chart(document.getElementById('visitReasonChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($visitReasonDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($visitReasonDist)) !!}, backgroundColor: chartColors }]
                },
                options: getChartOptions(isDark)
            });

            // Waiting Time Chart
            new Chart(document.getElementById('waitingTimeChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($waitingTimeDist)) !!},
                    datasets: [{
                        label: 'Responses',
                        data: {!! json_encode(array_values($waitingTimeDist)) !!},
                        backgroundColor: '#800000',
                        borderRadius: 5,
                        hoverBackgroundColor: '#9d2b2b'
                    }]
                },
                options: barChartOptions
            });

            // Satisfaction Time Chart
            new Chart(document.getElementById('satisfactionTimeChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($satisfactionTimeDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($satisfactionTimeDist)) !!}, backgroundColor: chartColors, borderWidth: 0, hoverOffset: 15 }]
                },
                options: { ...getChartOptions(isDark), cutout: '65%' }
            });

            // Needs Met Chart
            new Chart(document.getElementById('needsMetChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($needsMetDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($needsMetDist)) !!}, backgroundColor: chartColors, borderWidth: 0, hoverOffset: 15 }]
                },
                options: getChartOptions(isDark)
            });

            // Service Quality Chart
            new Chart(document.getElementById('serviceQualityChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($serviceQualityDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($serviceQualityDist)) !!}, backgroundColor: chartColors, borderWidth: 0, hoverOffset: 15 }]
                },
                options: getChartOptions(isDark)
            });

            // Problem Handling Chart
            new Chart(document.getElementById('problemHandlingChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($problemHandlingDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($problemHandlingDist)) !!}, backgroundColor: chartColors, borderWidth: 0, hoverOffset: 15 }]
                },
                options: getChartOptions(isDark)
            });

            // Staff Responsiveness Chart
            new Chart(document.getElementById('staffResponsivenessChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_keys($staffResponsivenessDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($staffResponsivenessDist)) !!}, backgroundColor: chartColors, borderWidth: 0, hoverOffset: 15 }]
                },
                options: getChartOptions(isDark)
            });

            // Overall Satisfaction Chart
            new Chart(document.getElementById('overallSatisfactionChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($overallSatisfactionDist)) !!},
                    datasets: [{ data: {!! json_encode(array_values($overallSatisfactionDist)) !!}, backgroundColor: chartColors, borderWidth: 0, hoverOffset: 15 }]
                },
                options: { ...getChartOptions(isDark), cutout: '65%' }
            });
        };

        // Initialize charts on page load
        initCharts();

        // Chatbot Functionality
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatWindow = document.getElementById('chat-window');

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            // Show user message
            const userMessageElement = document.createElement('div');
            userMessageElement.className = 'message text-right mb-4';
            userMessageElement.innerHTML = `<span class="inline-block bg-gradient-to-r from-gold to-gold-light text-maroon px-4 py-2 rounded-lg rounded-br-none max-w-[80%]">${message}</span>`;
            chatWindow.appendChild(userMessageElement);
            chatInput.value = '';
            chatWindow.scrollTop = chatWindow.scrollHeight;

            // Send to AI endpoint
            try {
                const response = await fetch('{{ route('ai.chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });
                const data = await response.json();
                if (data.error) {
                    throw new Error(data.error);
                }
                const aiMessageElement = document.createElement('div');
                aiMessageElement.className = 'message text-left mb-4';
                aiMessageElement.innerHTML = `<span class="inline-block bg-gradient-to-r from-maroon to-maroon-light text-white px-4 py-2 rounded-lg rounded-bl-none max-w-[80%]">${data.message}</span>`;
                chatWindow.appendChild(aiMessageElement);
                chatWindow.scrollTop = chatWindow.scrollHeight;
            } catch (error) {
                const errorMessageElement = document.createElement('div');
                errorMessageElement.className = 'message text-left mb-4';
                errorMessageElement.innerHTML = `<span class="inline-block bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 px-4 py-2 rounded-lg max-w-[80%]">Error: ${error.message}</span>`;
                chatWindow.appendChild(errorMessageElement);
                chatWindow.scrollTop = chatWindow.scrollHeight;
            }
        });
    </script>
</body>
</html>