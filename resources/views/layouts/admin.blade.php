<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-green: #00AA13;
            --dark-gray: #616161;
            --light-gray: #F0F0F0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #F0F0F0;
        }

        .sidebar {
            background: linear-gradient(180deg, #00AA13 0%, #008f10 100%);
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            min-height: 100vh;
            height: 100%;
        }

        .menu-item {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: rgba(255, 255, 255, 0.1);
            transition: width 0.3s ease;
        }

        .menu-item:hover::before {
            width: 100%;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        }

        .btn-primary {
            background: linear-gradient(135deg, #00AA13 0%, #008f10 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 170, 19, 0.3);
        }

        .btn-secondary {
            background: #F0F0F0;
            color: #616161;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #E0E0E0;
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #00AA13;
            box-shadow: 0 0 0 3px rgba(0, 170, 19, 0.1);
        }

        .badge {
            background: #FF4444;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .notification {
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Sidebar container untuk memastikan sidebar full height */
        .sidebar-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 16rem; /* w-64 */
            height: 100vh;
            z-index: 30;
        }

        .sidebar-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
        }

        /* Custom scrollbar untuk sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Main content dengan margin kiri untuk sidebar */
        .main-content {
            margin-left: 16rem; /* w-64 */
        }

        @media (max-width: 768px) {
            .sidebar-container {
                transform: translateX(-100%);
            }

            .sidebar-container.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            /* Overlay untuk mobile */
            .mobile-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 20;
            }

            .mobile-overlay.active {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="mobile-overlay" onclick="toggleMobileMenu()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar-container">
        <div class="sidebar sidebar-content">
            <!-- Logo Section -->
            <div class="p-6 border-b border-white border-opacity-20 flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" style="color: #00AA13;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">Admin Panel</h1>
                        <p class="text-white text-xs opacity-75">Dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="sidebar-nav">
                <nav class="p-4 space-y-2">
                    <a href="{{ route('admin.mitra.index') }}" class="menu-item {{ request()->routeIs('admin.mitra.index') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-medium">List Mitra</span>
                    </a>

                    <a href="{{ route('admin.pelanggan.index') }}" class="menu-item {{ request()->routeIs('admin.pelanggan.index*') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-medium">List Pelanggan</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span class="font-medium">Order Mitra</span>
                    </a>

                    <a href="{{ route('admin.penarikan.index') }}" class="menu-item {{ request()->routeIs('admin.penarikan.index') ? 'active' : '' }} flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="font-medium">Penarikan Dana</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-white border-opacity-20 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="menu-item w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content min-h-screen overflow-y-auto">
        <!-- Top Bar -->
        <div class="bg-white shadow-sm p-4 md:p-6 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                <p class="text-sm text-gray-500">@yield('page-subtitle', 'Welcome to admin panel')</p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Mobile Menu Toggle -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- User Info -->
                <div class="hidden md:flex items-center space-x-3">
                    <img src="{{ Auth::user()->path_profil ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->nama ?? 'Admin').'&background=00AA13&color=fff' }}" alt="Profile" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->nama ?? 'Admin User' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->id_email ?? 'admin@gobox.com' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Area -->
        @if(session('success'))
        <div class="notification mx-4 md:mx-6 mt-4 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="notification mx-4 md:mx-6 mt-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Content Section -->
        <div class="p-4 md:p-6">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        // Auto-hide notifications after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
