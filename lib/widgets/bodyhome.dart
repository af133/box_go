// lib/widgets/bodyhome.dart
// ignore_for_file: invalid_use_of_protected_member

import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:geolocator/geolocator.dart';
import 'package:geocoding/geocoding.dart';

// Asumsi import ini valid di proyek Anda
import 'package:box_go/shared/constants.dart';
import 'package:box_go/widgets/horizontal_section.dart'; // Import widget yang dipisah

// ===========================================
// WIDGETS PENDUKUNG (QuickFeatureButton dan LocationHeader)
// ===========================================

class QuickFeatureButton extends StatelessWidget {
  final IconData icon;
  final String label;
  final VoidCallback? onTap;

  const QuickFeatureButton({super.key, required this.icon, required this.label, this.onTap});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(8),
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 4.0),
        child: Column(
          children: [
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.withOpacity(0.1),
                      spreadRadius: 1,
                      blurRadius: 3,
                      offset: const Offset(0, 2),
                    ),
                  ],
                  border: Border.all(color: lightGrey)),
              child: Icon(icon, color: goBox, size: 28),
            ),
            const SizedBox(height: 6),
            Text(
              label,
              style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w500),
              textAlign: TextAlign.center,
            )
          ],
        ),
      ),
    );
  }
}

class LocationHeader extends StatefulWidget {
  // onLocationChanged sekarang memicu load data di HomePage
  final VoidCallback? onLocationReload;

  const LocationHeader({super.key, this.onLocationReload});

  @override
  State<LocationHeader> createState() => _LocationHeaderState();
}

class _LocationHeaderState extends State<LocationHeader> {
  String _location = "Setel Lokasi Anda";
  bool _loading = false;

  Future<void> _setLocation() async {
    if (!mounted) return;
    try {
      setState(() => _loading = true);

      // Ambil posisi
      Position pos = await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
      List<Placemark> places = await placemarkFromCoordinates(pos.latitude, pos.longitude);

      String city = places.first.subAdministrativeArea ?? "Lokasi";

      if (mounted) {
        setState(() => _location = city);
        // Memanggil fungsi reload data dari HomePage
        widget.onLocationReload?.call(); 
      }
    } catch (e) {
      if (mounted) {
        setState(() => _location = "Lokasi Tidak Aktif");
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text("Gagal Mengambil Lokasi")),
        );
      }
    } finally {
      if (mounted) {
        setState(() => _loading = false);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      color: goBox,
      padding: const EdgeInsets.fromLTRB(16, 12, 16, 16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          InkWell(
            onTap: _loading ? null : _setLocation,
            child: Row(
              children: [
                const Icon(Icons.location_on, color: Colors.white, size: 16),
                const SizedBox(width: 6),
                Expanded(
                  child: Text(
                    _location,
                    style: const TextStyle(color: Colors.white, fontSize: 14),
                    overflow: TextOverflow.ellipsis,
                  ),
                ),
                if (_loading)
                  const SizedBox(
                      width: 14,
                      height: 14,
                      child: CircularProgressIndicator(
                        strokeWidth: 2,
                        color: Colors.white,
                      ))
              ],
            ),
          ),
          const SizedBox(height: 12),
          TextField(
            decoration: InputDecoration(
              hintText: 'Cari lokasi penitipan...',
              prefixIcon: Icon(Icons.search, color: darkGrey),
              filled: true,
              fillColor: Colors.white,
              border: OutlineInputBorder(borderRadius: BorderRadius.circular(10), borderSide: BorderSide.none),
            ),
          )
        ],
      ),
    );
  }
}


// ===========================================
// BODY HOME PAGE UTAMA
// ===========================================

class Bodyhome extends StatelessWidget {
  final List<dynamic> penitipanTerdekat;
  final List<dynamic> ratingTertinggi;
  final VoidCallback? onLocationReload; // Tambahkan callback untuk reload data

  const Bodyhome({
    super.key, 
    required this.penitipanTerdekat, 
    required this.ratingTertinggi,
    this.onLocationReload,
  });

  double parseDouble(dynamic value) {
    if (value == null) return 0.0;
    if (value is double) return value;
    if (value is int) return value.toDouble();
    return double.tryParse(value.toString()) ?? 0.0;
  }

  // Fungsi untuk menormalisasi data dan menyertakan semua kunci yang diperlukan
  List<Map<String, dynamic>> normalizeMitraData(List<dynamic> rawList, {required bool isClosest}) {
    return rawList.map((e) {
      // 1. Ambil Title dan Path Area
      final title = e['nama_lokasi'] ?? 'Mitra Tanpa Nama';
      final pathArea = e['path_area'];

      // 2. Dapatkan Nilai Distance (penting untuk sorting di AllMitraPage)
      final rawDistance = isClosest 
          ? parseDouble(e['distance']) 
          : (e['distance'] != null ? parseDouble(e['distance']) : 9999.0); 

      // 3. Dapatkan Nilai Rating (penting untuk sorting di AllMitraPage)
      final rawRating = parseDouble(e['rating_mitra_avg_rating'] ?? e['rating'] ?? 0.0);

      // 4. String Durasi/Informasi yang Diformat (untuk BoardingCard di Home Page)
      String durationString;
      if (isClosest) {
        durationString = rawDistance < 9999.0 ? "Jarak: ${rawDistance.toStringAsFixed(1)} km" : "Jarak tidak tersedia";
      } else {
        durationString = rawRating > 0.0 ? "Rating: ${rawRating.toStringAsFixed(1)} ⭐" : "Belum ada rating";
      }

      // 5. Kembalikan map lengkap
      return {
        // Data dasar untuk tampilan Home/All
        'title': title,
        'path_area': pathArea,
        'duration': durationString, 
        
        // Data MENTAH/RAW untuk SORTING/FILTERING di AllMitraPage
        'distance': rawDistance, 
        'rating': rawRating,     
        
        // Tambahkan semua data mentah dari API untuk Detail Page
        ...Map<String, dynamic>.from(e),
      };
    }).toList();
  }

  @override
  Widget build(BuildContext context) {
    // Normalisasi data untuk memastikan semua kunci (distance, rating mentah) ada
    final terdekatNormalized = normalizeMitraData(penitipanTerdekat, isClosest: true);
    final ratingNormalized = normalizeMitraData(ratingTertinggi, isClosest: false);

    return SingleChildScrollView(
      child: Column(
        children: [
          // Meneruskan fungsi reload ke LocationHeader
          LocationHeader(onLocationReload: onLocationReload),

          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    const QuickFeatureButton(icon: Icons.receipt_long, label: 'Riwayat'),
                    const QuickFeatureButton(icon: Icons.luggage, label: 'Titip Barang'),
                    QuickFeatureButton(
                      icon: Icons.support_agent,
                      label: 'Bantuan',
                      onTap: () async {
                        final url = Uri.parse("https://wa.me/6285806138261?text=Halo%20Admin,%20saya%20butuh%20bantuan!");
                        if (await canLaunchUrl(url)) {
                          await launchUrl(url, mode: LaunchMode.externalApplication);
                        }
                      },
                    )
                  ],
                ),

                const SizedBox(height: 28),

                // Menggunakan data yang sudah dinormalisasi
                HorizontalSection(title: "Titipan Terdekat 📍", dataList: terdekatNormalized),
                HorizontalSection(title: "Rating Tertinggi ⭐", dataList: ratingNormalized),
              ],
            ),
          ),
        ],
      ),
    );
  }
}