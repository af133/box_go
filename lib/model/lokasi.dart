import 'mitra.dart';
import 'areagudang.dart';
class Lokasi {
  final int idLokasi;
  final String namaLokasi;
  final String deskripsi;
  final Mitra? mitra;
  final List<AreaGudang> areaGudang;

  Lokasi({
    required this.idLokasi,
    required this.namaLokasi,
    required this.deskripsi,
    this.mitra,
    required this.areaGudang,
  });

  factory Lokasi.fromJson(Map<String, dynamic> json) {
    return Lokasi(
      idLokasi: json['id_lokasi'],
      namaLokasi: json['nama_lokasi'] ?? "",
      deskripsi: json['deskripsi'] ?? "",
      mitra: json['mitra'] != null ? Mitra.fromJson(json['mitra']) : null,
      areaGudang: (json['area_gudang'] as List<dynamic>? ?? [])
          .map((e) => AreaGudang.fromJson(e))
          .toList(),
    );
  }
}
