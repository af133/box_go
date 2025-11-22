import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

class MapLauncherService {
  static Future<void> launchMaps(
    BuildContext context,
    double lat,
    double lon,
    String label,
  ) async {
    final urlString = 'http://maps.google.com/maps?q=$lat,$lon($label)';
    final url = Uri.parse(urlString);

    if (await canLaunchUrl(url)) {
      await launchUrl(url, mode: LaunchMode.externalApplication);
    } else {
      if (context.mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Tidak dapat membuka aplikasi peta.')),
        );
      }
    }
  }
}