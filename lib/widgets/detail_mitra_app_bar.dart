import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class DetailMitraAppBar extends StatelessWidget implements PreferredSizeWidget {
  final VoidCallback onBack;

  const DetailMitraAppBar({
    super.key,
    required this.onBack,
  });

  @override
  Size get preferredSize => const Size.fromHeight(kToolbarHeight);

  @override
  Widget build(BuildContext context) {
    return AppBar(
      title: const Text(
        "Detail Penitipan",
        style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600),
      ),
      backgroundColor: goBox,
      iconTheme: const IconThemeData(color: Colors.white),
      elevation: 0,
      leading: IconButton(
        icon: const Icon(Icons.arrow_back),
        onPressed: onBack,
      ),
    );
  }
}