import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class FilterChips extends StatelessWidget {
  final String selected;
  final ValueChanged<String> onSelected;

  const FilterChips({super.key, required this.selected, required this.onSelected});

  @override
  Widget build(BuildContext context) {
    List<String> filters = ["Semua", "Terdekat", "Rating"];
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: SizedBox(
        height: 38,
        child: ListView(
          scrollDirection: Axis.horizontal,
          padding: const EdgeInsets.symmetric(horizontal: 16),
          children: filters.map((f) {
            final isSelected = selected == f;
            return Padding(
              padding: const EdgeInsets.only(right: 8),
              child: ChoiceChip(
                label: Text(
                  f,
                  style: TextStyle(
                    color: isSelected ? Colors.white : darkGrey,
                    fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
                  ),
                ),
                selected: isSelected,
                selectedColor: goBox,
                backgroundColor: Colors.white,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(20),
                  side: BorderSide(
                      color: isSelected ? goBox : darkGrey.withOpacity(0.5),
                      width: 1),
                ),
                onSelected: (_) => onSelected(f),
              ),
            );
          }).toList(),
        ),
      ),
    );
  }
}
