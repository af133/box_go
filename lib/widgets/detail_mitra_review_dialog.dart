import 'package:flutter/material.dart';
import 'package:box_go/shared/constants.dart';

class DetailMitraReviewDialog {
  static void show(BuildContext context, Map<String, dynamic> mitraData) {
    double tempRating = 5.0;
    String tempReview = '';

    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
          title: const Text('Beri Rating & Ulasan'),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                StatefulBuilder(
                  builder: (context, setInnerState) {
                    return Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: List.generate(5, (index) {
                        return IconButton(
                          icon: Icon(
                            index < tempRating.round()
                                ? Icons.star
                                : Icons.star_border,
                            color: Colors.amber,
                            size: 30,
                          ),
                          onPressed: () {
                            setInnerState(() {
                              tempRating = (index + 1).toDouble();
                            });
                          },
                        );
                      }),
                    );
                  },
                ),
                const SizedBox(height: 15),
                TextField(
                  onChanged: (value) => tempReview = value,
                  keyboardType: TextInputType.multiline,
                  maxLines: 3,
                  decoration: InputDecoration(
                    hintText: "Tulis ulasan Anda...",
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10),
                    ),
                  ),
                ),
              ],
            ),
          ),
          actions: <Widget>[
            TextButton(
              child: Text('Batal', style: TextStyle(color: darkGrey)),
              onPressed: () => Navigator.of(context).pop(),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(backgroundColor: goBox),
              child: const Text('Kirim', style: TextStyle(color: Colors.white)),
              onPressed: () async {
                final reviewData = {
                  "mitra_id": mitraData['id'],
                  "rating": tempRating,
                  "review": tempReview,
                };

                print("Mengirim review ke backend: $reviewData");

                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text('Rating $tempRating dan ulasan berhasil dikirim!'),
                  ),
                );
                Navigator.of(context).pop();
              },
            ),
          ],
        );
      },
    );
  }
}