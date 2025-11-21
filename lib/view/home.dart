// lib/view/home_page.dart
// ignore_for_file: avoid_print

import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
// ignore: unused_import
import 'package:geocoding/geocoding.dart';
// Asumsi import ini valid di proyek Anda
import 'package:box_go/controllers/auth.dart'; 
import 'package:box_go/controllers/lokasimitra.dart'; 
import 'package:box_go/model/user.dart';
import 'package:box_go/widgets/appbar_home.dart';
import 'package:box_go/widgets/bnavabar.dart';
import 'package:box_go/view/profile/profile_page.dart';
import 'package:box_go/view/splash_page.dart';
import 'package:box_go/widgets/bodyhome.dart'; // Import Bodyhome yang terpisah

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
  Map<String, dynamic> lokasiData = {}; 
  String _locationStatus = "Memuat data..."; // Status UI untuk loading/error

  @override
  void initState() {
    super.initState();
    loadUser();
    loadPenitipan();
  }

  Future<void> loadUser() async {
    final data = await _auth.getUser();
    if (mounted) {
      setState(() => user = data);
    }
  }

  // Fungsi untuk memeriksa izin dan ketersediaan layanan lokasi
  Future<Position?> _determinePosition() async {
    bool serviceEnabled;
    LocationPermission permission;

    serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      throw Exception('Layanan Lokasi dinonaktifkan. Mohon aktifkan GPS Anda.');
    }

    permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) {
        throw Exception('Izin lokasi ditolak oleh pengguna.');
      }
    }
    
    if (permission == LocationPermission.deniedForever) {
      throw Exception('Izin lokasi ditolak secara permanen. Mohon ubah pengaturan aplikasi Anda.');
    }

    return await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high);
  }

  // loadPenitipan: Logika utama yang lebih tangguh
  Future<void> loadPenitipan() async {
    if (mounted) {
      setState(() {
        _locationStatus = "Memuat lokasi...";
        lokasiData = {};
      });
    }

    try {
      // Dapatkan posisi
      Position? position = await _determinePosition();
      if (!mounted) return;
      if (position == null) {
         throw Exception("Gagal mendapatkan koordinat (position is null).");
      }

      // Ambil data mitra
      final data = await _lokasiMitra.getDashboardLokasi(
          latitude: position.latitude, longitude: position.longitude);

      if (mounted) {
        setState(() {
          lokasiData = data;
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

  // changPage: Menampilkan Loading/Error state
  Widget changPage(int index) {
    if (currentIndex == 0) {
      // Tampilkan Loading/Error jika data lokasi belum dimuat
      if (lokasiData.isEmpty && _locationStatus != "Lokasi berhasil dimuat.") {
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
              if (_locationStatus.contains("Gagal") || _locationStatus.contains("dinonaktifkan") || _locationStatus.contains("ditolak"))
                ElevatedButton.icon(
                  onPressed: loadPenitipan,
                  icon: const Icon(Icons.refresh),
                  label: const Text("Coba Lagi"),
                ),
            ],
          ),
        );
      }
      
      // Jika data sudah ada, tampilkan Bodyhome
      return Bodyhome(
        // Catatan: Data mentah dari API langsung diteruskan ke Bodyhome
        penitipanTerdekat: lokasiData['penitipan_terdekat'] ?? [],
        ratingTertinggi: lokasiData['rating_tertinggi'] ?? [],
        // Meneruskan fungsi reload ke LocationHeader melalui Bodyhome
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