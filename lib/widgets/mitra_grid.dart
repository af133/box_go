import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';
import 'mitra_card.dart';

class MitraGrid extends StatelessWidget {
  final List<Map<String, dynamic>> filteredList;
  final List<Map<String, dynamic>> originalList;

  const MitraGrid({super.key, required this.filteredList, required this.originalList});

  @override
  Widget build(BuildContext context) {
    if (filteredList.isEmpty) {
      return Center(
        child: Padding(
          padding: const EdgeInsets.all(32.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(Icons.store_mall_directory, size: 80, color: darkGrey.withOpacity(0.4)),
              const SizedBox(height: 10),
              Text(
                originalList.isEmpty ? "Saat ini belum ada data mitra."
                    : "Tidak ada mitra yang cocok dengan pencarian atau filter Anda.",
                style: TextStyle(color: darkGrey, fontSize: 16),
                textAlign: TextAlign.center,
              ),
            ],
          ),
        ),
      );
    }

    return GridView.builder(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        childAspectRatio: 0.9,
        crossAxisSpacing: 16,
        mainAxisSpacing: 16,
      ),
      itemCount: filteredList.length,
      itemBuilder: (context, index) {
        final item = filteredList[index];
        return MitraCard(item: item);
      },
    );
  }
}
