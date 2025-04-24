<?php function drawCheckoutForm($service_freelancer, $userId): void { ?>
  <section class="checkout-section">

  <div class="checkout-summary">
    <h2>Confirm purchase</h2>

    <img src="<?= htmlspecialchars($service_freelancer['images'][0] ?? '/assets/images/pfps/default.jpeg') ?>" 
         alt="Service image" 
         class="checkout-summary-img">

    <p><strong>Service:</strong> 
        <a href="/pages/service_detail.php?id=<?= $service_freelancer['serviceId'] ?>" class="checkout-link">
            <?= htmlspecialchars($service_freelancer['title']) ?>
        </a>
    </p>

    <p><strong>Freelancer:</strong> 
        <a href="/pages/user.php?id=<?= $service_freelancer['freelancer']['id'] ?>" class="checkout-link">
            <?= htmlspecialchars($service_freelancer['freelancer']['name']) ?>
        </a>
    </p>

    <p><strong>Price:</strong> <?= htmlspecialchars((string)$service_freelancer['price']) ?> €</p>
</div>

    <form class="payment-info" action="/actions/action_purchase.php" method="post">

      <input type="hidden" name="clientId" value="<?= htmlspecialchars((string)$userId) ?>">

      <input type="hidden" name="serviceId" value="<?= htmlspecialchars((string)$service_freelancer['serviceId']) ?>">

      <label for="Card_number">Card Number</label>
      <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required autocomplete="cc-number">

      <label for="exp_date">Expiration Date</label>
      <input type="text" id="exp_date" name="exp_date" placeholder="MM/AA" required autocomplete="cc-exp">

      <label for="sec_code">Security Code(CVV)</label>
      <input type="text" id="sec_code" name="sec_code" placeholder="123" required autocomplete="cc-csc">

      <label for="cardholder_name">Cardholder´s name</label>
      <input type="text" id="cardholder_name" name="cardholder_name" placeholder="John Silva" required autocomplete="cc-name">

      <input type="submit" value="Buy">
    </form>
  </section>
<?php } ?>
