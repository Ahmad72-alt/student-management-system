<x-app-layout class="bg-gradient-to-br from-emerald-800 via-green-700 to-teal-900 min-h-screen">
    <x-slot name="header">
        <h2 class="font-bold text-xl text-emerald-100 leading-tight flex items-center gap-2 drop-shadow-sm bg-emerald-950 px-4 py-2.5 rounded-xl border-2 border-emerald-500/50 inline-flex shadow-lg">
            <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            {{ __('Welcome Admin Dashboard') }}
        </h2>
    </x-slot>

    <!-- Kumukuha ng data diretso mula sa .env variables batay sa configuration -->
    <div class="py-12" x-data="weatherWidget('{{ env('WEATHER_API_KEY', 'dummy-key') }}', '{{ env('WEATHER_LAT', '7.1907') }}', '{{ env('WEATHER_LON', '125.4553') }}', '{{ env('WEATHER_LOCATION_NAME', 'Manila') }}')" x-init="init()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Banner Card -->
            <div class="relative bg-white shadow-2xl sm:rounded-2xl text-gray-900 border-2 border-emerald-600 p-6 sm:p-8">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-3 bg-emerald-100 px-3.5 py-1.5 rounded-lg border border-emerald-400 shadow-sm inline-flex">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-600 animate-ping"></span>
                            <span class="text-xs uppercase tracking-widest text-emerald-900 font-extrabold">System Control Center</span>
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 bg-emerald-50 px-5 py-3 rounded-xl border-2 border-emerald-500 shadow-md block mt-2">
                            Hello, Admin {{ Auth::user()->name }}! 👋
                        </h3>
                    </div>

                    <div class="hidden md:block">
                        <span class="px-5 py-3 bg-emerald-600 rounded-xl text-xs font-bold uppercase tracking-wider border-2 border-emerald-700 text-white shadow-xl block">
                            ⚡ Active Admin
                        </span>
                    </div>
                </div>
            </div>

            <!-- API Key Missing Error Banner -->
            <div x-show="hasApiKeyError" x-transition class="bg-yellow-950 border-2 border-yellow-500 text-yellow-200 px-4 py-3 rounded-xl shadow-lg flex items-center justify-between" style="display: none;">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-400 animate-pulse shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="text-sm font-bold">Babala: Walang nade-detect na WEATHER_API_KEY sa iyong .env file o blangko ito.</span>
                </div>
                <span class="text-xs bg-yellow-900 px-2.5 py-1 rounded border border-yellow-600 uppercase font-semibold shrink-0 ml-2">Config Error</span>
            </div>

            <!-- No Internet Error Banner -->
            <div x-show="!isOnline && !hasApiKeyError" x-transition class="bg-red-950 border-2 border-red-500 text-red-200 px-4 py-3 rounded-xl shadow-lg flex items-center justify-between" style="display: none;">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-400 animate-bounce shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="text-sm font-bold">Babala: Walang signal o internet connection para makuha ang weather update.</span>
                </div>
                <span class="text-xs bg-red-900 px-2.5 py-1 rounded border border-red-600 uppercase font-semibold shrink-0 ml-2">Network Error</span>
            </div>

            <!-- Weather Information Widget -->
            <div x-show="isOnline && !hasApiKeyError" x-transition class="bg-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border-2 border-teal-500" style="display: none;">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b-2 border-teal-800 pb-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2.5 bg-teal-800 rounded-xl text-teal-200 border border-teal-500 shadow-inner">
                                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="space-y-1.5">
                                <h3 class="font-black text-gray-900 text-lg tracking-wide bg-white px-3.5 py-1.5 rounded-lg border-2 border-teal-500 inline-block shadow-md">Weather Update</h3>
                                <p class="text-xs text-teal-300 font-semibold tracking-wider uppercase bg-teal-950/80 px-2.5 py-1 rounded border border-teal-800/80 inline-block shadow-sm" x-text="'📍 ' + locationName"></p>
                            </div>
                        </div>
                        <span class="text-xs font-bold px-3.5 py-1.5 rounded-full bg-teal-900 text-teal-200 border-2 border-teal-500 shadow-inner flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-teal-400 animate-ping"></span>
                            <span>Live</span>
                        </span>
                    </div>

                    <!-- Weather Grid Details -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        
                        <!-- Temperature Card -->
                        <div class="p-5 bg-emerald-950 rounded-2xl border-2 border-emerald-600 shadow-lg flex flex-col justify-between group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider bg-emerald-900 px-2 py-0.5 rounded border border-emerald-500">Temperature</span>
                                <div class="p-2 bg-emerald-800 text-emerald-200 rounded-xl border border-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-2xl sm:text-3xl font-black text-gray-900 mt-4 tracking-tight bg-white p-2.5 rounded-xl text-center border-2 border-emerald-500 shadow-md" x-text="temperature">Loading...</span>
                        </div>

                        <!-- Condition Card -->
                        <div class="p-5 bg-teal-950 rounded-2xl border-2 border-teal-600 shadow-lg flex flex-col justify-between group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-teal-300 uppercase tracking-wider bg-teal-900 px-2 py-0.5 rounded border border-teal-500">Condition</span>
                                <div class="p-2 bg-teal-800 text-teal-200 rounded-xl border border-teal-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-base sm:text-lg font-bold text-gray-900 mt-4 tracking-tight truncate bg-white p-2.5 rounded-xl text-center border-2 border-teal-500 shadow-md" x-text="condition">Fetching...</span>
                        </div>

                        <!-- Humidity Card -->
                        <div class="p-5 bg-cyan-950 rounded-2xl border-2 border-cyan-600 shadow-lg flex flex-col justify-between group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-cyan-300 uppercase tracking-wider bg-cyan-900 px-2 py-0.5 rounded border border-cyan-500">Humidity</span>
                                <div class="p-2 bg-cyan-800 text-cyan-200 rounded-xl border border-cyan-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-2xl sm:text-3xl font-black text-gray-900 mt-4 tracking-tight bg-white p-2.5 rounded-xl text-center border-2 border-cyan-500 shadow-md" x-text="humidity">--</span>
                        </div>

                        <!-- Wind Speed Card -->
                        <div class="p-5 bg-green-950 rounded-2xl border-2 border-green-600 shadow-lg flex flex-col justify-between group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-green-300 uppercase tracking-wider bg-green-900 px-2 py-0.5 rounded border border-green-500">Wind Speed</span>
                                <div class="p-2 bg-green-800 text-green-200 rounded-xl border border-green-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-2xl sm:text-3xl font-black text-gray-900 mt-4 tracking-tight bg-white p-2.5 rounded-xl text-center border-2 border-green-500 shadow-md" x-text="windSpeed">--</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Alpine.js script -->
    <script>
        function weatherWidget(apiKey, lat, lon, locationName) {
            return {
                temperature: '25°C',
                condition: 'Normal',
                humidity: '80%',
                windSpeed: '2mph',
                locationName: locationName,
                isOnline: navigator.onLine,
                hasApiKeyError: false,

                async fetchWeather() {
                    if (!apiKey || apiKey.trim() === '') {
                        this.hasApiKeyError = true;
                        return;
                    }

                    if (!navigator.onLine) {
                        this.isOnline = false;
                        return;
                    }

                    try {
                        let response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m`);
                        
                        if (!response.ok) throw new Error('Network response was not ok');

                        let data = await response.json();

                        if (data && data.current) {
                            this.temperature = Math.round(data.current.temperature_2m) + '°C';
                            this.humidity = data.current.relative_humidity_2m + '%';
                            this.windSpeed = Math.round(data.current.wind_speed_10m) + ' mph';
                            
                            const code = data.current.weather_code;
                            if (code === 0) this.condition = 'Sunny / Clear';
                            else if (code >= 1 && code <= 3) this.condition = 'Partly cloudy';
                            else if (code >= 51 && code <= 67) this.condition = 'Raining';
                            else if (code >= 95) this.condition = 'Thunderstorm';
                            else this.condition = 'Normal';

                            this.isOnline = true;
                            this.hasApiKeyError = false;
                        }
                    } catch (error) {
                        console.warn('Network request failed.', error);
                        this.isOnline = false;
                    }
                },

                init() {
                    this.fetchWeather();

                    window.addEventListener('online', () => {
                        this.isOnline = true;
                        this.fetchWeather();
                    });

                    window.addEventListener('offline', () => {
                        this.isOnline = false;
                    });
                }
            }
        }
    </script>
</x-app-layout>