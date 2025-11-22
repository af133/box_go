// lib/widgets/horizontal_section.dart
import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class BoardingCard extends StatelessWidget {
  final Map<String, dynamic> data;
  final VoidCallback? onTap;

  const BoardingCard({super.key, required this.data, this.onTap});

  @override
  Widget build(BuildContext context) {
    final double rating = double.tryParse(
          (data['rating_mitra_avg_rating'] ?? data['rating'] ?? 0).toString(),
        ) ??
        0.0;

    final double distance =
        double.tryParse((data['distance'] ?? 0).toString()) ?? 0.0;

    return InkWell(
      onTap: onTap ??
          () {
            Navigator.pushNamed(context, '/detail_mitra', arguments: data);
          },
      child: SizedBox(
        width: 160,
        child: Card(
          elevation: 4,
          shape:
              RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              ClipRRect(
                borderRadius:
                    const BorderRadius.vertical(top: Radius.circular(12)),
                child: Image.network(
                  data['path_area'] ??
                      'https://via.placeholder.com/160x80?text=No+Image',
                  height: 80,
                  width: 160,
                  fit: BoxFit.cover,
                  errorBuilder: (context, error, stackTrace) => Container(
                    height: 80,
                    width: 160,
                    color: Colors.grey.shade200,
                    child: const Center(
                        child: Icon(Icons.image_not_supported,
                            color: Colors.grey)),
                  ),
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      data['title'] ?? 'Mitra',
                      style: const TextStyle(
                          fontWeight: FontWeight.bold, fontSize: 13),
                      overflow: TextOverflow.ellipsis,
                      maxLines: 1,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      distance > 0
                          ? rating > 0
                              ? "${distance.toStringAsFixed(1)} km | ⭐ ${rating.toStringAsFixed(1)}"
                              : "${distance.toStringAsFixed(1)} km | Belum ada rating"
                          : rating > 0
                              ? "Jarak tidak tersedia | ⭐ ${rating.toStringAsFixed(1)}"
                              : "Jarak tidak tersedia | Belum ada rating",
                      style: const TextStyle(fontSize: 12, color: Colors.grey),
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

class HorizontalSection extends StatelessWidget {
  final String title;
  final List<Map<String, dynamic>> dataList;
  final int horizontalLimit; // jumlah maksimal item di horizontal scroll

  const HorizontalSection({
    super.key,
    required this.title,
    required this.dataList,
    this.horizontalLimit = 5, // default 5 item
  });

  @override
  Widget build(BuildContext context) {
    // Ambil maksimal horizontalLimit item untuk tampilan horizontal
    final List<Map<String, dynamic>> limitedDataList =
        dataList.take(horizontalLimit).toList();

    return Container(
      padding: const EdgeInsets.only(bottom: 20),
      
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        
        children: [
          
          // Header: Judul + Lihat Semua
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded(
                child: Text(
                  title,
                  style: const TextStyle(
                      fontSize: 18, fontWeight: FontWeight.bold),
                  overflow: TextOverflow.ellipsis,
                ),
              ),
              TextButton(
                child: const Text(
                  "Lihat Semua >",
                  style: TextStyle(color: goBox, fontWeight: FontWeight.bold),
                ),
                onPressed: () {
                  // Kirim seluruh dataList ke AllMitraPage
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
          // Placeholder jika data kosong
          if (dataList.isEmpty)
            SizedBox(
              height: 160,
              child: Center(
                child: Text(
                  "Tidak ada data ${title.split(' ')[0]}",
                  style: TextStyle(color: darkGrey.withOpacity(0.6)),
                ),
              ),
            )
          else
            // ListView horizontal menampilkan maksimal horizontalLimit item
            SizedBox(
              height: 160,
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                itemCount: limitedDataList.length,
                itemBuilder: (context, index) =>
                    Padding(
                      padding: const EdgeInsets.only(right: 10),
                      child: BoardingCard(data: limitedDataList[index]),
                    ),
              ),
            ),
        ],
      ),
    );
  }
}
