import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class DetailMitraInfoSection extends StatelessWidget {
  final String title;
  final double distance;
  final double rating;

  const DetailMitraInfoSection({
    super.key,
    required this.title,
    required this.distance,
    required this.rating,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        // NAMA PENITIPAN
        Text(
          title,
          style: const TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.w900,
            color: darkGrey,
          ),
        ),
        const SizedBox(height: 8),

        // JARAK | RATING
        _buildDistanceRating(),
      ],
    );
  }

  Widget _buildDistanceRating() {
    return Row(
      children: [
        const Icon(Icons.near_me, color: goBox, size: 18),
        const SizedBox(width: 4),
        Text(
          distance > 0 ? "${distance.toStringAsFixed(1)} km" : "Jarak tidak tersedia",
          style: TextStyle(fontSize: 14, color: darkGrey),
        ),
        const SizedBox(width: 15),
        const Text('|', style: TextStyle(color: Colors.grey)),
        const SizedBox(width: 15),
        const Icon(Icons.star, color: Colors.amber, size: 18),
        const SizedBox(width: 4),
        Text(
          rating > 0 ? rating.toStringAsFixed(1) : "Belum ada rating",
          style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
        ),
      ],
    );
  }
}