import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class LokasiMitra {
  final String baseUrl = 'http://192.168.10.16:8000/api';

  /// Ambil dashboard lokasi dari backend
  Future<List<Map<String, dynamic>>> getDashboardLokasi({
    required double latitude,
    required double longitude,
  }) async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');

    if (token == null) {
      throw Exception("Token tidak ditemukan. Silakan login ulang.");
    }

    final response = await http.post(
      Uri.parse('$baseUrl/mitra/lokasi/dashboard'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
      body: {
        'latitude': latitude.toString(),
        'longitude': longitude.toString(),
      },
    );

    if (response.statusCode == 200) {
      final Map<String, dynamic> decoded = jsonDecode(response.body);

      // Ambil key 'mitra' langsung
      final List<dynamic> mitraRaw = decoded['mitra'] ?? [];

      // Ubah setiap item menjadi Map<String, dynamic>
      return mitraRaw.map<Map<String, dynamic>>((e) => Map<String, dynamic>.from(e)).toList();
    } else {
      throw Exception('Gagal memuat dashboard lokasi: ${response.statusCode}');
    }
  }
}
