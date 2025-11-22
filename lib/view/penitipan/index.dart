import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';
import 'package:box_go/widgets/mitra_grid.dart';
import 'package:box_go/widgets/search_bar.dart';
import 'package:box_go/widgets/filter_chips.dart';

class AllMitraPage extends StatefulWidget {
  const AllMitraPage({super.key});

  @override
  State<AllMitraPage> createState() => _AllMitraPageState();
}

class _AllMitraPageState extends State<AllMitraPage> {
  List<Map<String, dynamic>> dataList = [];
  List<Map<String, dynamic>> filteredList = [];
  String filterSelected = "Semua";
  TextEditingController searchController = TextEditingController();

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    final args = ModalRoute.of(context)!.settings.arguments as Map?;
    dataList = (args != null && args['dataList'] is List)
        ? List<Map<String, dynamic>>.from(args['dataList'])
        : [];
    filteredList = List.from(dataList);
  }

  void filterData(String keyword) {
    final lowerKeyword = keyword.toLowerCase();
    final tempFiltered = dataList
        .where((item) =>
            item['title'].toString().toLowerCase().contains(lowerKeyword))
        .toList();
    _applySort(tempFiltered, filterSelected);
  }

  void _applySort(List<Map<String, dynamic>> list, String filter) {
    if (filter == "Terdekat") {
      list.sort((a, b) =>
          (a['distance'] as num? ?? double.infinity)
              .compareTo(b['distance'] as num? ?? double.infinity));
    } else if (filter == "Rating") {
      list.sort((a, b) =>
          (b['rating'] as num? ?? 0.0).compareTo(a['rating'] as num? ?? 0.0));
    }
    if (mounted) setState(() => filteredList = list);
  }

  void applyFilter(String filter) {
    final keyword = searchController.text.toLowerCase();
    final tempFiltered = dataList
        .where((item) =>
            item['title'].toString().toLowerCase().contains(keyword))
        .toList();

    setState(() {
      filterSelected = filter;
      if (filter == "Semua") {
        filteredList = tempFiltered;
      } else {
        _applySort(tempFiltered, filter);
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: lightGrey,
      appBar: AppBar(
        title: const Text(
          "Semua Penitipan",
          style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600),
        ),
        backgroundColor: goBox,
        iconTheme: const IconThemeData(color: Colors.white),
        elevation: 0,
      ),
      body: Column(
        children: [
          Searchbar(controller: searchController, onChanged: filterData),
          FilterChips(selected: filterSelected, onSelected: applyFilter),
          Expanded(
            child: MitraGrid(filteredList: filteredList, originalList: dataList),
          ),
        ],
      ),
    );
  }
}
