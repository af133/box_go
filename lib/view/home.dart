// lib/view/home_page.dart
// ignore_for_file: avoid_print, deprecated_member_use

import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'package:box_go/controllers/auth.dart'; 
import 'package:box_go/controllers/lokasimitra.dart'; 
import 'package:box_go/model/user.dart';
import 'package:box_go/widgets/appbar_home.dart';
import 'package:box_go/widgets/bnavabar.dart';
import 'package:box_go/view/profile/profile_page.dart';
import 'package:box_go/view/splash_page.dart';
import 'package:box_go/widgets/bodyhome.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _StateHomePage();
}

class _StateHomePage extends State<HomePage> {
  final AuthController _auth = AuthController();
  final LokasiMitra _lokasiMitra = LokasiMitra();

  int currentIndex = 0;
  User? user;
  List<Map<String, dynamic>> mitraData = []; // sekarang list saja
  String _locationStatus = "Memuat data...";

  @override
  void initState() {
    super.initState();
    loadUser();
    loadPenitipan();
  }

  Future<void> loadUser() async {
    final data = await _auth.getUser();
    if (mounted) setState(() => user = data);
  }
  Future<Position?> _determinePosition() async {
    bool serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) throw Exception('Layanan Lokasi dinonaktifkan. Mohon aktifkan GPS Anda.');

    LocationPermission permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) {
        throw Exception('Izin lokasi ditolak oleh pengguna.');
      }
    }
    if (permission == LocationPermission.deniedForever) {
      throw Exception('Izin lokasi ditolak secara permanen. Mohon ubah pengaturan aplikasi Anda.');
    }

    return await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
  }

  Future<void> loadPenitipan() async {
    if (mounted) {
      setState(() {
        _locationStatus = "Memuat lokasi...";
        mitraData = [];
      });
    }

    try {
      final position = await _determinePosition();
      if (!mounted || position == null) return;

      final data = await _lokasiMitra.getDashboardLokasi(
          latitude: position.latitude, longitude: position.longitude);

      if (mounted) {
        setState(() {
          mitraData = data;
          _locationStatus = "Lokasi berhasil dimuat.";
        });
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          _locationStatus = e.toString().contains("Exception") 
              ? e.toString().split(":").last.trim() 
              : "Gagal memuat data lokasi.";
        });
        print("Gagal memuat data lokasi: $e");
      }
    }
  }

  Widget changPage(int index) {
    if (currentIndex == 0) {
      if (mitraData.isEmpty && _locationStatus != "Lokasi berhasil dimuat.") {
        return Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              if (_locationStatus == "Memuat lokasi...")
                const CircularProgressIndicator(),
              const SizedBox(height: 16),
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 24.0),
                child: Text(
                  _locationStatus,
                  textAlign: TextAlign.center,
                  style: const TextStyle(color: Colors.grey),
                ),
              ),
              const SizedBox(height: 16),
              if (_locationStatus.contains("Gagal") ||
                  _locationStatus.contains("dinonaktifkan") ||
                  _locationStatus.contains("ditolak"))
                ElevatedButton.icon(
                  onPressed: loadPenitipan,
                  icon: const Icon(Icons.refresh),
                  label: const Text("Coba Lagi"),
                ),
            ],
          ),
        );
      }

      return Bodyhome(
        mitraList: mitraData,
        onLocationReload: loadPenitipan,
      );
    }

    switch (index) {
      case 1:
        return const ProfilePage(); 
      default:
        return const SplashPage();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: currentIndex == 0
          ? AppbarHome(
              name: user?.nama ?? "...",
              pathProfil: user?.pathProfil ?? "...",
            )
          : null,
      body: changPage(currentIndex),
      bottomNavigationBar: Bnavbar(
        currentIndex: currentIndex,
        onTap: (index) => setState(() => currentIndex = index),
      ),
    );
  }
}
