<?php function drawCheckoutForm($service_freelancer, $userId, Session $session): void
{ ?>
  <section class="checkout-section">

    <div class="checkout-summary">
      <h2 class="section-title">Confirm purchase</h2>

      <img src="<?= htmlspecialchars($service_freelancer['images'][0] ?? '/assets/images/pfps/default.jpeg') ?>"
        alt="Service image"
        class="checkout-summary-img">

      <p><strong>Service:</strong>
        <a href="/pages/service_detail.php?id=<?= htmlspecialchars((string)$service_freelancer['serviceId']) ?>" class="checkout-link">
          <?= htmlspecialchars($service_freelancer['title']) ?>
        </a>
      </p>

      <p><strong>Freelancer:</strong>
        <a href="/pages/user.php?id=<?= htmlspecialchars((string)$service_freelancer['freelancer']['id']) ?>" class="checkout-link">
          <?= htmlspecialchars($service_freelancer['freelancer']['name']) ?>
        </a>
      </p>

      <p><strong>Price:</strong> <?= htmlspecialchars((string)$service_freelancer['price']) ?> €</p>
    </div>

    <form class="payment-info" action="/actions/action_purchase.php" method="post">
      <input type="hidden" name="csrf_token" value="<?= $session->getCSRFToken() ?? '' ?>">
      <input type="hidden" name="clientId" value="<?= htmlspecialchars((string)$userId) ?>">
      <input type="hidden" name="serviceId" value="<?= htmlspecialchars((string)$service_freelancer['serviceId']) ?>">

      <div class="input-group">
        <label for="card_number">Card Number</label>
        <i class="fa-solid fa-credit-card"></i>
        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required pattern="\d{4}\s\d{4}\s\d{4}\s\d{4}" maxlength="19">
      </div>

      <div class="input-group">
        <label for="exp_date">Expiration Date</label>
        <i class="fa-solid fa-calendar-days"></i>
        <input type="text" id="exp_date" name="exp_date" placeholder="MM/AA" required  pattern="\d{2}/\d{2}" maxlength="5">
      </div>

      <div class="input-group">
        <label for="sec_code">Security Code (CVV)</label>
        <i class="fa-solid fa-lock"></i>
        <input type="text" id="sec_code" name="sec_code" placeholder="123" required pattern="\d{3}" maxlength="3">
      </div>

      <div class="input-group">
        <label for="cardholder_name">Cardholder´s name</label>
        <i class="fa-solid fa-user"></i>
        <input type="text" id="cardholder_name" name="cardholder_name" placeholder="John Silva" required pattern="[A-Za-zÀ-ÿ\s]+" >
      </div>

      <input type="submit" value="Buy" class="btn-transition">
    </form>

  </section>
<?php } ?>
