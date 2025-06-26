document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('qrForm');
  if (!form) return;

  const defaultJenisMaterial = 'A119FF';
  const defaultQuantity = '20';

  const jenisMaterialInput = form.querySelector('input[name="jenis_material"]');
  const quantityInput = form.querySelector('input[name="quantity"]');

  form.addEventListener('submit', function (e) {
    const jenisMaterial = jenisMaterialInput.value.trim();
    const quantity = quantityInput.value.trim();

    if (jenisMaterial === defaultJenisMaterial && quantity === defaultQuantity) {
      e.preventDefault();
      alert('Silakan ubah jenis material atau quantity terlebih dahulu sebelum generate QR.');
    }
  });
});
