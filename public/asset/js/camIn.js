
    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById('scan-result').innerText = `QR Code terdeteksi: ${decodedText}`;
        // Kamu bisa redirect atau kirim data ke server di sini
        // window.location.href = `/proses/${decodedText}`;
        // Contoh format: "S50FF qty20"
        const parts = decodedText.split(' qty');
        const jenis_material = parts[0] || '';
        const quantity_in = parseInt(parts[1]) || 0;
        // Kirim ke server Laravel
      fetch('/scan-in', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
                kode_qr: jenis_material,        // Hanya kode, bukan qty
                jenis_material: jenis_material,
                quantity: quantity_in,
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
        alert("QR berhasil disimpan!");
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
    
    window.addEventListener('resize', () => {
    // Optional: Refresh layout or re-adjust elements if needed
    const reader = document.getElementById('reader');
    if (reader) {
      reader.style.width = '100%'; // or re-init scanner size here if needed
    }
    });