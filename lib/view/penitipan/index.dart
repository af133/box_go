import 'package:flutter/material.dart';

class AllMitraPage extends StatefulWidget {
  const AllMitraPage({super.key});

  @override
  State<AllMitraPage> createState() => _AllMitraPageState();
}

class _AllMitraPageState extends State<AllMitraPage> {
  List<Map<String, dynamic>> dataList = [];
  List<Map<String, dynamic>> filteredList = [];

  String filterSelected = "Semua";

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();

    final args = ModalRoute.of(context)!.settings.arguments as Map?;
    dataList = List<Map<String, dynamic>>.from(args?['dataList'] ?? []);
    filteredList = List.from(dataList);
  }

  void filterData(String keyword) {
    setState(() {
      filteredList = dataList
          .where((item) =>
              item['title'].toString().toLowerCase().contains(keyword.toLowerCase()))
          .toList();
    });
  }

  void applyFilter(String filter) {
    setState(() {
      filterSelected = filter;

      if (filter == "Terdekat") {
        filteredList.sort((a, b) => a['distance'].compareTo(b['distance']));
      } else if (filter == "Rating") {
        filteredList.sort((a, b) => b['rating'].compareTo(a['rating']));
      } else {
        filteredList = List.from(dataList);
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Semua Penitipan"),
        backgroundColor: Colors.blue.shade600,
      ),
      body: Column(
        children: [
          // 🔎 Search Bar
          Padding(
            padding: const EdgeInsets.all(12),
            child: TextField(
              decoration: InputDecoration(
                hintText: "Cari penitipan...",
                prefixIcon: const Icon(Icons.search),
                filled: true,
                fillColor: Colors.grey.shade200,
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(12),
                  borderSide: BorderSide.none,
                ),
              ),
              onChanged: filterData,
            ),
          ),

          // 🧩 Filter Buttons
          SizedBox(
            height: 40,
            child: ListView(
              scrollDirection: Axis.horizontal,
              padding: const EdgeInsets.symmetric(horizontal: 12),
              children: [
                filterChip("Semua"),
                filterChip("Terdekat"),
                filterChip("Rating"),
              ],
            ),
          ),
          const SizedBox(height: 10),

          // 🛍 Grid Cards Shopee-style
          Expanded(
            child: GridView.builder(
              padding: const EdgeInsets.all(12),
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                childAspectRatio: 0.80,
                crossAxisSpacing: 10,
                mainAxisSpacing: 10,
              ),
              itemCount: filteredList.length,
              itemBuilder: (context, index) {
                final item = filteredList[index];

                return InkWell(
                  onTap: () {
                    Navigator.pushNamed(context, '/detail_mitra',
                        arguments: item);
                  },
                  child: Card(
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(12),
                    ),
                    elevation: 3,
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        ClipRRect(
                          borderRadius: const BorderRadius.vertical(
                              top: Radius.circular(12)),
                          child: Image.network(
                            item['path_area'],
                            height: 95,
                            width: double.infinity,
                            fit: BoxFit.cover,
                            errorBuilder: (_, __, ___) =>
                                Container(color: Colors.grey),
                          ),
                        ),
                        Padding(
                          padding: const EdgeInsets.all(8),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(item['title'],
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                  style: const TextStyle(
                                      fontWeight: FontWeight.bold)),
                              const SizedBox(height: 4),
                              Text(item['duration'],
                                  style: const TextStyle(
                                      fontSize: 12, color: Colors.grey)),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
          )
        ],
      ),
    );
  }

  Widget filterChip(String text) {
    return Padding(
      padding: const EdgeInsets.only(right: 8),
      child: ChoiceChip(
        label: Text(text),
        selected: filterSelected == text,
        onSelected: (_) => applyFilter(text),
      ),
    );
  }
}
