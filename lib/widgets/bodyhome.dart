import 'package:flutter/material.dart';

// --- Data Mockup untuk Card Penitipan Horizontal ---
// Data untuk Layanan yang Sedang Aktif oleh pengguna
final List<Map<String, dynamic>> _activeBoardingData = [
  {
    'id': 1,
    'title': 'Kucing Persia (Aktif)',
    'duration': '5 Hari',
    'image_url': 'https://placehold.co/600x400/9b59b6/ffffff?text=Aktif+1',
  },
  {
    'id': 2,
    'title': 'Anjing Golden (Aktif)',
    'duration': '3 Hari',
    'image_url': 'https://placehold.co/600x400/3498db/ffffff?text=Aktif+2',
  },
];

// Data untuk Layanan Terdekat
final List<Map<String, dynamic>> _nearbyBoardingData = [
  {
    'id': 3,
    'title': 'Pet Care Center (2km)',
    'duration': 'Jasa Perawatan',
    'image_url': 'https://placehold.co/600x400/2ecc71/ffffff?text=Terdekat+1',
  },
  {
    'id': 4,
    'title': 'Gudang Penyimpanan (1km)',
    'duration': 'Barang Besar',
    'image_url': 'https://placehold.co/600x400/f39c12/ffffff?text=Terdekat+2',
  },
  {
    'id': 5,
    'title': 'Penitipan Harian (500m)',
    'duration': 'Khusus Hewan',
    'image_url': 'https://placehold.co/600x400/e74c3c/ffffff?text=Terdekat+3',
  },
  {
    'id': 6,
    'title': 'Layanan Kebersihan (3km)',
    'duration': 'Rumah/Kantor',
    'image_url': 'https://placehold.co/600x400/c0392b/ffffff?text=Terdekat+4',
  },
];

// Data untuk Layanan Tervaforit
final List<Map<String, dynamic>> _favoriteBoardingData = [
  {
    'id': 7,
    'title': 'Pet Hotel Mewah ★5',
    'duration': 'Rating 4.9',
    'image_url': 'https://placehold.co/600x400/1abc9c/ffffff?text=Favorit+1',
  },
  {
    'id': 8,
    'title': 'Jasa Antar Cepat',
    'duration': 'Terpercaya',
    'image_url': 'https://placehold.co/600x400/9b59b6/ffffff?text=Favorit+2',
  },
  {
    'id': 9,
    'title': 'Pusat Karantina',
    'duration': 'Tersertifikasi',
    'image_url': 'https://placehold.co/600x400/34495e/ffffff?text=Favorit+3',
  },
];

// --- Komponen Widget Pembantu ---

// Card untuk tampilan horizontal (lebih ringkas)
class BoardingCard extends StatelessWidget {
  final Map<String, dynamic> data;

  const BoardingCard({super.key, required this.data});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: () {
        print('Card ${data['title']} diklik');
      },
      child: SizedBox(
        width: 160, // Lebar tetap untuk kartu horizontal
        child: Card(
          elevation: 4,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Bagian Gambar
              ClipRRect(
                borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
                child: Image.network(
                  data['image_url'],
                  height: 80,
                  width: 160,
                  fit: BoxFit.cover,
                  errorBuilder: (context, error, stackTrace) => Container(
                    height: 80,
                    width: 160,
                    color: Colors.grey.shade300,
                    child: const Center(child: Icon(Icons.photo, color: Colors.grey)),
                  ),
                ),
              ),
              // Bagian Detail
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      data['title'],
                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13),
                      overflow: TextOverflow.ellipsis,
                      maxLines: 1,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      data['duration'],
                      style: TextStyle(fontSize: 11, color: Colors.grey.shade600),
                      overflow: TextOverflow.ellipsis,
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}

// Widget untuk setiap bagian horizontal yang bisa digeser
class HorizontalSection extends StatelessWidget {
  final String title;
  final List<Map<String, dynamic>> dataList;

  const HorizontalSection({super.key, required this.title, required this.dataList});

  @override
  Widget build(BuildContext context) {
    if (dataList.isEmpty && title == 'Penitipan yang sedang aktif') {
      // Tampilkan pesan khusus jika tidak ada penitipan aktif
      return Container(
        padding: const EdgeInsets.only(bottom: 20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Penitipan yang sedang aktif',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
                color: Colors.black87,
              ),
            ),
            const SizedBox(height: 10),
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.yellow.shade50,
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: Colors.yellow.shade200),
              ),
              child: Row(
                children: [
                  Icon(Icons.info_outline, color: Colors.orange.shade700),
                  const SizedBox(width: 10),
                  const Text('Anda tidak memiliki penitipan yang sedang aktif.'),
                ],
              ),
            ),
          ],
        ),
      );
    }
    
    // Tampilan normal untuk bagian yang memiliki data
    return Container(
      padding: const EdgeInsets.only(bottom: 20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Judul dan "Show More"
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[
              Text(
                title,
                style: const TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Colors.black87,
                ),
              ),
              TextButton(
                onPressed: () {
                  print('Show More ditekan untuk $title');
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
          
          // Daftar Card Horizontal
          SizedBox(
            height: 160, // Tinggi tetap untuk ListView horizontal
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              itemCount: dataList.length,
              itemBuilder: (context, index) {
                return Padding(
                  // Tambahkan sedikit padding kanan antar card
                  padding: EdgeInsets.only(right: 10, left: index == 0 ? 0 : 0),
                  child: BoardingCard(data: dataList[index]),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}

class QuickFeatureButton extends StatelessWidget {
  final IconData icon;
  final String label;

  const QuickFeatureButton({super.key, required this.icon, required this.label});

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

// --- Widget Utama Bodyhome ---

class Bodyhome extends StatelessWidget {
  const Bodyhome({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false, // Hapus tombol back jika ada
        title: const Text('Beranda', style: TextStyle(fontWeight: FontWeight.bold)),
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
                  hintText: 'Cari layanan, lokasi atau barang...',
                  prefixIcon: const Icon(Icons.search, color: Colors.grey),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide.none,
                  ),
                  filled: true,
                  fillColor: Colors.grey.shade100,
                  contentPadding: const EdgeInsets.symmetric(vertical: 15, horizontal: 10),
                ),
              ),
              const SizedBox(height: 24),

              // 2. Layanan yang Sedang Aktif (Horizontal)
              HorizontalSection(
                title: 'Penitipan yang sedang aktif',
                dataList: _activeBoardingData,
              ),
              
              // 3. Quick Features (Baris)
              const Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: <Widget>[
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

              // 4. Layanan Terdekat (Horizontal)
              HorizontalSection(
                title: 'Layanan Terdekat',
                dataList: _nearbyBoardingData,
              ),

              // 5. Layanan Tervaforit (Horizontal)
              HorizontalSection(
                title: 'Layanan Tervaforit',
                dataList: _favoriteBoardingData,
              ),
              
              // Tambahkan jarak bawah sebelum navigasi
              const SizedBox(height: 20),
            ],
          ),
        ),
      ),
    );
  }
}

// Widget utama untuk menjalankan aplikasi (hanya contoh)
// void main() {
//   runApp(const MyApp());
// }

// class MyApp extends StatelessWidget {
//   const MyApp({super.key});

//   @override
//   Widget build(BuildContext context) {
//     return const MaterialApp(
//       title: 'Home Screen Demo',
//       debugShowCheckedModeBanner: false,
//       home: Bodyhome(),
//     );
//   }
// }