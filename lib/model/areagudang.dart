import 'polygon.dart';
class AreaGudang {
  final int idArea;
  final PolygonModel? polygon;

  AreaGudang({
    required this.idArea,
    this.polygon,
  });

  factory AreaGudang.fromJson(Map<String, dynamic> json) {
    return AreaGudang(
      idArea: json['id_area'],
      polygon: json['polygon'] != null
          ? PolygonModel.fromJson(json['polygon'])
          : null,
    );
  }
}
