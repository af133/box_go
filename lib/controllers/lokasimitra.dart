import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class LokasiMitra {
  final String baseUrl = 'http://backend_go_box.test/api';

  Future<List<dynamic>> getBarang() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');

    final response = await http.get(
      Uri.parse('$baseUrl/mitra/lokasi'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    if (response.statusCode == 200) {
      final body = jsonDecode(response.body);
      if (body.containsKey('lokasi')) {
        return body['lokasi'];
      } else {
        return []; 
      }
    } else {
      throw Exception('Gagal memuat barang: ${response.statusCode}');
    }
  }
}
