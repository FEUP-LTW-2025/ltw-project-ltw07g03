document.addEventListener('DOMContentLoaded', () => {
  // Card Number formatting
  document.getElementById('card_number').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '').slice(0, 16);
    e.target.value = value.match(/.{1,4}/g)?.join(' ') || '';
  });

  // Expiration date formatting
  document.getElementById('exp_date').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '').slice(0, 4);
    if (value.length >= 3) value = value.slice(0, 2) + '/' + value.slice(2);
    e.target.value = value;
  });

  // CVV restriction
  document.getElementById('sec_code').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '').slice(0, 3);
  });

  // Cardholder name restriction
  document.getElementById('cardholder_name').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
  });
});
