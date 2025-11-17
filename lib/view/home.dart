import 'package:flutter/material.dart';
// Asumsikan Anda memiliki file ModeSwitcher di sini
// import '../widgets/mode_switcher.dart'; 

// --- DEFINISI WARNA (PENTING UNTUK KONSISTENSI) ---
const Color gojekGreen = Color(0xFF00AA13);
const Color darkGrey = Color(0xFF616161);
const Color lightGrey = Color(0xFFF0F0F0);
// ---------------------------------------------------

// Placeholder untuk ModeSwitcher jika Anda belum membuatnya
class ModeSwitcher extends StatelessWidget {
  const ModeSwitcher({super.key});
  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
      decoration: BoxDecoration(
        color: gojekGreen,
        borderRadius: BorderRadius.circular(30),
      ),
      child: const Text(
        'Pelanggan',
        style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
      ),
    );
  }
}
// ---------------------------------------------------

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // --- APP BAR ---
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0, // Garis bawah dihilangkan (gaya minimalis)
        automaticallyImplyLeading: false, // Hilangkan tombol back default

        // Title: Sapaan (Leading dihilangkan)
        title: const Text(
          'Halo, Rian!', // Ganti dengan data user
          style: TextStyle(
            color: Colors.black87,
            fontWeight: FontWeight.bold,
            fontSize: 22,
          ),
        ),

        // Actions: Toggle Mode & Notifikasi
        actions: [
          const ModeSwitcher(), // Widget Mode Mitra/Pelanggan
          const SizedBox(width: 8),
          IconButton(
            icon: const Icon(Icons.notifications_none, color: Colors.black87),
            onPressed: () {
              // Navigasi ke Halaman Notifikasi
            },
          ),
          const SizedBox(width: 8),
        ],
      ),

      // --- BODY UTAMA ---
      body: const HomeBody(),

      // --- BOTTOM NAVIGATION BAR (Wajib untuk Navigasi Cepat) ---
      // Anda perlu membuat implementasi BottomNavigationBar yang sebenarnya
      bottomNavigationBar: _buildBottomNavBar(),
    );
  }
  
  // Placeholder Bottom Navigation Bar
  Widget _buildBottomNavBar() {
    return BottomNavigationBar(
      type: BottomNavigationBarType.fixed, // Pastikan ikon tidak bergeser
      selectedItemColor: gojekGreen,
      unselectedItemColor: darkGrey,
      items: const [
        BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Home'),
        BottomNavigationBarItem(icon: Icon(Icons.storage), label: 'Pesanan'),
        BottomNavigationBarItem(icon: Icon(Icons.map_outlined), label: 'Peta'),
        BottomNavigationBarItem(icon: Icon(Icons.person), label: 'Akun'),
      ],
    );
  }
}

// --- WIDGET BODY ---

