<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Barcode Arsip</title>

    <!-- Load library Html5Qrcode -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>

    <h2>Scan Barcode Arsip</h2>

    <div id="reader" style="width: 300px;"></div>

    <input type="text" id="barcode" placeholder="Masukkan Barcode">
    <button onclick="cariArsip()">Cari</button>

    <div id="hasil"></div>

    <script>
        function cariArsip() {
            var barcode = document.getElementById("barcode").value;
            if (barcode === "") {
                alert("Masukkan barcode terlebih dahulu!");
                return;
            }

            fetch(`/api/scan/${barcode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nama_arsip) {
                        document.getElementById("hasil").innerHTML = `
                            <p><strong>Nama Arsip:</strong> ${data.nama_arsip}</p>
                            <p><strong>Lokasi:</strong> ${data.lokasi}</p>
                            <p><strong>Deskripsi:</strong> ${data.deskripsi}</p>
                        `;
                    } else {
                        document.getElementById("hasil").innerHTML = `<p style="color: red;">Arsip tidak ditemukan!</p>`;
                    }
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById("hasil").innerHTML = `<p style="color: red;">Terjadi kesalahan!</p>`;
                });
        }

        function startScan() {
            let scanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            });

            scanner.render((decodedText) => {
                document.getElementById("barcode").value = decodedText;
                scanner.clear();
                cariArsip();
            });
        }

        // Mulai scanner saat halaman dibuka
        startScan();
    </script>

</body>
</html>
