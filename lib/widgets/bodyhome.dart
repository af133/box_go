// ignore_for_file: invalid_use_of_protected_member

import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:geolocator/geolocator.dart';
import 'package:geocoding/geocoding.dart';

import 'package:box_go/shared/constants.dart';

class BoardingCard extends StatelessWidget {
  final Map<String, dynamic> data;
  final VoidCallback? onTap;

  const BoardingCard({super.key, required this.data, this.onTap});

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      child: SizedBox(
        width: 160,
        child: Card(
          elevation: 4,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              ClipRRect(
                borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
                child: Image.network(
                  data['path_area'] ?? 'https://via.placeholder.com/160x80?text=No+Image',
                  height: 80,
                  width: 160,
                  fit: BoxFit.cover,
                  errorBuilder: (context, error, stackTrace) => Container(
                    height: 80,
                    width: 160,
                    color: Colors.grey.shade200,
                    child: const Center(child: Icon(Icons.image_not_supported, color: darkGrey)),
                  ),
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(data['title'] ?? 'Mitra',
                        style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13),
                        overflow: TextOverflow.ellipsis,
                        maxLines: 1),
                    const SizedBox(height: 4),
                    Text(data['duration'] ?? '',
                        style: const TextStyle(fontSize: 11, color: darkGrey),
                        overflow: TextOverflow.ellipsis),
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

  const HorizontalSection({super.key, required this.title, required this.dataList});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.only(bottom: 20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: <Widget>[
              Text(title, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
              TextButton(
                child: const Text("Lihat Semua >", style: TextStyle(color: goBox, fontWeight: FontWeight.bold)),
                onPressed: () {
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
          SizedBox(
            height: 160,
            child: ListView.builder(
              scrollDirection: Axis.horizontal,
              itemCount: dataList.length,
              itemBuilder: (context, index) => Padding(
                padding: const EdgeInsets.only(right: 10),
                child: BoardingCard(data: dataList[index]),
              ),
            ),
          )
        ],
      ),
    );
  }
}

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
  final Function(double lat, double lng)? onLocationChanged;

  const LocationHeader({super.key, this.onLocationChanged});

  @override
  State<LocationHeader> createState() => _LocationHeaderState();
}

class _LocationHeaderState extends State<LocationHeader> {
  String _location = "Setel Lokasi Anda";
  bool _loading = false;

  Future<void> _setLocation() async {
    try {
      setState(() => _loading = true);

      Position pos = await Geolocator.getCurrentPosition();
      List<Placemark> places = await placemarkFromCoordinates(pos.latitude, pos.longitude);

      String city = places.first.subAdministrativeArea ?? "Lokasi";

      setState(() => _location = city);

      widget.onLocationChanged?.call(pos.latitude, pos.longitude);

    } catch (e) {
      setState(() => _location = "Lokasi Tidak Aktif");
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Gagal Mengambil Lokasi")),
      );
    } finally {
      setState(() => _loading = false);
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
// BODY HOME PAGE
// ===========================================

class Bodyhome extends StatelessWidget {
  final List<dynamic> penitipanTerdekat;
  final List<dynamic> ratingTertinggi;

  const Bodyhome({super.key, required this.penitipanTerdekat, required this.ratingTertinggi});

  double parseDouble(dynamic value) {
    if (value == null) return 0.0;
    if (value is double) return value;
    if (value is int) return value.toDouble();
    return double.tryParse(value.toString()) ?? 0.0;
  }

  @override
  Widget build(BuildContext context) {
    final terdekat = penitipanTerdekat.map((e) => {
          'title': e['nama_lokasi'],
          'duration':
              parseDouble(e['distance']) > 0 ? "Jarak: ${parseDouble(e['distance']).toStringAsFixed(1)} km" : "Jarak tidak tersedia",
          'path_area': e['path_area']
        }).toList();

    final rating = ratingTertinggi.map((e) => {
          'title': e['nama_lokasi'],
          'duration': "Rating: ${parseDouble(e['rating_mitra_avg_rating']).toStringAsFixed(1)} ⭐",
          'path_area': e['path_area']
        }).toList();

    return SingleChildScrollView(
      child: Column(
        children: [
          LocationHeader(
            onLocationChanged: (lat, lng) {
              final homeState = context.findAncestorStateOfType<State>();
              homeState?.setState(() {});
            },
          ),

          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    QuickFeatureButton(icon: Icons.receipt_long, label: 'Riwayat'),
                    QuickFeatureButton(icon: Icons.luggage, label: 'Titip Barang'),
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

                HorizontalSection(title: "Titipan Terdekat 📍", dataList: terdekat),
                HorizontalSection(title: "Rating Tertinggi ⭐", dataList: rating),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
