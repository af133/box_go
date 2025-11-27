@extends('layouts.admin')

@section('title', 'Daftar Order')
@section('page-title', 'Manajemen Order')
@section('page-subtitle', 'Kelola dan konfirmasi pembayaran order')

@section('content')
<div class="space-y-6">
    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Cari pelanggan, lokasi, atau mitra..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis Barang</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mitra</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->pelanggan->nama ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->jenis_barang->jenis_barang ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $order->lokasi->nama_lokasi ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->lokasi->mitra->nama ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">
                                <div>{{ \Carbon\Carbon::parse($order->tanggal_penitipan)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400">s/d {{ \Carbon\Carbon::parse($order->tanggal_pengembalian)->format('d M Y') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($order->status === 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($order->status === 'Diterima')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Diterima
                                </span>
                            @elseif($order->status === 'Ditolak')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="openDetailModal({{ $order->id_order }})"
                                class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">Belum ada order</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="bg-white rounded-xl shadow-sm p-4">
        {{ $orders->links() }}
    </div>
    @endif
</div>

<!-- Modal Detail Order -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-lg bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b">
            <h3 class="text-2xl font-bold text-gray-900">Detail Order</h3>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div id="modalContent" class="mt-6">
            <!-- Loading State -->
            <div id="loadingState" class="flex items-center justify-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
            </div>

            <!-- Content akan diisi via JavaScript -->
            <div id="orderContent" class="hidden space-y-6">
                <!-- Informasi Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Pelanggan -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Pelanggan
                        </h4>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs text-gray-500">Nama Pelanggan</label>
                                <p class="font-medium text-gray-900" id="modal_pelanggan">-</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Jenis Barang</label>
                                <p class="font-medium text-gray-900" id="modal_jenis_barang">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Lokasi -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Informasi Lokasi
                        </h4>
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs text-gray-500">Nama Lokasi</label>
                                <p class="font-medium text-gray-900" id="modal_nama_lokasi">-</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Mitra</label>
                                <p class="font-medium text-gray-900" id="modal_mitra">-</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Alamat</label>
                                <p class="text-sm text-gray-700" id="modal_alamat">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Periode Penitipan
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500">Tanggal Penitipan</label>
                            <p class="font-medium text-gray-900" id="modal_tanggal_penitipan">-</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">Tanggal Pengembalian</label>
                            <p class="font-medium text-gray-900" id="modal_tanggal_pengembalian">-</p>
                        </div>
                    </div>
                </div>

                <!-- Bukti -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Foto Barang -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Foto Barang</h4>
                        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
                            <img id="modal_path_gambar" src="" alt="Foto Barang" class="w-full h-64 object-cover cursor-pointer hover:opacity-90 transition" onclick="openImageModal(this.src)">
                        </div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Bukti Pembayaran</h4>
                        <div class="bg-white rounded-lg overflow-hidden border border-gray-200">
                            <img id="modal_path_pembayaran" src="" alt="Bukti Pembayaran" class="w-full h-64 object-cover cursor-pointer hover:opacity-90 transition" onclick="openImageModal(this.src)">
                        </div>
                    </div>
                </div>

                <!-- Status dan Actions -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <label class="text-xs text-gray-500">Status Order</label>
                            <p class="font-semibold text-lg" id="modal_status">-</p>
                        </div>
                        <div id="actionButtons" class="flex gap-3">
                            <!-- Buttons akan ditampilkan hanya jika status Pending -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar Full -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-5xl max-h-full">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="imagePreview" src="" alt="Preview" class="max-w-full max-h-screen object-contain">
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Status filter
    document.getElementById('statusFilter').addEventListener('change', function(e) {
        const status = e.target.value;
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            if (!status) {
                row.style.display = '';
            } else {
                const statusText = row.querySelector('td:nth-child(7)')?.textContent.trim();
                row.style.display = statusText?.includes(status) ? '' : 'none';
            }
        });
    });

    // Open Detail Modal - FIXED
    function openDetailModal(orderId) {
        // VALIDASI: Pastikan orderId ada dan valid
        if (!orderId || orderId === 'undefined') {
            console.error('Invalid order ID:', orderId);
            alert('ID Order tidak valid');
            return;
        }

        console.log('Opening modal for order ID:', orderId); // Debug log

        const modal = document.getElementById('detailModal');
        const loadingState = document.getElementById('loadingState');
        const orderContent = document.getElementById('orderContent');

        modal.classList.remove('hidden');
        loadingState.classList.remove('hidden');
        orderContent.classList.add('hidden');

        // Fetch order details - gunakan route yang benar
        fetch(`/admin/orders/${orderId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Cek content-type
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new TypeError("Response bukan JSON!");
            }

            return response.json();
        })
        .then(result => {
            if (result.status) {
                const data = result.data;

                // Populate modal with data
                document.getElementById('modal_pelanggan').textContent = data.pelanggan || '-';
                document.getElementById('modal_jenis_barang').textContent = data.jenis_barang || '-';
                document.getElementById('modal_nama_lokasi').textContent = data.nama_lokasi || '-';
                document.getElementById('modal_mitra').textContent = data.mitra || '-';
                document.getElementById('modal_alamat').textContent = data.alamat_lokasi || '-';
                document.getElementById('modal_tanggal_penitipan').textContent = formatDate(data.tanggal_penitipan);
                document.getElementById('modal_tanggal_pengembalian').textContent = formatDate(data.tanggal_pengembalian);

                // Set images
                const imgBarang = document.getElementById('modal_path_gambar');
                const imgPembayaran = document.getElementById('modal_path_pembayaran');

                if (data.path_gambar) {
                    imgBarang.src = `/storage/${data.path_gambar}`;
                } else {
                    imgBarang.src = 'https://via.placeholder.com/400x300?text=Foto+Barang+Tidak+Tersedia';
                }

                if (data.path_pembayaran) {
                    imgPembayaran.src = `/storage/${data.path_pembayaran}`;
                } else {
                    imgPembayaran.src = 'https://via.placeholder.com/400x300?text=Bukti+Pembayaran+Tidak+Tersedia';
                }

                // Set status with color
                const statusEl = document.getElementById('modal_status');
                statusEl.textContent = data.status;
                statusEl.className = 'font-semibold text-lg';

                if (data.status === 'Pending' || data.status === 'pending') {
                    statusEl.classList.add('text-yellow-600');
                } else if (data.status === 'Diterima') {
                    statusEl.classList.add('text-green-600');
                } else if (data.status === 'Ditolak') {
                    statusEl.classList.add('text-red-600');
                }

                // Show action buttons only if status is Pending
                const actionButtons = document.getElementById('actionButtons');
                if (data.status === 'Pending' || data.status === 'pending') {
                    actionButtons.innerHTML = `
                        <button onclick="confirmReject(${data.id})"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-all transform hover:scale-105 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak
                        </button>
                        <button onclick="confirmApprove(${data.id})"
                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all transform hover:scale-105 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Terima
                        </button>
                    `;
                } else {
                    actionButtons.innerHTML = `
                        <div class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg">
                            Order sudah diproses
                        </div>
                    `;
                }

                loadingState.classList.add('hidden');
                orderContent.classList.remove('hidden');
            } else {
                alert('Gagal memuat data order');
                closeDetailModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data: ' + error.message);
            closeDetailModal();
        });
    }

    // Close Detail Modal
    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Open Image Modal
    function openImageModal(src) {
        document.getElementById('imagePreview').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    // Close Image Modal
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Confirm Approve
    function confirmApprove(orderId) {
        if (!orderId) {
            alert('ID Order tidak valid');
            return;
        }

        if (confirm('Apakah Anda yakin ingin menerima order ini?')) {
            updateOrderStatus(orderId, 'approve');
        }
    }

    // Confirm Reject
    function confirmReject(orderId) {
        if (!orderId) {
            alert('ID Order tidak valid');
            return;
        }

        if (confirm('Apakah Anda yakin ingin menolak order ini?')) {
            updateOrderStatus(orderId, 'reject');
        }
    }

    function updateOrderStatus(orderId, action) {
        if (!orderId) {
            alert('ID Order tidak valid');
            return;
        }

        // Gunakan route yang benar sesuai web.php
        const url = `/admin/orders/${orderId}/${action}`;

        console.log('Updating order:', orderId, 'Action:', action); // Debug log

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json' // Tambahkan ini untuk memastikan response JSON
            }
        })
        .then(response => {
            console.log('Response status:', response.status); // Debug log

            // Cek apakah response ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            // Cek content-type
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new TypeError("Response bukan JSON! Kemungkinan ada error redirect atau middleware issue");
            }

            return response.json();
        })
        .then(result => {
            console.log('Result:', result); // Debug log

            if (result.status) {
                alert(result.message);
                closeDetailModal();
                location.reload(); // Reload untuk update tabel
            } else {
                alert(result.message || 'Gagal mengupdate status order');
            }
        })
        .catch(error => {
            console.error('Error detail:', error);
            alert('Terjadi kesalahan: ' + error.message);
        });
    }

    // Format Date
    function formatDate(dateString) {
        if (!dateString) return '-';

        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', options);
    }

    // Close modal when clicking outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetailModal();
        }
    });
</script>
@endsection
