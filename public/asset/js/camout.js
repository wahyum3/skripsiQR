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