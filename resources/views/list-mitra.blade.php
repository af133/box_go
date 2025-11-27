@extends('layouts.admin')

@section('title', 'List Mitra - Admin Dashboard')

@section('page-title', 'List Mitra')
@section('page-subtitle', 'Kelola data mitra GoBox')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="profile-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Mitra</p>
                    <p class="text-3xl font-bold text-gray-800" id="totalMitra">0</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="profile-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Mitra Aktif</p>
                    <p class="text-3xl font-bold text-green-600" id="mitraAktif">0</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="profile-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Lokasi Tersedia</p>
                    <p class="text-3xl font-bold text-purple-600" id="totalLokasi">0</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="profile-card p-4">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Cari nama, email, atau nomor HP..." class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none">
            </div>
            <button onclick="loadMitra()" class="btn-primary px-6 py-2 text-white rounded-lg font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari
            </button>
        </div>
    </div>

    <!-- Mitra Table -->
    <div class="profile-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mitra</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor HP</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="mitraTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data will be loaded here -->
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="profile-card max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Edit Data Mitra</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="editForm" class="space-y-4">
                <input type="hidden" id="editMitraId">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="editNama" class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="editEmail" class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                    <input type="text" id="editNomorHp" class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea id="editAlamat" rows="3" class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none" required></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn-primary flex-1 px-6 py-3 text-white rounded-lg font-medium">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()" class="btn-secondary flex-1 px-6 py-3 rounded-lg font-medium">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let allMitra = [];

    // Load data when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadMitra();
    });

    async function loadMitra() {
        try {
            const response = await fetch('/admin/mitra');
            const data = await response.json();
            allMitra = data.partners;

            displayMitra(allMitra);
            updateStats();
        } catch (error) {
            console.error('Error loading mitra:', error);
            showError('Gagal memuat data mitra');
        }
    }

    function displayMitra(mitras) {
        const tbody = document.getElementById('mitraTableBody');

        if (mitras.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        Tidak ada data mitra
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = mitras.map(mitra => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="${mitra.path_profil || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(mitra.nama) + '&background=00AA13&color=fff'}"
                             alt="${mitra.nama}"
                             class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-medium text-gray-900">${mitra.nama}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">${mitra.email?.email || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${mitra.nomor_hp || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    <span class="line-clamp-2">${mitra.alamat || '-'}</span>
                </td>
                <td class="px-6 py-4">
                    <button onclick="openEditModal(${mitra.id_mitra})" class="text-green-600 hover:text-green-800 font-medium text-sm">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function updateStats() {
        document.getElementById('totalMitra').textContent = allMitra.length;
        document.getElementById('mitraAktif').textContent = allMitra.length;
        document.getElementById('totalLokasi').textContent = allMitra.length * 2; // Example calculation
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filtered = allMitra.filter(mitra =>
            mitra.nama.toLowerCase().includes(searchTerm) ||
            (mitra.id_email && mitra.id_email.toLowerCase().includes(searchTerm)) ||
            (mitra.nomor_hp && mitra.nomor_hp.includes(searchTerm))
        );
        displayMitra(filtered);
    });

    function openEditModal(mitraId) {
        const mitra = allMitra.find(m => m.id_mitra === mitraId);
        if (!mitra) return;

        document.getElementById('editMitraId').value = mitra.id_mitra;
        document.getElementById('editNama').value = mitra.nama;
        document.getElementById('editEmail').value = mitra.email?.email || '';
        document.getElementById('editNomorHp').value = mitra.nomor_hp || '';
        document.getElementById('editAlamat').value = mitra.alamat || '';

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    }

    // Handle form submission
    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const mitraId = document.getElementById('editMitraId').value;
        const formData = {
            nama: document.getElementById('editNama').value,
            id_email: document.getElementById('editEmail').value,
            nomor_hp: document.getElementById('editNomorHp').value,
            alamat: document.getElementById('editAlamat').value,
        };

        try {
            const response = await fetch(`/admin/edit-user/mitra/${mitraId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                showSuccess('Data mitra berhasil diperbarui');
                closeEditModal();
                loadMitra();
            } else {
                showError(result.message || 'Gagal memperbarui data');
            }
        } catch (error) {
            console.error('Error updating mitra:', error);
            showError('Terjadi kesalahan saat memperbarui data');
        }
    });

    function showSuccess(message) {
        // You can implement a toast notification here
        alert(message);
    }

    function showError(message) {
        alert(message);
    }
</script>
@endsection
