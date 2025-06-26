let lastScannedCode = null;

function onScanSuccess(decodedText, decodedResult) {
    if (decodedText === lastScannedCode) {
        // Abaikan QR yang sama
        return;
    }

    lastScannedCode = decodedText;
    document.getElementById('scan-result').innerText = `QR Code terdeteksi: ${decodedText}`;

    // Pecah QR: contoh "A119FF qty20" → ["A119FF", "20"]
    const parts = decodedText.split(' qty');
    const kode_qr = parts[0]?.trim() || '';
    const quantity = parseInt(parts[1]) || 0;

    if (!kode_qr || quantity <= 0) {
        alert('Format QR tidak valid!');
        return;
    }

    fetch('/scan-out', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            kode_qr: kode_qr,
            quantity: quantity
        })
    })
        .then(response => {
            if (!response.ok) throw new Error('Gagal menyimpan data QR.');
            return response.json();
        })
        .then(data => {
            console.log(data);
            alert(data.message || "Scan Out berhasil!");
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan Scan Out.');
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