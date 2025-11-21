// lib/widgets/bodyhome.dart
import 'package:flutter/material.dart';

// --- Widget Card Horizontal ---
class BoardingCard extends StatelessWidget {
  final Map<String, dynamic> data;
  final VoidCallback? onTap;

  const BoardingCard({super.key, required this.data, this.onTap});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap ?? () => print('Card ${data['title']} diklik'),
      child: SizedBox(
        width: 160,
        child: Card(
          elevation: 4,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              ClipRRect(
                borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
                child: Image.network(
                  data['path_area'] ??  'https://via.placeholder.com/160x80?text=No+Image',
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
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      data['title'] ?? 'Tidak ada nama',
                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13),
                      overflow: TextOverflow.ellipsis,
                      maxLines: 1,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      data['duration'] ?? '',
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

// --- Horizontal Section Widget ---
class HorizontalSection extends StatelessWidget {
  final String title;
  final List<Map<String, dynamic>> dataList;

  const HorizontalSection({super.key, required this.title, required this.dataList});

  @override
  Widget build(BuildContext context) {
    if (dataList.isEmpty) {
      return Container(
        padding: const EdgeInsets.only(bottom: 20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
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
                  const Expanded(child: Text('Belum ada data untuk section ini.')),
                ],
              ),
            ),
          ],
        ),
      );
    }

    return Container(
      padding: const EdgeInsets.only(bottom: 20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[
              Text(title, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
              TextButton(
                onPressed: () => {
                  Navigator.pushReplacementNamed(context, '/all_mitra')
                },
                child: const Text(
                  'show more >',
                  style: TextStyle(color: Colors.blue, fontWeight: FontWeight.bold),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          SizedBox(
            height: 160,
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              itemCount: dataList.length,
              itemBuilder: (context, index) {
                return Padding(
                  padding: EdgeInsets.only(right: 10, left: index == 0 ? 0 : 0),
                  child: BoardingCard(
                    data: dataList[index],
                    onTap: () {
                      print('Klik ${dataList[index]['title']}');
                    },
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}

// --- Quick Feature Button ---
class QuickFeatureButton extends StatelessWidget {
  final IconData icon;
  final String label;

  const QuickFeatureButton({super.key, required this.icon, required this.label});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: () {
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

// --- Bodyhome Utama ---
// --- Bodyhome Utama ---
class Bodyhome extends StatelessWidget {
  final List<dynamic> penitipanTerdekat;
  final List<dynamic> ratingTertinggi;

  const Bodyhome({
    super.key,
    required this.penitipanTerdekat,
    required this.ratingTertinggi,
  });

  // Helper function konversi dynamic ke double aman
  double parseDouble(dynamic value) {
    if (value == null) return 0.0;
    if (value is double) return value;
    if (value is int) return value.toDouble();
    return double.tryParse(value.toString()) ?? 0.0;
  }

  @override
  Widget build(BuildContext context) {
    final List<Map<String, dynamic>> terdekat = penitipanTerdekat.map((e) => {
      'title': e['nama_lokasi'] ?? 'Mitra',
      'duration': 'Jarak: ${parseDouble(e['distance']).toStringAsFixed(2)} km',
      'path_area': e['path_area'] ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHuipgoTjoZvHwH47qd8_n0Tg_El0rXGcywA&s',
    }).toList();

    final List<Map<String, dynamic>> rating = ratingTertinggi.map((e) => {
      'title': e['nama_lokasi'] ?? 'Mitra',
      'duration': 'Rating: ${parseDouble(e['rating_mitra_avg_rating']).toStringAsFixed(1)}',
      'path_area': e['path_area'] ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHuipgoTjoZvHwH47qd8_n0Tg_El0rXGcywA&s',
    }).toList();


    return SafeArea(
      child: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Search Bar
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
                contentPadding:
                    const EdgeInsets.symmetric(vertical: 15, horizontal: 10),
              ),
            ),
            const SizedBox(height: 24),

            // Quick Actions
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
                  icon: Icons.support_agent,
                  label: 'Pusat Bantuan',
                ),
              ],
            ),
            const SizedBox(height: 30),

            // Penitipan Terdekat
            HorizontalSection(title: 'Penitipan Terdekat', dataList: terdekat),
            const SizedBox(height: 20),

            // Rating Tertinggi
            HorizontalSection(title: 'Rating Tertinggi', dataList: rating),
            const SizedBox(height: 30),
          ],
        ),
      ),
    );
  }
}
