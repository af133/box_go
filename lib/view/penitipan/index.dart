import 'package:flutter/material.dart';
// Asumsi path import ini benar untuk file konstanta
import 'package:box_go/shared/constants.dart'; 

class AllMitraPage extends StatefulWidget {
  const AllMitraPage({super.key});

  @override
  State<AllMitraPage> createState() => _AllMitraPageState();
}

class _AllMitraPageState extends State<AllMitraPage> {
  // dataList: Daftar asli dari argumen navigasi
  List<Map<String, dynamic>> dataList = [];
  // filteredList: Daftar yang ditampilkan di UI setelah filter/sort
  List<Map<String, dynamic>> filteredList = [];

  String filterSelected = "Semua";
  // Controller untuk mempertahankan teks pencarian
  TextEditingController searchController = TextEditingController(); 

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();

    // Mengambil data dari argument navigasi
    final args = ModalRoute.of(context)!.settings.arguments as Map?;
    
    // dataList akan diisi hanya dengan data valid dari argumen, jika tidak ada maka List kosong (sesuai permintaan user).
    dataList = (args != null && args.containsKey('dataList') && args['dataList'] is List)
      ? List<Map<String, dynamic>>.from(args['dataList'] as List)
      : [];

    // Mengisi daftar yang difilter saat inisialisasi
    filteredList = List.from(dataList);
  }

  // --- Data Placeholder Dihapus Sesuai Permintaan User ---


  // Fungsi untuk filter berdasarkan keyword (dipanggil saat teks berubah)
  void filterData(String keyword) {
    // 1. Selalu filter dari dataList asli
    final String lowerCaseKeyword = keyword.toLowerCase();
    
    // 2. Lakukan penyaringan keyword
    List<Map<String, dynamic>> tempFiltered = dataList
        .where((item) =>
            item['title'].toString().toLowerCase().contains(lowerCaseKeyword))
        .toList();

    // 3. Terapkan sortasi yang sedang dipilih pada hasil filter
    _applySort(tempFiltered, filterSelected);
  }

  // Fungsi internal untuk menerapkan sortasi (Terdekat/Rating)
  void _applySort(List<Map<String, dynamic>> list, String filter) {
    if (filter == "Terdekat") {
      // Sortasi berdasarkan 'distance' (jarak terdekat ke terjauh)
      // Menggunakan penanganan tipe yang aman
      list.sort((a, b) => (a['distance'] as num? ?? double.infinity).compareTo(b['distance'] as num? ?? double.infinity));
    } else if (filter == "Rating") {
      // Sortasi berdasarkan 'rating' (tertinggi ke terendah)
      // Menggunakan penanganan tipe yang aman
      list.sort((a, b) => (b['rating'] as num? ?? 0.0).compareTo(a['rating'] as num? ?? 0.0)); 
    } 
    
    // Perbarui state jika widget masih mounted
    if(mounted) {
      setState(() {
        filteredList = list;
      });
    }
  }

  // Fungsi untuk menerapkan filter (dipanggil saat chip diklik)
  void applyFilter(String filter) {
    final String keyword = searchController.text;
    
    // 1. Filter ulang berdasarkan keyword yang sedang ada di search bar
    List<Map<String, dynamic>> tempFiltered = dataList
        .where((item) =>
            item['title'].toString().toLowerCase().contains(keyword.toLowerCase()))
        .toList();

    // 2. Terapkan sortasi baru dan perbarui filterSelected
    setState(() {
      filterSelected = filter;
      if (filter == "Semua") {
        // Jika "Semua" dipilih, hanya terapkan filter keyword (urutan default/asli)
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
        title: const Text("Semua Penitipan", style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600)),
        backgroundColor: goBox, // Menggunakan warna utama dari constants
        iconTheme: const IconThemeData(color: Colors.white),
        elevation: 0,
      ),
      body: Column(
        children: [
          // 🔎 Search Bar (Gaya modern, menyatu dengan AppBar)
          Container(
            padding: const EdgeInsets.only(left: 16, right: 16, top: 8, bottom: 8),
            color: goBox, // Menyatu dengan AppBar
            child: TextField(
              controller: searchController,
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
              onChanged: filterData, // Memanggil fungsi filterData saat teks berubah
            ),
          ),

          // 🧩 Filter Buttons (Menggunakan Chip yang stylist)
          Padding(
            padding: const EdgeInsets.only(top: 8, bottom: 12),
            child: SizedBox(
              height: 38,
              child: ListView(
                scrollDirection: Axis.horizontal,
                padding: const EdgeInsets.symmetric(horizontal: 16),
                children: [
                  filterChip("Semua"),
                  filterChip("Terdekat"),
                  filterChip("Rating"),
                ],
              ),
            ),
          ),
          
          // 🛍 Grid Cards
          Expanded(
            child: filteredList.isEmpty
                ? Center(
                    child: Padding(
                      padding: const EdgeInsets.all(32.0),
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          Icon(Icons.storefront_off, size: 80, color: darkGrey.withOpacity(0.4)),
                          const SizedBox(height: 16),
                          Text(
                            // Pesan yang lebih informatif
                            dataList.isEmpty && searchController.text.isEmpty
                            ? "Saat ini belum ada data mitra. Pastikan halaman sebelumnya mengirimkan data yang valid."
                            : "Tidak ada mitra yang cocok dengan pencarian atau filter Anda.",
                            style: TextStyle(color: darkGrey, fontSize: 16),
                            textAlign: TextAlign.center,
                          ),
                        ],
                      ),
                    ),
                  )
                : GridView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                    gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: 2,
                      childAspectRatio: 0.75, // Disesuaikan agar konten kartu terlihat
                      crossAxisSpacing: 16,
                      mainAxisSpacing: 16,
                    ),
                    itemCount: filteredList.length,
                    itemBuilder: (context, index) {
                      final item = filteredList[index];
                      return MitraCard(item: item);
                    },
                  ),
          )
        ],
      ),
    );
  }

  // Widget untuk Chip Filter (menggunakan konstanta warna)
  Widget filterChip(String text) {
    final bool isSelected = filterSelected == text;
    return Padding(
      padding: const EdgeInsets.only(right: 8),
      child: ChoiceChip(
        label: Text(
          text,
          style: TextStyle(
            color: isSelected ? Colors.white : darkGrey,
            fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
          ),
        ),
        selected: isSelected,
        selectedColor: goBox, // Warna terpilih = goBox (Hijau)
        backgroundColor: Colors.white,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(20),
          side: BorderSide(
            color: isSelected ? goBox : darkGrey.withOpacity(0.5),
            width: 1,
          ),
        ),
        onSelected: (_) => applyFilter(text),
      ),
    );
  }
}

