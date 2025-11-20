import 'package:box_go/model/user.dart';
import 'package:box_go/widgets/appbar_home.dart';
import 'package:box_go/widgets/bodyhome.dart';
import 'package:flutter/material.dart';
import 'package:box_go/controllers/auth.dart';
import 'package:box_go/controllers/lokasimitra.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _StateHomePage();
}

class _StateHomePage extends State<HomePage> {
  final _auth = AuthController();
  final _penitipan = LokasiMitra();
  User? user;
  @override
  void initState() {
    super.initState();
    loadUser();
    loadPenitipan();
  }

  Future<void> loadUser() async {
    final data = await _auth.getUser();
    setState(() {
      user = data;
    });
  }

  Future<void> loadPenitipan() async {
    final penitipan = await _penitipan.getBarang();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color.fromARGB(255, 255, 255, 255),
      appBar: AppbarHome(
        name: user?.nama ?? "...",
        pathProfil: user?.pathProfil ?? '...',
      ),
      body: Bodyhome(
        
      ),
    );
  }
}
