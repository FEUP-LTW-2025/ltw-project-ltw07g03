<?php
declare(strict_types=1);

?>


<?php function drawServiceCreationForm(array $possible_categories, int $userId): void { ?>
  <form action="/actions/action_create_service.php" method="post" enctype="multipart/form-data" class="service-form">

    <!-- Hidden field for the user ID -->
    <input type="hidden" name="userId" value="<?= htmlspecialchars((string)$userId) ?>">

    <!-- Category selection -->
    <label for="category">Category:</label>
    <select name="categoryId" id="category" required>
      <?php foreach ($possible_categories as $category): ?>
        <option value="<?= htmlspecialchars((string)$category->getId()) ?>">
          <?= htmlspecialchars($category->getName()) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <!-- Title -->
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required maxlength="100">

    <!-- Price -->
    <label for="price">Price (€):</label>
    <input type="number" id="price" name="price" step="0.01" min="0" required>

    <!-- Delivery Time -->
    <label for="deliveryTime">Delivery Time (in days):</label>
    <input type="number" id="deliveryTime" name="deliveryTime" min="1" required>

    <!-- Description -->
    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="4" maxlength="1000" required></textarea>

    <!-- Status -->
    <label for="status">Status:</label>
    <select name="status" id="status" required>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>

    <!-- Upload Images -->
    <div class="image-upload-wrapper">
        <label for="images" class="custom-file-upload">
            Upload Images
        </label>
        <input type="file" id="images" name="image" accept="image/*" multiple required>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn-primary">Create Service</button>
  </form>
<?php } ?>