// Widget terpisah untuk Kartu Mitra (menggunakan konstanta warna dan tampilan detail)
class MitraCard extends StatelessWidget {
  final Map<String, dynamic> item;
  
  const MitraCard({super.key, required this.item});

  @override
  Widget build(BuildContext context) {
    // Mendapatkan nilai dengan tipe yang aman
    final String title = item['title'] ?? 'Nama Mitra Tidak Diketahui';
    final String imageUrl = item['path_area'] ?? 'https://placehold.co/600x400/9E9E9E/FFFFFF?text=No+Image';
    // Menggunakan num? dan konversi ke double untuk keamanan
    final double rating = (item['rating'] as num? ?? 0.0).toDouble(); 
    final double distance = (item['distance'] as num? ?? 0.0).toDouble();
    final String duration = item['duration'] ?? 'N/A';
    
    return InkWell(
      onTap: () {
        // Navigasi ke halaman detail
        Navigator.pushNamed(context, '/detail_mitra', arguments: item);
      },
      child: Card(
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        elevation: 6, 
        shadowColor: goBox.withOpacity(0.3), // Bayangan warna goBox
        clipBehavior: Clip.antiAlias, 
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Gambar Area
            ClipRRect(
              borderRadius: const BorderRadius.vertical(top: Radius.circular(12)),
              child: Image.network(
                imageUrl,
                height: 110, 
                width: double.infinity,
                fit: BoxFit.cover,
                errorBuilder: (_, __, ___) => 
                    Container(
                      height: 110,
                      color: lightGrey, // Menggunakan lightGrey
                      child: const Center(child: Icon(Icons.broken_image, color: darkGrey)),
                    ),
              ),
            ),
            
            // Detail Teks
            Padding(
              padding: const EdgeInsets.all(8),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Judul Mitra
                  Text(
                    title,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                    style: const TextStyle(
                        fontWeight: FontWeight.w800,
                        fontSize: 14,
                        color: darkGrey), // Menggunakan darkGrey
                  ),
                  const SizedBox(height: 4),

                  // Rating dan Jarak
                  Row(
                    children: [
                      const Icon(Icons.star, color: Colors.amber, size: 16), // Rating tetap Amber
                      const SizedBox(width: 4),
                      Text(
                        rating.toStringAsFixed(1),
                        style: const TextStyle(
                            fontSize: 12, fontWeight: FontWeight.bold),
                      ),
                      const Spacer(),
                      
                      // Jarak dalam KM
                      Icon(Icons.location_on, color: goBox.withOpacity(0.7), size: 14),
                      const SizedBox(width: 2),
                      Text(
                        '${distance.toStringAsFixed(1)} km',
                        style: TextStyle(
                            fontSize: 12, color: darkGrey.withOpacity(0.8)),
                      ),
                    ],
                  ),
                  const SizedBox(height: 4),
                  
                  // Estimasi Waktu Tempuh
                  Row(
                    children: [
                      Icon(Icons.access_time, color: goBox, size: 14),
                      const SizedBox(width: 4),
                      Text(
                        duration,
                        style: TextStyle(
                            fontSize: 12, color: goBox, fontWeight: FontWeight.w600),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}