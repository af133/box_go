class PolygonModel {
  final int idPolygon;
  final String koordinat;

  PolygonModel({
    required this.idPolygon,
    required this.koordinat,
  });

  factory PolygonModel.fromJson(Map<String, dynamic> json) {
    return PolygonModel(
      idPolygon: json['id_polygon'],
      koordinat: json['koordinat'] ?? "",
    );
  }
}
