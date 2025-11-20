import 'jenisbarang.dart';
class HargaMitra {
  final int idHargaMitra;
  final int hargaSewa;
  final JenisBarang? jenisBarang;

  HargaMitra({
    required this.idHargaMitra,
    required this.hargaSewa,
    this.jenisBarang,
  });

  factory HargaMitra.fromJson(Map<String, dynamic> json) {
    return HargaMitra(
      idHargaMitra: json['harga_mitra'],
      hargaSewa: json['harga_sewa'],
      jenisBarang: json['jenis_barang'] != null 
          ? JenisBarang.fromJson(json['jenis_barang']) 
          : null,
    );
  }
}
