// lib/widgets/bodyhome.dart
import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:geolocator/geolocator.dart';
import 'package:geocoding/geocoding.dart';
import 'package:box_go/shared/constants.dart';
import 'package:box_go/widgets/horizontal_section.dart';

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
                border: Border.all(color: lightGrey),
              ),
              child: Icon(icon, color: goBox, size: 28),
            ),
            const SizedBox(height: 6),
            Text(
              label,
              style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w500),
              textAlign: TextAlign.center,
            ),
          ],
        ),
      ),
    );
  }
}

// ===========================================
// LOCATION HEADER
// ===========================================
class LocationHeader extends StatefulWidget {
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

      Position pos = await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
      List<Placemark> places = await placemarkFromCoordinates(pos.latitude, pos.longitude);
      String city = places.first.subAdministrativeArea ?? "Lokasi";

      if (mounted) {
        setState(() => _location = city);
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
      if (mounted) setState(() => _loading = false);
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
                    ),
                  ),
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
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(10),
                borderSide: BorderSide.none,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

// ===========================================
// BODYHOME
// ===========================================
class Bodyhome extends StatelessWidget {
  final List<Map<String, dynamic>> mitraList;
  final VoidCallback? onLocationReload;

  const Bodyhome({super.key, required this.mitraList, this.onLocationReload});

  double parseDouble(dynamic value) {
    if (value == null) return 0.0;
    if (value is double) return value;
    if (value is int) return value.toDouble();
    return double.tryParse(value.toString()) ?? 0.0;
  }

  List<Map<String, dynamic>> normalizeMitraData(List<Map<String, dynamic>> rawList, {required bool showDistance}) {
    return rawList.map((e) {
      final title = e['nama_lokasi'] ?? 'Mitra Tanpa Nama';
      final pathArea = e['path_area'];
      final latitude= e['path_area'];
      final longitude= e['longitude'];
      final idLokasi = e['id_lokasi'];
      final distance = showDistance ? parseDouble(e['distance']) : null;
      final rating = parseDouble(e['rating_mitra_avg_rating'] ?? e['rating'] ?? 0.0);

      return {
        'title': title,
        'path_area': pathArea,
        'distance': distance,
        'rating': rating,
        'longitude':longitude,
        'latitude':latitude,
        'idLokasi': idLokasi,
        'duration': showDistance
            ? (distance != null ? "Jarak: ${distance.toStringAsFixed(1)} km" : "Jarak tidak tersedia")
            : (rating > 0 ? "Rating: ${rating.toStringAsFixed(1)} ⭐" : "Belum ada rating"),
        ...e,
      };
    }).toList();
  }

  @override
  Widget build(BuildContext context) {
    // Sorting untuk section
    final terdekatList = normalizeMitraData(
        List<Map<String, dynamic>>.from(mitraList)..sort((a, b) => (parseDouble(a['distance'])).compareTo(parseDouble(b['distance']))),
        showDistance: true);
    return SingleChildScrollView(
      child: Column(
        children: [
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
                        final url = Uri.parse(
                            "https://wa.me/6285806138261?text=Halo%20Admin,%20saya%20butuh%20bantuan!");
                        if (await canLaunchUrl(url)) {
                          await launchUrl(url, mode: LaunchMode.externalApplication);
                        }
                      },
                    ),
                  ],
                ),

                const SizedBox(height: 28),

                HorizontalSection(title: "Titipan Terdekat 📍", dataList: terdekatList),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
