<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Colors */
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

        .menu-icon {
            transition: transform 0.3s ease;
        }

        .menu-item:hover .menu-icon {
            transform: scale(1.1);
        }

        .topbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-dropdown {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .hamburger-line {
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }
        }

        .badge {
            background: #FF4444;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen">
    <aside id="sidebar" class="sidebar w-64 fixed md:static h-full z-30">

        <!-- Logo Section -->
        <div class="p-6 border-b border-white border-opacity-20">
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
        <nav class="p-4 space-y-2">

            <!-- Profil -->
            <a href="#" class="menu-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-medium">Profil</span>
            </a>

            <!-- List Mitra -->
            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="font-medium">List Mitra</span>
                <span class="badge ml-auto px-2 py-1 text-xs text-white rounded-full">12</span>
            </a>

            <!-- List Pelanggan -->
            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="font-medium">List Pelanggan</span>
                <span class="badge ml-auto px-2 py-1 text-xs text-white rounded-full">45</span>
            </a>

            <!-- Mitra Barang -->
            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="font-medium">Mitra Barang</span>
            </a>

            <!-- Payment -->
            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <span class="font-medium">Payment</span>
                <span class="badge ml-auto px-2 py-1 text-xs text-white rounded-full">3</span>
            </a>

        </nav>

        <!-- Sidebar Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white border-opacity-20">
            <a href="#" class="menu-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white">
                <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="font-medium">Logout</span>
            </a>
        </div>

    </aside>

    <main class="main-content">
    <header class="header">
        <h1>@yield('header', 'Dashboard Owner')</h1>
        <div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </header>

    <section>
        @yield('content')
    </section>
    </main>
    @yield('scripts')
</body>
</html>
