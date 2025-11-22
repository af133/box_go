import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class DetailMitraImageHeader extends StatelessWidget {
  final String imageUrl;

  const DetailMitraImageHeader({
    super.key,
    required this.imageUrl,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 200,
      width: double.infinity,
      color: Colors.grey.shade300,
      child: Image.network(
        imageUrl,
        fit: BoxFit.cover,
        errorBuilder: (context, error, stackTrace) => Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(Icons.image_not_supported, color: darkGrey, size: 50),
              const SizedBox(height: 8),
              const Text("Gambar Tidak Tersedia"),
            ],
          ),
        ),
      ),
    );
  }
}