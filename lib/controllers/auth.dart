import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:flutter/material.dart';
import 'dart:async';

class AuthController {
  static final AuthController _instance = AuthController._internal();
  factory AuthController() => _instance;
  AuthController._internal();

  final String baseUrl = 'http://backend_go_box.test/api';
  String? token;

  // 🔹 Register
  Future<String> signUp(
      String name, String email, String password, BuildContext context) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/register'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'nama': name,
          'email': email,
          'password': password,
          'role': 'pelanggan',
        }),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('user', jsonEncode(data['user']));
        await prefs.setString('token', data['token']);
        Navigator.pushReplacementNamed(context, '/home');
        return data['message'] ?? 'Registrasi berhasil';
      } else {
        final data = jsonDecode(response.body);
        return data['message'] ?? 'Terjadi kesalahan';
      }
    } catch (e) {
      return 'Error: $e';
    }
  }

  Future<String> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'email': email,
          'password': password,
          'role': 'pelanggan',
        }),
      );

      if (!response.headers['content-type']!.contains('application/json')) {
        return 'Server tidak mengembalikan JSON';
      }

      final data = jsonDecode(response.body);

      if (response.statusCode == 200) {
        final prefs = await SharedPreferences.getInstance();
        await prefs.setString('token', data['token']);
        return 'berhasil';
      } else {
        return data['message'] ?? 'Email atau password salah!';
      }
    } catch (e) {
      return 'Error: $e';
    }
  }

}
