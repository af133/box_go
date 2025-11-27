@extends('layouts.admin')

@section('title', 'List Pelanggan - Admin Dashboard')

@section('page-title', 'List Pelanggan')
@section('page-subtitle', 'Kelola data pelanggan GoBox')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="profile-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pelanggan</p>
                    <p class="text-3xl font-bold text-gray-800" id="totalPelanggan">0</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="profile-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pelanggan Aktif</p>
                    <p class="text-3xl font-bold text-blue-600" id="pelangganAktif">0</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="profile-card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
                    <p class="text-3xl font-bold text-orange-600" id="totalPesanan">0</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
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
            <button onclick="loadPelanggan()" class="btn-primary px-6 py-2 text-white rounded-lg font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari
            </button>
        </div>
    </div>

    <!-- Pelanggan Table -->
    <div class="profile-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor HP</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pelangganTableBody" class="bg-white divide-y divide-gray-200">
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
                <h3 class="text-xl font-bold text-gray-800">Edit Data Pelanggan</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="editForm" class="space-y-4">
                <input type="hidden" id="editPelangganId">

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

<!-- Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="profile-card max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Detail Pelanggan</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div id="detailContent" class="space-y-4">
                <!-- Detail content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let allPelanggan = [];

    // Load data when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadPelanggan();
    });

    async function loadPelanggan() {
        try {
            const response = await fetch('/admin/pelanggan');
            const data = await response.json();
            allPelanggan = data.customers;

            displayPelanggan(allPelanggan);
            updateStats();
        } catch (error) {
            console.error('Error loading pelanggan:', error);
            showError('Gagal memuat data pelanggan');
        }
    }

    function displayPelanggan(pelanggans) {
        const tbody = document.getElementById('pelangganTableBody');

        if (pelanggans.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        Tidak ada data pelanggan
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = pelanggans.map(pelanggan => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="${pelanggan.path_profil || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(pelanggan.nama) + '&background=00AA13&color=fff'}"
                             alt="${pelanggan.nama}"
                             class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-medium text-gray-900">${pelanggan.nama}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">${pelanggan.email?.email || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${pelanggan.nomor_hp || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    <span class="line-clamp-2">${pelanggan.alamat || '-'}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <button onclick="openDetailModal(${pelanggan.id_pelanggan})" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Detail
                        </button>
                        <button onclick="openEditModal(${pelanggan.id_pelanggan})" class="text-green-600 hover:text-green-800 font-medium text-sm">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function updateStats() {
        document.getElementById('totalPelanggan').textContent = allPelanggan.length;
        document.getElementById('pelangganAktif').textContent = allPelanggan.length;
        document.getElementById('totalPesanan').textContent = allPelanggan.length * 3; // Example calculation
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filtered = allPelanggan.filter(pelanggan =>
            pelanggan.nama.toLowerCase().includes(searchTerm) ||
            (pelanggan.id_email && pelanggan.id_email.toLowerCase().includes(searchTerm)) ||
            (pelanggan.nomor_hp && pelanggan.nomor_hp.includes(searchTerm))
        );
        displayPelanggan(filtered);
    });

    function openEditModal(pelangganId) {
        const pelanggan = allPelanggan.find(p => p.id_pelanggan === pelangganId);
        if (!pelanggan) return;

        document.getElementById('editPelangganId').value = pelanggan.id_pelanggan;
        document.getElementById('editNama').value = pelanggan.nama;
        document.getElementById('editEmail').value = pelanggan.email?.email || '';
        document.getElementById('editNomorHp').value = pelanggan.nomor_hp || '';
        document.getElementById('editAlamat').value = pelanggan.alamat || '';

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editForm').reset();
    }

    function openDetailModal(pelangganId) {
        const pelanggan = allPelanggan.find(p => p.id_pelanggan === pelangganId);
        if (!pelanggan) return;

        const detailContent = document.getElementById('detailContent');
        detailContent.innerHTML = `
            <div class="flex items-center space-x-4 mb-6">
                <img src="${pelanggan.path_profil || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(pelanggan.nama) + '&background=00AA13&color=fff'}"
                     alt="${pelanggan.nama}"
                     class="w-20 h-20 rounded-full object-cover border-4 border-green-100">
                <div>
                    <h4 class="text-xl font-bold text-gray-800">${pelanggan.nama}</h4>
                    <p class="text-sm text-gray-500">ID Pelanggan: ${pelanggan.id_pelanggan}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Email</p>
                    <p class="font-medium text-gray-800">${pelanggan.email?.email || '-'}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Nomor HP</p>
                    <p class="font-medium text-gray-800">${pelanggan.nomor_hp || '-'}</p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg mt-4">
                <p class="text-sm text-gray-500 mb-1">Alamat</p>
                <p class="font-medium text-gray-800">${pelanggan.alamat || '-'}</p>
            </div>
        `;

        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Handle form submission
    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const pelangganId = document.getElementById('editPelangganId').value;
        const formData = {
            nama: document.getElementById('editNama').value,
            id_email: document.getElementById('editEmail').value,
            nomor_hp: document.getElementById('editNomorHp').value,
            alamat: document.getElementById('editAlamat').value,
        };

        try {
            const response = await fetch(`/admin/edit-user/pelanggan/${pelangganId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                showSuccess('Data pelanggan berhasil diperbarui');
                closeEditModal();
                loadPelanggan();
            } else {
                showError(result.message || 'Gagal memperbarui data');
            }
        } catch (error) {
            console.error('Error updating pelanggan:', error);
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
