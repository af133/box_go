@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('page-title', 'Profil Admin')
@section('page-subtitle', 'Kelola informasi profil Anda')

@section('content')
<div class="space-y-6">
    <!-- Profile Overview Card -->
    <div class="profile-card p-6">
        <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name=Admin&background=00AA13&color=fff&size=120" alt="Profile" class="w-32 h-32 rounded-full border-4 border-green-500">
                <div class="absolute bottom-0 right-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center border-4 border-white">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-800">Admin User</h2>
                <p class="text-sm text-gray-400 mt-2">Administrator</p>
                <div class="mt-4 flex flex-wrap gap-2 justify-center md:justify-start">
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Active</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Super Admin</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="profile-card p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Ubah Password</h3>
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="role" value="admin">
            <input type="hidden" name="id_email" value="admin@gobox.com">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Kosongkan jika tidak ingin mengubah">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Konfirmasi password baru">
                </div>

                <div class="flex space-x-3 pt-4">
                    <button type="submit" class="btn-primary px-6 py-3 text-white rounded-lg font-medium">
                        Simpan Perubahan
                    </button>
                    <button type="reset" class="btn-secondary px-6 py-3 rounded-lg font-medium">
                        Batal
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Account Info -->
    <div class="profile-card p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Akun</h3>
        <div class="space-y-3">
            <div class="flex justify-between py-3 border-b border-gray-200">
                <span class="text-gray-600">Email</span>
                <span class="font-medium text-gray-800">admin@gobox.com</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-200">
                <span class="text-gray-600">Role</span>
                <span class="font-medium text-gray-800">Administrator</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-200">
                <span class="text-gray-600">Status</span>
                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">Active</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-600">Terakhir Login</span>
                <span class="font-medium text-gray-800">{{ now()->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
