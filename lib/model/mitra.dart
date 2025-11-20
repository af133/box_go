import 'harga_mitra.dart';
class Mitra {
  final int idMitra;
  final String nama;
  final String alamat;
  final List<Hargamitra> hargaMitra;

  Mitra({
    required this.idMitra,
    required this.nama,
    required this.alamat,
    required this.hargaMitra,
  });

  factory Mitra.fromJson(Map<String, dynamic> json) {
    return Mitra(
      idMitra: json['id_mitra'],
      nama: json['nama'] ?? "",
      alamat: json['alamat'] ?? "",
      hargaMitra: (json['harga_mitra'] as List<dynamic>? ?? [])
          .map((e) => Hargamitra.fromJson(e))
          .toList(),
    );
  }
}
