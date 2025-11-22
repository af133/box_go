import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class DetailMitraReviewSection extends StatelessWidget {
  final Map<String, dynamic> mitraData;

  const DetailMitraReviewSection({
    super.key,
    required this.mitraData,
  });

  // Data dummy untuk Review
  final List<Map<String, dynamic>> dummyReviews = const [
    {
      'user': 'Rizky A.',
      'rating': 5.0,
      'date': '22/11/2025',
      'comment': 'Pelayanan sangat baik dan tempatnya bersih, penjaga ramah!',
    },
    {
      'user': 'Sinta B.',
      'rating': 4.5,
      'date': '19/11/2025',
      'comment': 'Agak jauh dari rumah, tapi barang aman. Saran: Tambah pilihan slot jam.',
    },
    {
      'user': 'Joko P.',
      'rating': 5.0,
      'date': '15/11/2025',
      'comment': 'Sangat memuaskan, proses cepat dan mudah. Rekomen banget!',
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildSectionTitle('Ulasan Pelanggan (${dummyReviews.length})'),
        if (dummyReviews.isEmpty)
          const Text("Belum ada ulasan untuk penitipan ini.")
        else
          ListView.builder(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            itemCount: dummyReviews.length,
            itemBuilder: (context, index) {
              final review = dummyReviews[index];
              return Padding(
                padding: const EdgeInsets.only(bottom: 12.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Row(
                          children: [
                            Icon(
                              Icons.person_pin,
                              color: darkGrey.withOpacity(0.8),
                              size: 20,
                            ),
                            const SizedBox(width: 6),
                            Text(
                              review['user']!,
                              style: const TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 14,
                              ),
                            ),
                          ],
                        ),
                        Text(
                          review['date']!,
                          style: TextStyle(
                            fontSize: 12,
                            color: Colors.grey.shade600,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 4),
                    Row(
                      children: [
                        const Icon(Icons.star, color: Colors.amber, size: 16),
                        Text(
                          " ${review['rating'].toString()}",
                          style: const TextStyle(
                            fontWeight: FontWeight.w600,
                            fontSize: 13,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 4),
                    Text(review['comment']!),
                    if (index < dummyReviews.length - 1)
                      const Divider(height: 18, thickness: 0.5),
                  ],
                ),
              );
            },
          ),
      ],
    );
  }

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8.0),
      child: Text(
        title,
        style: const TextStyle(
          fontSize: 18,
          fontWeight: FontWeight.w700,
          color: darkGrey,
        ),
      ),
    );
  }
}