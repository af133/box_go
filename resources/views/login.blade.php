<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Colors */
        :root {
            --primary-green: #00AA13;
            --dark-gray: #616161;
            --light-gray: #F0F0F0;
        }

        body {
            background: linear-gradient(135deg, #F0F0F0 0%, #E0E0E0 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .login-container {
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 170, 19, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #00AA13 0%, #008f10 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #008f10 0%, #007a0e 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 170, 19, 0.3);
        }

        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #E0E0E0;
        }

        .input-field:focus {
            border-color: #00AA13;
            box-shadow: 0 0 0 3px rgba(0, 170, 19, 0.1);
            outline: none;
        }

        .eye-icon {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .eye-icon:hover {
            color: #00AA13;
        }

        .error-message {
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .logo-text {
            color: #00AA13;
            font-weight: 700;
            font-size: 2rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Login Container -->
    <div class="login-container w-full max-w-md bg-white rounded-2xl p-8">

        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <h1 class="logo-text mb-2">BOX GO</h1>
            <p class="text-gray-500 text-sm"> Sistem Penitipan Barang Berbasis Lokasi</p>
        </div>

        <!-- Alert Error -->
        <div id="errorAlert" class="hidden error-message mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
            <p class="text-red-700 text-sm" id="errorMessage"></p>
        </div>

        <!-- Alert Success -->
        <div id="successAlert" class="hidden mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
            <p class="text-green-700 text-sm" id="successMessage"></p>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="space-y-6">

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium mb-2" style="color: #616161;">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="input-field w-full px-4 py-3 rounded-lg"
                    placeholder="admin@example.com"
                    required
                >
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium mb-2" style="color: #616161;">
                    Password
                </label>
                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="input-field w-full px-4 py-3 rounded-lg pr-12"
                        placeholder="••••••••"
                        required
                    >
                    <!-- Eye Icon -->
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                        <svg
                            id="eyeIcon"
                            class="eye-icon w-5 h-5"
                            style="color: #616161;"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <!-- Eye Closed (default) -->
                            <g id="eyeClosed">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </g>
                            <!-- Eye Open -->
                            <g id="eyeOpen" class="hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        id="remember"
                        class="w-4 h-4 rounded border-gray-300 focus:ring-2 focus:ring-offset-0"
                        style="accent-color: #00AA13;"
                    >
                    <span class="ml-2" style="color: #616161;">Ingat saya</span>
                </label>
                <a href="#" class="hover:underline" style="color: #00AA13;">
                    Lupa password?
                </a>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                id="submitBtn"
                class="btn-primary w-full py-3 text-white font-semibold rounded-lg"
            >
                <span id="btnText">Masuk</span>
                <span id="btnLoading" class="hidden">
                    <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>

        </form>

        <!-- Footer -->
        <div class="mt-6 text-center text-sm" style="color: #616161;">
            <p>Tidak punya akses? <a href="#" class="font-semibold hover:underline" style="color: #00AA13;">Hubungi Administrator</a></p>
        </div>

    </div>

    <!-- JavaScript -->
    <script>
        // Toggle Password Visibility
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeClosed = document.getElementById('eyeClosed');
        const eyeOpen = document.getElementById('eyeOpen');

        eyeIcon.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeClosed.classList.remove('hidden');
                eyeOpen.classList.add('hidden');
            }
        });

        // Form Submission
        const loginForm = document.getElementById('loginForm');
        const errorAlert = document.getElementById('errorAlert');
        const successAlert = document.getElementById('successAlert');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Hide alerts
            errorAlert.classList.add('hidden');
            successAlert.classList.add('hidden');

            // Show loading
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            // Get form data
            const formData = {
                role: 'admin',
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

            try {
                // API Call - sesuaikan dengan endpoint Laravel Anda
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (response.ok) {
                    // Success
                    successMessage.textContent = data.message || 'Login berhasil!';
                    successAlert.classList.remove('hidden');

                    // Save token to localStorage
                    localStorage.setItem('token', data.token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                    localStorage.setItem('role', data.role);

                    // Redirect after 1 second
                    setTimeout(() => {
                        window.location.href = '/admin/list-mitra';
                    }, 1000);
                } else {
                    // Error
                    errorMessage.textContent = data.message || 'Login gagal. Silakan coba lagi.';
                    errorAlert.classList.remove('hidden');
                }
            } catch (error) {
                errorMessage.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                errorAlert.classList.remove('hidden');
                console.error('Error:', error);
            } finally {
                // Hide loading
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }
        });

        // Auto-hide alerts after 5 seconds
        function autoHideAlert() {
            setTimeout(() => {
                errorAlert.classList.add('hidden');
                successAlert.classList.add('hidden');
            }, 5000);
        }

        // Call auto-hide whenever an alert is shown
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (!errorAlert.classList.contains('hidden') || !successAlert.classList.contains('hidden')) {
                    autoHideAlert();
                }
            });
        });

        observer.observe(errorAlert, { attributes: true, attributeFilter: ['class'] });
        observer.observe(successAlert, { attributes: true, attributeFilter: ['class'] });
    </script>

</body>
</html>
