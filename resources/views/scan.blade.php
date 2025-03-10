<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code Arsip</title>
    
    <!-- Load library Html5Qrcode -->
    <script src="https://unpkg.com/html5-qrcode" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg text-center">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Scan QR Code Arsip</h2>

        <!-- Tempat Scanner -->
        <div id="reader" class="border-2 border-gray-300 rounded-lg p-4"></div>

        <!-- Input Manual -->
        <input type="text" id="kode_qr" placeholder="Masukkan kode QR" 
            class="border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#D37B0A] transition p-2 w-full mt-4 text-center">
            <!-- class="w-full px-4 py-2 border-2 border-gray-900 rounded-lg focus:outline-none focus:border-[#D37B0A] transition" /> -->
            <button onclick="cariArsip()" 
    class="mt-3 bg-[#D67900] hover:bg-[#E08E00] text-white font-semibold py-2 px-4 rounded-lg w-full">
    Cari Arsip
</button>

        <!-- Hasil Pencarian -->
        <div id="hasil" class="mt-4 text-gray-700 text-left"></div>

        <!-- Tombol Login Admin -->
        <a href="/admin/login" class="mt-6 block text-center text-white bg-[#D67900] hover:bg-[#E08E00] font-semibold py-2 px-4 rounded-lg">
    Login Admin
</a>
    </div>

    <script>
        function cariArsip() {
            var kode_qr = document.getElementById("kode_qr").value;
            if (kode_qr === "") {
                alert("Masukkan QR Code terlebih dahulu!");
                return;
            }

            fetch(`/api/scan/${kode_qr}`)
                .then(response => response.json())
                .then(data => {
                    if (data.nama_arsip) {
                        document.getElementById("hasil").innerHTML = `
                            <p><strong>Nama Arsip:</strong> ${data.nama_arsip}</p>
                            <p><strong>Lokasi:</strong> ${data.lokasi}</p>
                            <p><strong>Deskripsi:</strong> ${data.deskripsi}</p>
                        `;
                    } else {
                        document.getElementById("hasil").innerHTML = `<p class="text-red-600">Arsip tidak ditemukan!</p>`;
                    }
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById("hasil").innerHTML = `<p class="text-red-600">Terjadi kesalahan!</p>`;
                });
        }

        function startScan() {
            if (!window.Html5QrcodeScanner) {
                console.error("Html5QrcodeScanner belum dimuat!");
                return;
            }

            let scanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            });

            scanner.render((decodedText) => {
                document.getElementById("kode_qr").value = decodedText;
                cariArsip();
            });
        }

        // Pastikan scanner dipanggil setelah halaman dimuat
        window.onload = startScan;
    </script>

</body>
</html>
