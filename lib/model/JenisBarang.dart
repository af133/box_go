class JenisBarang {
  final int idJenisBarang;
  final String jenisBarang;

  JenisBarang({
    required this.idJenisBarang,
    required this.jenisBarang,
  });

  factory JenisBarang.fromJson(Map<String, dynamic> json) {
    return JenisBarang(
      idJenisBarang: json['id_jenis_barang'],
      jenisBarang: json['jenis_barang'] ?? "",
    );
  }
}
