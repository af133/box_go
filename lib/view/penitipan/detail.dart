import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';
import 'package:box_go/widgets/map_preview.dart';
import 'package:box_go/widgets/detail_mitra_app_bar.dart';
import 'package:box_go/widgets/detail_mitra_image_header.dart';
import 'package:box_go/widgets/detail_mitra_info_section.dart';
import 'package:box_go/widgets/detail_mitra_action_buttons.dart';
import 'package:box_go/widgets/detail_mitra_review_section.dart';
import 'package:box_go/widgets/map_launcher_service.dart';

class DetailMitraPage extends StatefulWidget {
  const DetailMitraPage({super.key});

  @override
  State<DetailMitraPage> createState() => _DetailMitraPageState();
}

class _DetailMitraPageState extends State<DetailMitraPage> {
  Map<String, dynamic> mitraData = {};

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    final args = ModalRoute.of(context)?.settings.arguments;
    if (args != null && args is Map) {
      mitraData = Map<String, dynamic>.from(args);
    }
  }

  // Fungsi helper untuk parsing double dengan aman
  double _parseDouble(dynamic value, double defaultValue) {
    if (value == null) return defaultValue;
    if (value is num) return value.toDouble();
    if (value is String) return double.tryParse(value) ?? defaultValue;
    return defaultValue;
  }

  @override
  Widget build(BuildContext context) {
    // Parsing data dinamis dengan penanganan null/tipe
    final String title =
        mitraData['title'] ?? mitraData['nama_lokasi'] ?? 'Nama Penitipan';
    final String imageUrl = mitraData['path_area'] ??
        'https://placehold.co/600x400/9E9E9E/FFFFFF?text=No+Image';

    // Menggunakan fungsi _parseDouble untuk parsing yang aman
    final double rating = _parseDouble(
        mitraData['rating'] ?? mitraData['rating_mitra_avg_rating'], 0.0);
    final double distance = _parseDouble(mitraData['distance'], 0.0);
    final String description =
        mitraData['deskripsi'] ?? 'Deskripsi mitra ini belum tersedia.';

    // Ekstraksi koordinat
    final double latitude =
        _parseDouble(mitraData['latitude'] ?? mitraData['lat'], -6.2088);
    final double longitude =
        _parseDouble(mitraData['longitude'] ?? mitraData['lon'], 106.8456);

    return Scaffold(
      backgroundColor: lightGrey,
      appBar: DetailMitraAppBar(
        onBack: () => Navigator.of(context).pop(),
      ),
      body: SingleChildScrollView(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // 1. GAMBAR MITRA
            DetailMitraImageHeader(imageUrl: imageUrl),

            Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // 2. INFO SECTION (Nama, Rating, Jarak)
                  DetailMitraInfoSection(
                    title: title,
                    distance: distance,
                    rating: rating,
                  ),
                  const SizedBox(height: 16),

                  // 3. ACTION BUTTONS
                  DetailMitraActionButtons(
                    mitraData: mitraData,
                    latitude: latitude,
                    longitude: longitude,
                    title: title,
                    onSewaPressed: () {
                      Navigator.pushNamed(context, '/order_form', arguments: mitraData);
                    },
                  ),
                  const Divider(height: 32, thickness: 1),

                  // 4. DESKRIPSI
                  _buildDescriptionSection(description),
                  const Divider(height: 32, thickness: 1),

                  // 5. MAP PREVIEW
                  _buildLocationSection(latitude, longitude, title),
                  const SizedBox(height: 32),

                  // 6. REVIEW SECTION
                  DetailMitraReviewSection(mitraData: mitraData),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildDescriptionSection(String description) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildSectionTitle('Deskripsi Mitra'),
        Text(
          description,
          style: TextStyle(
            fontSize: 14,
            color: darkGrey.withOpacity(0.8),
          ),
        ),
      ],
    );
  }

  Widget _buildLocationSection(double latitude, double longitude, String title) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildSectionTitle('Lokasi'),
        MapPreview(
          latitude: latitude,
          longitude: longitude,
          onTap: () => MapLauncherService.launchMaps(
            context,
            latitude,
            longitude,
            title,
          ),
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