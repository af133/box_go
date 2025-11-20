import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:box_go/model/lokasi.dart';
class LokasiMitra {
  final String baseUrl = 'http://backend_go_box.test/api';

  Future<List<Lokasi>> getBarang() async {
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
    final data = jsonDecode(response.body);

    List<dynamic> lokasiList = data['lokasi'] ?? [];

    return lokasiList.map((e) => Lokasi.fromJson(e)).toList();
  } 
  else {
      throw Exception('Gagal memuat data lokasi');
    }
  }

}
