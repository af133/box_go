import 'package:box_go/model/user.dart';
import 'package:box_go/widgets/appbar_home.dart';
import 'package:flutter/material.dart';
import 'package:box_go/controllers/auth.dart';
import 'package:box_go/controllers/lokasimitra.dart';
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
  final _auth = AuthController();
  final _penitipan = LokasiMitra();
  int currentIndex = 0;
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
    // ignore: unused_local_variable
    final penitipan = await _penitipan.getBarang();
  }
   Widget changPage(currentIndex) {
    switch (currentIndex) {
      case 0:
        return Bodyhome();
      case 1:
        return ProfilePage();
      // ...
      default:
        return SplashPage();
    }
  }

  @override
  Widget build(BuildContext context) {

    return Scaffold(
      backgroundColor: const Color.fromARGB(255, 255, 255, 255),
      appBar: currentIndex == 0 ? AppbarHome(
        name: user?.nama ?? "...",
        pathProfil: user?.pathProfil ?? '...',
      ): null,
      body: changPage(
         currentIndex,),
      bottomNavigationBar: Bnavbar(
         currentIndex: currentIndex,
        onTap: (index) {
          setState(() {
            currentIndex = index;
          });
        },
      ),
    );
  }
}
