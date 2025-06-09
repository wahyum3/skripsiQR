<!doctype html>
<html lang="en">
  <head>
  	<title>Scanner</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="SideBar/css/style.css">
  </head>
  <body>
    <h2>Scan Barcode</h2>
    <div id="reader" style="width: 300px;"></div>
    <div id="scan-result"></div>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('scan-result').innerText = `QR Code terdeteksi: ${decodedText}`;
            // Kamu bisa redirect atau kirim data ke server di sini
            // window.location.href = `/proses/${decodedText}`;
            // Contoh format: "S50FF qty20"
            // Split kode QR seperti "S50FF qty20"
          const parts = decodedText.split(' qty');
          const kode_qr = parts[0] || '';
          const quantity_out = parseInt(parts[1]) || 0;

          // Kirim hanya kode_qr dan quantity_out
          fetch('/scan-out', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                kode_qr: kode_qr,
                quantity: quantity_out
            })
          })
          .then(response => response.json())
          .then(data => {
            console.log(data);
            alert("QR berhasil disimpan (Scan Out)!");
          })
          .catch(error => {
            console.error('Error:', error);
          });
        }

        function startScanner() {
            const html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    // Pilih kamera belakang jika ada
                    let backCamera = devices.find(device => device.label.toLowerCase().includes('back')) || devices[0];

                    html5QrCode.start(
                        backCamera.id,
                        {
                            fps: 10,
                            qrbox: 250
                        },
                        onScanSuccess
                    );
                }
            }).catch(err => {
                console.error("Camera error:", err);
            });
        }

        // Auto start scanner saat halaman dibuka
        window.addEventListener('load', startScanner);
    </script>
    <a href="{{ route('outboundList') }}" class="btn btn-primary">List Scan</a>

    <script src="SideBar/js/jquery.min.js"></script>
    <script src="SideBar/js/popper.js"></script>
    <script src="SideBar/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
	  <script src="SideBar/js/main.js"></script>
  </body>
</html>    