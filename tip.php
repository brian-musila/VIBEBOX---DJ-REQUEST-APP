<!DOCTYPE html>
<html>
<head>
  <title>Tip the DJ | VibeBox</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="form-container">
  <h1>💰 Tip the DJ</h1>

  <form action="tip-handler.php" method="POST">
    <label for="method"><strong>Select Payment Method:</strong></label><br>
    <select name="method" id="method" required>
      <option value="">-- Choose Method --</option>
      <option value="mpesa">📱 M-PESA</option>
      <option value="paypal">🌐 PayPal</option>
      <option value="bank">🏦 Bank Transfer</option>
      <option value="wise">✈️ Wise Transfer</option>
    </select>

    <div id="paymentDetails" style="margin-top: 20px;"></div>

    <!-- Optional: capture email or reference -->
    <input type="text" name="reference" placeholder="Your Email or Name (optional)">

    <button class="btn-submit" type="submit">Proceed</button>
  </form>

  <div class="back-link"><a href="index.php">⬅️ Back</a></div>
</div>

<script>
  const select = document.getElementById('method');
  const details = document.getElementById('paymentDetails');

  const instructions = {
    mpesa: `
      <p>Send to:</p>
      <p><strong>Paybill:</strong> 123456</p>
      <p><strong>Account:</strong> VIBEBOX</p>
      <input type="text" name="phone" placeholder="Enter M-PESA Number" required>
      <input type="number" name="amount" placeholder="Tip Amount (KES)" required>
    `,
    paypal: `
      <p>Send your tip to:</p>
      <p><strong>PayPal Link:</strong> <a href="https://paypal.me/vibeboxdj" target="_blank">paypal.me/vibeboxdj</a></p>
      <input type="number" name="amount" placeholder="Tip Amount (USD)" required>
    `,
    bank: `
      <p><strong>Bank Name:</strong> Equity Bank</p>
      <p><strong>Account No:</strong> 1234567890</p>
      <p><strong>Name:</strong> VIBEBOX MUSIC</p>
      <input type="number" name="amount" placeholder="Tip Amount" required>
    `,
    wise: `
      <p><strong>Wise Email:</strong> dj@vibebox.com</p>
      <p>Use Wise to send in your local currency.</p>
      <input type="number" name="amount" placeholder="Tip Amount" required>
    `
  };

  select.addEventListener('change', () => {
    const method = select.value;
    details.innerHTML = instructions[method] || '';
  });
</script>
</body>
</html>
