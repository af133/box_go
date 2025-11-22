import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class MitraCard extends StatelessWidget {
  final Map<String, dynamic> item;
  const MitraCard({super.key, required this.item});

  @override
  Widget build(BuildContext context) {
    final String title = item['title'] ?? 'Nama Mitra Tidak Diketahui';
    final String imageUrl = item['path_area'] ?? 'https://placehold.co/600x400/9E9E9E/FFFFFF?text=No+Image';
    final double rating = (item['rating'] as num? ?? 0.0).toDouble();
    final double distance = (item['distance'] as num? ?? 0.0).toDouble();

    return InkWell(
      onTap: () => Navigator.pushNamed(context, '/detail_mitra', arguments: item),
      child: Card(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
        elevation: 4,
        shadowColor: goBox.withOpacity(0.2),
        clipBehavior: Clip.antiAlias,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            ClipRRect(
              borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
              child: Image.network(
                imageUrl,
                height: 100,
                width: double.infinity,
                fit: BoxFit.cover,
                errorBuilder: (_, __, ___) =>
                    Container(
                      height: 90,
                      color: lightGrey,
                      child: const Center(child: Icon(Icons.broken_image, color: darkGrey)),
                    ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(8),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(title,
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                      style: const TextStyle(
                          fontWeight: FontWeight.w700,
                          fontSize: 13,
                          color: darkGrey)),
                  const SizedBox(height: 6),
                  Row(
                    children: [
                      const Icon(Icons.star, color: Colors.amber, size: 16),
                      const SizedBox(width: 4),
                      Text(
                        rating > 0 ? rating.toStringAsFixed(1) : "Belum ada rating",
                        style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold),
                      ),
                      const Spacer(),
                      const Icon(Icons.location_on, color: goBox, size: 14),
                      const SizedBox(width: 2),
                      Text(
                        distance > 0 ? "${distance.toStringAsFixed(1)} km" : "Jarak tidak tersedia",
                        style: TextStyle(fontSize: 12, color: darkGrey.withOpacity(0.8)),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
