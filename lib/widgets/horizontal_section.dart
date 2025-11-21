// lib/widgets/horizontal_section.dart
import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart'; // Asumsi import ini valid

class BoardingCard extends StatelessWidget {
  final Map<String, dynamic> data;
  final VoidCallback? onTap;

  const BoardingCard({super.key, required this.data, this.onTap});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap ?? () {
        // Navigasi ke halaman detail saat kartu diklik
        Navigator.pushNamed(context, '/detail_mitra', arguments: data);
      },
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
                  data['path_area'] ?? 'https://via.placeholder.com/160x80?text=No+Image',
                  height: 80,
                  width: 160,
                  fit: BoxFit.cover,
                  errorBuilder: (context, error, stackTrace) => Container(
                    height: 80,
                    width: 160,
                    color: Colors.grey.shade200,
                    child: const Center(child: Icon(Icons.image_not_supported, color: darkGrey)),
                  ),
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(data['title'] ?? 'Mitra',
                        style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13),
                        overflow: TextOverflow.ellipsis,
                        maxLines: 1),
                    const SizedBox(height: 4),
                    // Menggunakan 'duration' yang sudah diformat untuk tampilan di Home Page
                    Text(data['duration'] ?? '',
                        style: const TextStyle(fontSize: 11, color: darkGrey),
                        overflow: TextOverflow.ellipsis),
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

class HorizontalSection extends StatelessWidget {
  final String title;
  // dataList memuat data lengkap (termasuk distance dan rating mentah)
  final List<Map<String, dynamic>> dataList;

  const HorizontalSection({super.key, required this.title, required this.dataList});

  @override
  Widget build(BuildContext context) {
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
                child: const Text("Lihat Semua >", style: TextStyle(color: goBox, fontWeight: FontWeight.bold)),
                onPressed: () {
                  // Meneruskan dataList yang sudah diperkaya ke AllMitraPage
                  Navigator.pushNamed(
                    context,
                    '/all_mitra',
                    arguments: {"title": title, "dataList": dataList},
                  );
                },
              )
            ],
          ),
          const SizedBox(height: 12),
          // Jika dataList kosong, tampilkan placeholder sederhana
          if (dataList.isEmpty)
             SizedBox(
              height: 160,
              child: Center(
                child: Text("Tidak ada data ${title.split(' ')[0]}", style: TextStyle(color: darkGrey.withOpacity(0.6))),
              ),
            )
          else
            SizedBox(
              height: 160,
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                itemCount: dataList.length,
                itemBuilder: (context, index) => Padding(
                  padding: const EdgeInsets.only(right: 10),
                  // BoardingCard menggunakan dataList yang sudah lengkap
                  child: BoardingCard(data: dataList[index]),
                ),
              ),
            )
        ],
      ),
    );
  }
}