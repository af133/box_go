import 'package:flutter/material.dart';
import 'package:box_go/view/home.dart';
import 'package:box_go/view/splash_page.dart';
import 'package:box_go/view/auth/login.dart';
import 'package:box_go/view/auth/signup.dart';

class AppRoutes {
  static const splash = '/';
  static const home = '/home';
  static const login = '/login';
  static const signup = '/signup';

  static Map<String, WidgetBuilder> routes = {
    splash: (_) => SplashPage(),
    home: (_) => HomePage(),
    login: (_) => LoginView(),
    signup: (_) => SignUpView(),
  };
}
