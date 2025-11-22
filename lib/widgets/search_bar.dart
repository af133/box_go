import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class Searchbar extends StatelessWidget {
  final TextEditingController controller;
  final ValueChanged<String> onChanged;

  const Searchbar({super.key, required this.controller, required this.onChanged});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      color: goBox,
      child: TextField(
        controller: controller,
        decoration: InputDecoration(
          hintText: "Cari penitipan...",
          hintStyle: TextStyle(color: darkGrey.withOpacity(0.7)),
          prefixIcon: const Icon(Icons.search, color: darkGrey),
          filled: true,
          fillColor: Colors.white,
          contentPadding: const EdgeInsets.symmetric(vertical: 10, horizontal: 16),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide.none,
          ),
        ),
        onChanged: onChanged,
      ),
    );
  }
}
