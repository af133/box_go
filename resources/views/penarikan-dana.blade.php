@extends('layouts.admin')

@section('title', 'Penarikan Dana')

@section('page-title', 'Penarikan Dana')
@section('page-subtitle', 'Kelola pengajuan penarikan dana mitra')

@section('styles')
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 50;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        animation: slideUp 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-pending {
        background-color: #FEF3C7;
        color: #92400E;
    }

    .status-approved {
        background-color: #D1FAE5;
        color: #065F46;
    }

    .status-rejected {
        background-color: #FEE2E2;
        color: #991B1B;
    }

    .table-hover tbody tr:hover {
        background-color: #F9FAFB;
    }
</style>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pengajuan</p>
                    <p class="text-2xl font-bold text-gray-800" id="totalPengajuan">0</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                    <p class="text-2xl font-bold text-yellow-600" id="totalPending">0</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Disetujui</p>
                    <p class="text-2xl font-bold text-green-600" id="totalApproved">Rp 0</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">Daftar Penarikan Dana</h2>
                <div class="flex items-center space-x-3">
                    <input type="text" id="searchInput" placeholder="Cari mitra..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-hover">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mitra</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data akan diisi via JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span id="showingStart">0</span> - <span id="showingEnd">0</span> dari <span id="totalData">0</span> data
                </div>
                <div class="flex space-x-2" id="paginationContainer">
                    <!-- Pagination buttons akan diisi via JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail & Action -->
<div id="detailModal" class="modal">
    <div class="modal-content bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800">Detail Penarikan Dana</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">ID Penarikan</p>
                    <p class="font-semibold text-gray-800" id="modalId">-</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <span id="modalStatus" class="status-badge">-</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama Mitra</p>
                    <p class="font-semibold text-gray-800" id="modalMitra">-</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Penarikan</p>
                    <p class="font-semibold text-gray-800" id="modalTanggal">-</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Jumlah Penarikan</p>
                    <p class="text-2xl font-bold text-green-600" id="modalJumlah">-</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Alasan Penarikan</p>
                    <p class="text-gray-800" id="modalAlasan">-</p>
                </div>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3" id="modalActions">
            <!-- Action buttons akan diisi via JavaScript -->
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="modal">
    <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 rounded-full mx-auto mb-4" id="confirmIcon">
                <!-- Icon akan diisi via JavaScript -->
            </div>
            <h3 class="text-lg font-bold text-center text-gray-800 mb-2" id="confirmTitle">Konfirmasi</h3>
            <p class="text-center text-gray-600 mb-6" id="confirmMessage">Apakah Anda yakin?</p>
            <div class="flex space-x-3">
                <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>
                <button onclick="confirmAction()" class="flex-1 px-4 py-2 rounded-lg text-white transition" id="confirmButton">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let allData = [];
    let filteredData = [];
    let currentPage = 1;
    const itemsPerPage = 10;
    let currentAction = null;
    let currentId = null;

    // Fetch data from API
    async function fetchData() {
        try {
            const response = await fetch('/admin/penarikan-dana/data', { // ← Ganti ke route API
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();

            if (result.success) {
                allData = result.data;
                filteredData = allData;
                updateStats();
                renderTable();
            } else {
                showNotification('Gagal memuat data: ' + (result.message || 'Unknown error'), 'error');
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            showNotification('Terjadi kesalahan saat memuat data: ' + error.message, 'error');
        }
    }

    // Confirm action - FIXED
    async function confirmAction() {
        if (!currentAction || !currentId) {
            console.error('Invalid action or ID');
            return;
        }

        try {
            // ✅ URL benar sesuai route Laravel
            const response = await fetch(`/admin/penarikan-dana/${currentAction}/${currentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            // ✅ Cek HTTP status
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `HTTP ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                closeConfirmModal();
                await fetchData(); // Reload data
                showNotification(result.message, 'success');
            } else {
                showNotification(result.message || 'Terjadi kesalahan', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan: ' + error.message, 'error');
        }
    }

    // Show detail modal - FIXED
    function showDetail(id) {
        const item = allData.find(d => d.id === id);
        if (!item) {
            console.error('Item not found:', id);
            showNotification('Data tidak ditemukan', 'error');
            return;
        }

        // Populate modal
        document.getElementById('modalId').textContent = '#' + item.id;
        document.getElementById('modalMitra').textContent = item.mitra?.nama || 'N/A';
        document.getElementById('modalTanggal').textContent = formatDate(item.tanggal_penarikan);
        document.getElementById('modalJumlah').textContent = formatCurrency(item.jumlah_penarikan);
        document.getElementById('modalAlasan').textContent = item.alasan_penarikan || '-';

        const statusBadge = document.getElementById('modalStatus');
        statusBadge.textContent = getStatusText(item.status);
        statusBadge.className = `status-badge status-${item.status}`;

        const actionsDiv = document.getElementById('modalActions');

        if (item.status === 'pending') {
            actionsDiv.innerHTML = `
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Tutup
                </button>
                <button onclick="showConfirm('reject', ${item.id})" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Tolak
                </button>
                <button onclick="showConfirm('approve', ${item.id})" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Setujui
                </button>
            `;
        } else {
            actionsDiv.innerHTML = `
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Tutup
                </button>
            `;
        }

        document.getElementById('detailModal').classList.add('active');
    }

    // Improved notification
    function showNotification(message, type = 'info') {
        // Hapus notifikasi lama jika ada
        const existingNotification = document.querySelector('.js-notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Buat notifikasi baru
        const colors = {
            success: 'bg-green-100 border-green-400 text-green-700',
            error: 'bg-red-100 border-red-400 text-red-700',
            info: 'bg-blue-100 border-blue-400 text-blue-700'
        };

        const notification = document.createElement('div');
        notification.className = `js-notification notification mx-4 md:mx-6 mt-4 p-4 rounded-lg border ${colors[type] || colors.info} fixed top-20 right-4 z-50 shadow-lg`;
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        ${type === 'success'
                            ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>'
                            : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>'
                        }
                    </svg>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Initialize - FIXED
    document.addEventListener('DOMContentLoaded', function() {
        fetchData();

        // Setup search with debounce
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = e.target.value.toLowerCase();
                filteredData = allData.filter(item =>
                    item.mitra?.nama?.toLowerCase().includes(searchTerm) ||
                    item.id.toString().includes(searchTerm)
                );
                currentPage = 1;
                renderTable();
            }, 300); // Debounce 300ms
        });
    });

    // Utility functions tetap sama
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function getStatusText(status) {
        const statusMap = {
            'pending': 'Menunggu',
            'approved': 'Disetujui',
            'rejected': 'Ditolak'
        };
        return statusMap[status] || status;
    }

    // Modal functions tetap sama
    function closeModal() {
        document.getElementById('detailModal').classList.remove('active');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.remove('active');
        currentAction = null;
        currentId = null;
    }
</script>
@endsection
