import "package:flutter/material.dart";
import 'package:box_go/shared/constants.dart';
// --- DEFINISI WARNA (Digunakan dari kode sebelumnya) ---
const Color darkGrey = Color(0xFF616161);
const Color lightGrey = Color(0xFFF0F0F0);
// ---------------------------------------------------

// --- 1. MODEL DATA (Simulasi dari Skema Database Anda) ---
class Pelanggan {
  final int idPelanggan;
  final String idEmail; // Kolom yang TIDAK BISA diubah
  String nama;
  String? pathProfil;
  String? alamat;
  String? nomorHp;
  
  Pelanggan({
    required this.idPelanggan,
    required this.idEmail,
    required this.nama,
    this.pathProfil,
    this.alamat,
    this.nomorHp,
  });

  // Contoh data dummy untuk demo
  static Pelanggan get dummy => Pelanggan(
    idPelanggan: 1,
    idEmail: 'rian.subagya@contoh.com',
    nama: 'Rian Subagya',
    pathProfil: 'https://i.pravatar.cc/150?img=3',
    alamat: 'Jl. Sudirman No. 12, Jakarta Pusat',
    nomorHp: '081234567890',
  );

  // Fungsi untuk simulasi update data (untuk demo)
  Pelanggan copyWith({
    String? nama,
    String? alamat,
    String? nomorHp,
  }) {
    return Pelanggan(
      idPelanggan: idPelanggan,
      idEmail: idEmail,
      nama: nama ?? this.nama,
      pathProfil: pathProfil,
      alamat: alamat ?? this.alamat,
      nomorHp: nomorHp ?? this.nomorHp,
    );
  }
}

// ====================================================================
// --- 2. WIDGET PROFILE PAGE (STATEFUL) ---
// ====================================================================

class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  // Data pelanggan yang akan diubah
  late Pelanggan _pelanggan;

  // Status apakah sedang dalam mode edit
  bool _isEditing = false; 

  // Controller untuk Field yang bisa di-edit
  late TextEditingController _namaController;
  late TextEditingController _alamatController;
  late TextEditingController _nomorHpController;

  @override
  void initState() {
    super.initState();
    // Inisialisasi data dummy (Ganti dengan fetch data API/database di aplikasi nyata)
    _pelanggan = Pelanggan.dummy; 

    _namaController = TextEditingController(text: _pelanggan.nama);
    _alamatController = TextEditingController(text: _pelanggan.alamat);
    _nomorHpController = TextEditingController(text: _pelanggan.nomorHp);
  }

  @override
  void dispose() {
    _namaController.dispose();
    _alamatController.dispose();
    _nomorHpController.dispose();
    super.dispose();
  }

  // Fungsi untuk menyimpan perubahan
  void _saveChanges() {
    // 1. Ambil nilai baru dari controller
    final String newNama = _namaController.text;
    final String newAlamat = _alamatController.text;
    final String newNomorHp = _nomorHpController.text;

    // 2. Simulasi menyimpan ke backend / update state
    setState(() {
      _pelanggan = _pelanggan.copyWith(
        nama: newNama,
        alamat: newAlamat,
        nomorHp: newNomorHp,
      );
      _isEditing = false; // Keluar dari mode edit
    });

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(content: Text('Profil berhasil diperbarui!')),
    );

    // Di aplikasi nyata: Panggil API PUT/PATCH di sini
  }

  // Fungsi untuk membatalkan pengeditan
  void _cancelEdit() {
     setState(() {
      _isEditing = false;
      // Kembalikan controller ke nilai semula jika dibatalkan
      _namaController.text = _pelanggan.nama;
      _alamatController.text = _pelanggan.alamat ?? '';
      _nomorHpController.text = _pelanggan.nomorHp ?? '';
    });
  }

  // Widget untuk Field yang bisa di-edit
  Widget _buildEditableField(
      {required String label,
      required TextEditingController controller,
      IconData? icon,
      bool readOnly = false,
      TextInputType keyboardType = TextInputType.text}) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 15.0),
      child: TextFormField(
        controller: controller,
        readOnly: readOnly || !_isEditing,
        keyboardType: keyboardType,
        decoration: InputDecoration(
          labelText: label,
          prefixIcon: icon != null ? Icon(icon, color: goBox) : null,
          border: const OutlineInputBorder(),
          // Visual khusus jika read-only
          fillColor: readOnly ? lightGrey : Colors.white,
          filled: readOnly,
        ),
        style: TextStyle(
          color: readOnly ? darkGrey : Colors.black87,
          fontWeight: readOnly ? FontWeight.normal : FontWeight.w500,
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(_isEditing ? 'Edit Profil' : 'Profil Saya'),
        backgroundColor: goBox,
        foregroundColor: Colors.white,
        actions: [
          if (_isEditing)
            // Tombol Simpan
            IconButton(
              icon: const Icon(Icons.check),
              onPressed: _saveChanges,
            )
          else
            // Tombol Edit
            IconButton(
              icon: const Icon(Icons.edit),
              onPressed: () {
                setState(() {
                  _isEditing = true;
                });
              },
            ),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // --- Foto Profil ---
            Stack(
              children: [
                CircleAvatar(
                  radius: 50,
                  backgroundColor: darkGrey,
                  backgroundImage: NetworkImage(_pelanggan.pathProfil ?? ''),
                ),
                if (_isEditing)
                  Positioned(
                    bottom: 0,
                    right: 0,
                    child: CircleAvatar(
                      radius: 18,
                      backgroundColor: goBox,
                      child: IconButton(
                        icon: const Icon(Icons.camera_alt,
                            size: 18, color: Colors.white),
                        onPressed: () {
                          // Aksi: Pilih atau ambil foto
                        },
                      ),
                    ),
                  ),
              ],
            ),
            const SizedBox(height: 30),

            // --- Field Email (Tidak Bisa Diedit) ---
            _buildEditableField(
              label: 'Email (ID)',
              controller: TextEditingController(text: _pelanggan.idEmail),
              icon: Icons.email_outlined,
              readOnly: true, // WAJIB read-only
            ),

            // --- Field Nama ---
            _buildEditableField(
              label: 'Nama',
              controller: _namaController,
              icon: Icons.person_outline,
            ),

            // --- Field Nomor HP ---
            _buildEditableField(
              label: 'Nomor HP',
              controller: _nomorHpController,
              icon: Icons.phone_android_outlined,
              keyboardType: TextInputType.phone,
            ),

            // --- Field Alamat ---
            _buildEditableField(
              label: 'Alamat',
              controller: _alamatController,
              icon: Icons.location_on_outlined,
            ),
            
            const SizedBox(height: 20),

            // --- Tombol Batal (Hanya muncul saat editing) ---
            if (_isEditing)
              SizedBox(
                width: double.infinity,
                child: OutlinedButton(
                  onPressed: _cancelEdit,
                  style: OutlinedButton.styleFrom(
                    foregroundColor: Colors.red,
                    side: const BorderSide(color: Colors.red),
                    padding: const EdgeInsets.symmetric(vertical: 15),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(10),
                    ),
                  ),
                  child: const Text('Batal'),
                ),
              ),
          ],
        ),
      ),
    );
  }
}