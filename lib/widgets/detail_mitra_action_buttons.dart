import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';
import 'package:box_go/widgets/map_launcher_service.dart';
import 'package:box_go/widgets/detail_mitra_review_dialog.dart';

class DetailMitraActionButtons extends StatelessWidget {
  final Map<String, dynamic> mitraData;
  final double latitude;
  final double longitude;
  final String title;
  final VoidCallback onSewaPressed;

  const DetailMitraActionButtons({
    super.key,
    required this.mitraData,
    required this.latitude,
    required this.longitude,
    required this.title,
    required this.onSewaPressed,
  });

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Expanded(
          child: ElevatedButton.icon(
            onPressed: onSewaPressed,
            icon: const Icon(Icons.shopping_bag, color: Colors.white),
            label: const Text(
              "Sewa Tempat",
              style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
            ),
            style: ElevatedButton.styleFrom(
              backgroundColor: goBox,
              padding: const EdgeInsets.symmetric(vertical: 12),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
            ),
          ),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: OutlinedButton.icon(
            onPressed: () => MapLauncherService.launchMaps(
              context,
              latitude,
              longitude,
              title,
            ),
            icon: const Icon(Icons.route, color: goBox),
            label: const Text(
              "Rute",
              style: TextStyle(color: goBox, fontWeight: FontWeight.bold),
            ),
            style: OutlinedButton.styleFrom(
              padding: const EdgeInsets.symmetric(vertical: 12),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
              side: const BorderSide(color: goBox, width: 2),
            ),
          ),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: OutlinedButton.icon(
            onPressed: () => DetailMitraReviewDialog.show(context, mitraData),
            icon: const Icon(Icons.rate_review, color: goBox),
            label: const Text(
              "Review",
              style: TextStyle(color: goBox, fontWeight: FontWeight.bold),
            ),
            style: OutlinedButton.styleFrom(
              padding: const EdgeInsets.symmetric(vertical: 12),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
              side: const BorderSide(color: goBox, width: 2),
            ),
          ),
        ),
      ],
    );
  }
}