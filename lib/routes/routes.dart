import 'package:flutter/material.dart';
import 'package:box_go/view/home.dart';
import 'package:box_go/view/splash_page.dart';
import 'package:box_go/view/auth/login.dart';
import 'package:box_go/view/auth/signup.dart';
import 'package:box_go/view/profile/profile_page.dart';
import 'package:box_go/view/penitipan/index.dart';

class AppRoutes {
  static const splash = '/';
  static const home = '/home';
  static const login = '/login';
  static const signup = '/signup';
  static const profil = '/profile';
  static const allmitra = '/all_mitra';

  static Map<String, WidgetBuilder> routes = {
    splash: (_) => SplashPage(),
    home: (_) => HomePage(),
    login: (_) => LoginView(),
    signup: (_) => SignUpView(),
    profil: (_) => ProfilePage(),
    allmitra: (_) => AllMitraPage(),
  };
}
