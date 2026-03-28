<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Analytics - Developer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col pt-16">

    <div class="max-w-5xl mx-auto px-4 w-full">
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-emerald-400">
                Visitor Analytics
            </h1>
            <p class="text-gray-400 mt-2">Live unique visitor statistics</p>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Today Card -->
            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:border-blue-500 transition duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform group-hover:scale-110 transition duration-300">
                    <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                </div>
                <h3 class="text-gray-400 text-sm font-semibold uppercase tracking-wider">Today's Visitors</h3>
                <div class="mt-4 flex items-baseline">
                    <span class="text-5xl font-bold text-white">{{ number_format($todayCount) }}</span>
                </div>
                <p class="text-sm text-blue-400 mt-2 font-medium">Unique IPs counted today</p>
            </div>

            <!-- This Month Card -->
            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:border-emerald-500 transition duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform group-hover:scale-110 transition duration-300">
                     <svg class="w-16 h-16 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="text-gray-400 text-sm font-semibold uppercase tracking-wider">This Month</h3>
                <div class="mt-4 flex items-baseline">
                    <span class="text-5xl font-bold text-white">{{ number_format($thisMonthCount) }}</span>
                </div>
                <p class="text-sm text-emerald-400 mt-2 font-medium">Daily uniqueness this month</p>
            </div>

            <!-- All Time Card -->
            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:border-purple-500 transition duration-300">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform group-hover:scale-110 transition duration-300">
                    <svg class="w-16 h-16 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                </div>
                <h3 class="text-gray-400 text-sm font-semibold uppercase tracking-wider">All-Time Visitors</h3>
                <div class="mt-4 flex items-baseline">
                    <span class="text-5xl font-bold text-white">{{ number_format($allTimeCount) }}</span>
                </div>
                <p class="text-sm text-purple-400 mt-2 font-medium">Total logged since inception</p>
            </div>

        </div>

    </div>

</body>
</html>
