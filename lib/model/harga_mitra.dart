import 'jenis_barang.dart';

class Hargamitra {
  final int idHargaMitra;
  final int hargaSewa;
  final JenisBarang? jenisBarang;

  Hargamitra({
    required this.idHargaMitra,
    required this.hargaSewa,
    this.jenisBarang,
  });

  factory Hargamitra.fromJson(Map<String, dynamic> json) {
    return Hargamitra(
      idHargaMitra: json['harga_mitra'],
      hargaSewa: json['harga_sewa'],
      jenisBarang: json['jenis_barang'] != null 
          ? JenisBarang.fromJson(json['jenis_barang']) 
          : null,
    );
  }
}