class HomeBody extends StatelessWidget {
  const HomeBody({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // 1. Search Bar (Cari Gudang)
          _buildSearchBar(context),
          const SizedBox(height: 20),

          // 2. Main Status Card (Sewa Aktif + Rute Cepat)
          _buildStatusCard(context),
          const SizedBox(height: 30),

          // 3. Menu Layanan Utama (Quick Actions)
          _buildQuickActionsMenu(),
          const SizedBox(height: 30),

          // 4. Promo Banner
          _buildPromoBanner(),
        ],
      ),
    );
  }

  // --- WIDGET 1: Search Bar ---
  Widget _buildSearchBar(BuildContext context) {
    return InkWell(
      onTap: () {
        // Aksi: Navigasi ke Halaman Pencarian Gudang
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Membuka Halaman Pencarian Gudang')),
        );
      },
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 12.0),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(30),
          border: Border.all(color: darkGrey.withOpacity(0.3)),
          boxShadow: [
            BoxShadow(
              color: Colors.grey.withOpacity(0.1),
              spreadRadius: 1,
              blurRadius: 5,
              offset: const Offset(0, 3),
            ),
          ],
        ),
        child: const Row(
          children: [
            Icon(Icons.search, color: darkGrey),
            SizedBox(width: 10),
            Expanded(
              child: Text(
                'Cari lokasi gudang mitra terdekat...',
                style: TextStyle(color: darkGrey, fontSize: 15),
              ),
            ),
            Icon(Icons.map_outlined, color: gojekGreen), // Ikon Lokasi/Map
          ],
        ),
      ),
    );
  }

  // --- WIDGET 2: Status Card (Integrated Maps) ---
  Widget _buildStatusCard(BuildContext context) {
    // ASUMSI: Ada sewa aktif
    return Card(
      elevation: 4,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(15),
          border: Border.all(color: gojekGreen.withOpacity(0.5)),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'SEWA AKTIF',
              style: TextStyle(
                color: gojekGreen,
                fontSize: 12,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 8),
            const Row(
              children: [
                Icon(Icons.lock_open_outlined, color: Colors.black87, size: 28),
                SizedBox(width: 10),
                Text(
                  'Unit Loker A1 di Gudang Sawah Besar',
                  style: TextStyle(
                    color: Colors.black87,
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 10),
            Text(
              'Sewa Berakhir: 18 Desember 2025',
              style: TextStyle(color: darkGrey, fontSize: 14),
            ),
            const SizedBox(height: 15),
            
            // Tombol Rute Cepat
            SizedBox(
              width: double.infinity,
              child: ElevatedButton.icon(
                onPressed: () {
                  // Aksi: MEMANGGIL FUNGSI NAVIGASI KE MAPS (Misal: menggunakan url_launcher)
                  // openMapsNavigation('Alamat Lengkap Gudang Mitra');
                  ScaffoldMessenger.of(context).showSnackBar(
                    const SnackBar(content: Text('Membuka Rute di Google Maps...')),
                  );
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: gojekGreen,
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(vertical: 12),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
                icon: const Icon(Icons.navigation_outlined, size: 20),
                label: const Text(
                  'Mulai Rute Cepat ke Gudang (3.5 km)',
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // --- WIDGET 3: Menu Layanan Utama ---
  Widget _buildQuickActionsMenu() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Akses Cepat',
          style: TextStyle(
            fontSize: 18,
            fontWeight: FontWeight.bold,
            color: Colors.black87,
          ),
        ),
        const SizedBox(height: 15),
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceAround,
          children: [
            _buildServiceIcon(Icons.add_business_outlined, 'Sewa Unit Baru'),
            _buildServiceIcon(Icons.map_outlined, 'Cek Peta Gudang'), // Peta Penting!
            _buildServiceIcon(Icons.access_time_outlined, 'Perpanjang Sewa'),
            _buildServiceIcon(Icons.history_toggle_off, 'Riwayat Sewa'),
          ],
        ),
      ],
    );
  }

  Widget _buildServiceIcon(IconData icon, String label) {
    return InkWell(
      onTap: () {
        // Aksi navigasi spesifik
      },
      child: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: lightGrey,
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, size: 30, color: gojekGreen),
          ),
          const SizedBox(height: 8),
          Text(
            label,
            textAlign: TextAlign.center,
            style: const TextStyle(fontSize: 12, color: darkGrey),
          ),
        ],
      ),
    );
  }

  // --- WIDGET 4: Promo Banner ---
  Widget _buildPromoBanner() {
    return Container(
      height: 100,
      width: double.infinity,
      decoration: BoxDecoration(
        // ignore: deprecated_member_use
        color: gojekGreen.withOpacity(0.1),
        borderRadius: BorderRadius.circular(15),
      ),
      padding: const EdgeInsets.all(15),
      child: const Row(
        children: [
          Icon(Icons.local_offer_outlined, color: gojekGreen, size: 30),
          SizedBox(width: 15),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Text(
                  'Diskon untuk Mitra Baru!',
                  style: TextStyle(
                      color: gojekGreen, fontWeight: FontWeight.bold),
                ),
                Text(
                  'Daftarkan gudang Anda sekarang dan dapatkan komisi 0%.',
                  style: TextStyle(color: darkGrey, fontSize: 13),
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}