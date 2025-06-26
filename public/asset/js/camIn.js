let lastScannedCode = null;

function onScanSuccess(decodedText, decodedResult) {
  if (decodedText === lastScannedCode) {
    // Abaikan QR yang sama (duplikat scan)
    return;
  }

  lastScannedCode = decodedText;
  document.getElementById('scan-result').innerText = `QR Code terdeteksi: ${decodedText}`;

  // Kirim ke server (kode QR utuh, misalnya "A119FF qty20")
  fetch('/scan-in', {
    method: 'POST',
    credentials: 'same-origin', // ini penting agar cookie session terkirim
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      kode_qr: decodedText
    })
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Gagal menyimpan data QR.');
      }
      return response.json();
    })
    .then(data => {
      console.log(data);
      alert(data.message || "QR berhasil disimpan!");
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat menyimpan QR.');
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