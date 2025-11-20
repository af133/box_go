import 'package:flutter/material.dart';


// --- Data Mockup untuk Card Penitipan ---
final List<Map<String, dynamic>> _mockBoardingData = [
  {
    'id': 1,
    'title': 'Kucing Peliharaan (Persia)',
    'status': 'Aktif',
    'duration': '5 Hari',
    'image_url': 'https://placehold.co/600x400/9b59b6/ffffff?text=Kucing',
  },
  {
    'id': 2,
    'title': 'Anjing Peliharaan (Golden)',
    'status': 'Aktif',
    'duration': '3 Hari',
    'image_url': 'https://placehold.co/600x400/3498db/ffffff?text=Anjing',
  },
  {
    'id': 3,
    'title': 'Hamster Kecil',
    'status': 'Selesai',
    'duration': '1 Hari',
    'image_url': 'https://placehold.co/600x400/2ecc71/ffffff?text=Hewan+Kecil',
  },
  {
    'id': 4,
    'title': 'Tanaman Hias (Anggrek)',
    'status': 'Aktif',
    'duration': '10 Hari',
    'image_url': 'https://placehold.co/600x400/f39c12/ffffff?text=Tanaman',
  },
  {
    'id': 5,
    'title': 'Sepeda Gunung',
    'status': 'Selesai',
    'duration': '2 Hari',
    'image_url': 'https://placehold.co/600x400/e74c3c/ffffff?text=Barang',
  },
];

// --- Komponen Widget Pembantu ---

class QuickFeatureButton extends StatelessWidget {
  final IconData icon;
  final String label;

  const QuickFeatureButton({
    super.key,
    required this.icon,
    required this.label,
  });

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: () {
        // Aksi ketika fitur cepat di-klik
        print('Fitur $label diklik');
      },

      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: Colors.blue.shade50,
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: Colors.blue.shade700, size: 28),
          ),
          const SizedBox(height: 8),
          Text(
            label,
            style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w500),
            textAlign: TextAlign.center,
          ),
        ],
      ),
    );
  }
}

class BoardingCard extends StatelessWidget {
  final Map<String, dynamic> data;

  const BoardingCard({super.key, required this.data});

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.only(bottom: 16),
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Padding(
        padding: const EdgeInsets.all(12.0),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Gambar/Foto
            ClipRRect(
              borderRadius: BorderRadius.circular(8.0),
              child: Image.network(
                data['image_url'],
                width: 80,
                height: 80,
                fit: BoxFit.cover,
                errorBuilder: (context, error, stackTrace) => Container(
                  width: 80,
                  height: 80,
                  color: Colors.grey.shade300,
                  child: const Center(
                    child: Icon(Icons.photo, color: Colors.grey),
                  ),
                ),
              ),
            ),
            const SizedBox(width: 12),
            // Detail Item
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    data['title'],
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      color: Colors.black87,
                    ),
                    maxLines: 2,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 4),
                  Row(
                    children: [
                      Icon(
                        Icons.access_time,
                        size: 14,
                        color: Colors.grey.shade600,
                      ),
                      const SizedBox(width: 4),
                      Text(
                        'Durasi: ${data['duration']}',
                        style: TextStyle(
                          fontSize: 13,
                          color: Colors.grey.shade600,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 4),
                  // Status
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 8,
                      vertical: 4,
                    ),
                    decoration: BoxDecoration(
                      color: data['status'] == 'Aktif'
                          ? Colors.green.shade100
                          : Colors.orange.shade100,
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Text(
                      data['status'],
                      style: TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        color: data['status'] == 'Aktif'
                            ? Colors.green.shade700
                            : Colors.orange.shade700,
                      ),
                    ),
                  ),
                ],
              ),
            ),
            const Icon(Icons.arrow_forward_ios, size: 16, color: Colors.grey),
          ],
        ),
      ),
    );
  }
}

// --- Widget Utama Bodyhome ---

class Bodyhome extends StatelessWidget {
  const Bodyhome({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false, // Hapus tombol back jika ada
        title: const Text(
          'Beranda',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
        backgroundColor: Colors.white,
        elevation: 0.5,
      ),
      // --- Bagian Body (Daftar Bergulir) ---
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: <Widget>[
              // 1. Search Bar
              TextField(
                decoration: InputDecoration(
                  hintText: 'Cari penitipan atau layanan...',
                  prefixIcon: const Icon(Icons.search, color: Colors.grey),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide.none,
                  ),
                  filled: true,
                  fillColor: Colors.grey.shade100,
                  contentPadding: const EdgeInsets.symmetric(vertical: 15),
                ),
              ),
              const SizedBox(height: 24),

              // 2. Judul Penitipan Aktif
              const Text(
                'Penitipan yang sedang aktif',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Colors.black87,
                ),
              ),
              const SizedBox(height: 16),

              // 3. Quick Features (Baris)
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: const <Widget>[
                  QuickFeatureButton(
                    icon: Icons.receipt_long,
                    label: 'History Pemesanan',
                  ),
                  QuickFeatureButton(
                    icon: Icons.luggage,
                    label: 'Penitipan Barang',
                  ),
                  QuickFeatureButton(
                    icon: Icons.local_hospital,
                    label: 'Layanan Darurat',
                  ),
                  QuickFeatureButton(
                    icon: Icons.support_agent,
                    label: 'Pusat Bantuan',
                  ),
                ],
              ),
              const SizedBox(height: 30),

              // 4. Judul dan "Show More"
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: <Widget>[
                  const Text(
                    'Rekomendasi Layanan',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Colors.black87,
                    ),
                  ),
                  TextButton(
                    onPressed: () {
                      print('Show More ditekan');
                    },
                    child: const Text(
                      'show more >',
                      style: TextStyle(
                        color: Colors.blue,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 16),

              // 5. Card Penitipan (Menampilkan 5)
              Column(
                children: _mockBoardingData
                    .map((data) => BoardingCard(data: data))
                    .toList(),
              ),
            ],
          ),
        ),
      ),

      // --- 6. Bottom Navigation Bar ---
    );
  }

 
}
