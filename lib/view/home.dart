// lib/view/home_page.dart
// ignore_for_file: avoid_print

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
  Map<String, dynamic> lokasiData = {}; 

  @override
  void initState() {
    super.initState();
    loadUser();
    loadPenitipan();
  }

  Future<void> loadUser() async {
    final data = await _auth.getUser();
    setState(() => user = data);
  }

  Future<void> loadPenitipan() async {
    try {
      Position position = await Geolocator.getCurrentPosition(
          desiredAccuracy: LocationAccuracy.high);

      final data = await _lokasiMitra.getDashboardLokasi(
          latitude: position.latitude, longitude: position.longitude);
      setState(() {
        lokasiData = data;
      });
    } catch (e) {
      
      print("Gagal memuat data lokasi: $e");
    }
  }

  Widget changPage(int index) {
    switch (index) {
      case 0:
        return Bodyhome(
          penitipanTerdekat: lokasiData['penitipan_terdekat'] ?? [],
          ratingTertinggi: lokasiData['rating_tertinggi'] ?? [],
        );
      case 1:
        return ProfilePage();
      default:
        return SplashPage();
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
