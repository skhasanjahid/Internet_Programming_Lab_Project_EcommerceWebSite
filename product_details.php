<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
  header("Location: index.php");
  exit;
}

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
if (!$product) {
  die("Product not found!");
}

// Calculate discounted price
$discounted_price = $product['price'] - ($product['price'] * $product['discount'] / 100);

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
  $rating = intval($_POST['rating']);
  $comment = $conn->real_escape_string($_POST['comment']);
  $uid = $_SESSION['user']['id'];

  $conn->query("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES ($id, $uid, $rating, '$comment')");
  header("Location: product_details.php?id=$id");
  exit;
}

// Fetch all reviews
$reviews = $conn->query("SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id=$id ORDER BY r.created_at DESC");

// Calculate average rating
$avgQuery = $conn->query("SELECT AVG(rating) as avgRating FROM reviews WHERE product_id=$id");
$avg = $avgQuery->fetch_assoc()['avgRating'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']); ?> - Computer Shop BD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .star { color: gold; font-size: 1.2rem; }
    .discount-price { color: #28a745; font-weight: bold; }
    .original-price { text-decoration: line-through; color: #888; margin-left: 5px; }
  </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="user_dashboard.php">🖥️ Computer Shop BD</a>
    <a href="logout.php" class="btn btn-outline-light ms-auto">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-5">
      <img src="uploads/<?= $product['photo']; ?>" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-7">
      <h3><?= htmlspecialchars($product['name']); ?></h3>
      <p class="text-muted"><?= htmlspecialchars($product['specification']); ?></p>
      <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>

      <!-- Price Section -->
      <h4>
        <span class="discount-price">৳ <?= number_format($discounted_price, 2); ?></span>
        <?php if ($product['discount'] > 0): ?>
          <span class="original-price">৳ <?= number_format($product['price'], 2); ?></span>
          <small class="text-danger ms-1">(<?= $product['discount']; ?>% OFF)</small>
        <?php endif; ?>
      </h4>

      <p>Delivery Charge: ৳ <?= $product['delivery_charge']; ?></p>

      <div class="mb-3">
        <strong>Average Rating:</strong>
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <span class="star"><?= ($i <= round($avg)) ? "★" : "☆"; ?></span>
        <?php endfor; ?>
        (<?= round($avg, 1); ?>/5)
      </div>

      <!-- Order Button -->
      <a href="order.php?id=<?= $product['id']; ?>" class="btn btn-success mt-2">🛒 Order Now</a>
    </div>
  </div>

  <hr>

  <!-- Review Form -->
  <div class="mt-4">
    <h5>Leave a Review</h5>
    <form method="post">
      <div class="mb-3">
        <label>Rating:</label>
        <div class="star-rating">
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
            <label for="star<?= $i ?>" title="<?= $i ?> stars">★</label>
          <?php endfor; ?>
        </div>
      </div>
      <div class="mb-3">
        <textarea name="comment" class="form-control" rows="3" placeholder="Write your comment..." required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
  </div>

  <hr>

  <style>
  /* Star rating style */
  .star-rating {
    direction: rtl;
    font-size: 2rem;
    unicode-bidi: bidi-override;
    display: inline-block;
  }
  .star-rating input {
    display: none;
  }
  .star-rating label {
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
  }
  .star-rating input:checked ~ label,
  .star-rating label:hover,
  .star-rating label:hover ~ label {
    color: gold;
  }
  </style>

  <!-- Show All Reviews -->
  <h5>Customer Reviews</h5>
  <?php if ($reviews->num_rows > 0): ?>
    <?php while($r = $reviews->fetch_assoc()): ?>
      <div class="card mb-2">
        <div class="card-body">
          <strong><?= htmlspecialchars($r['username']); ?></strong>
          <span class="text-warning">
            <?php for ($i=1; $i<=5; $i++): ?>
              <?= ($i <= $r['rating']) ? "★" : "☆"; ?>
            <?php endfor; ?>
          </span>
          <p class="mb-1"><?= nl2br(htmlspecialchars($r['comment'])); ?></p>
          <small class="text-muted"><?= $r['created_at']; ?></small>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No reviews yet. Be the first!</p>
  <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-3 mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-3">Computer Shop BD</h5>
                <p>Your trusted destination for computers, accessories, and expert advice.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="text-uppercase mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Shop</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">About Us</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="text-uppercase mb-3">Customer Service</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white-50 text-decoration-none">Returns</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Shipping</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="text-uppercase mb-3">Contact Us</h6>
                <p class="mb-1"><i class="bi bi-envelope"></i> hassanjahid317@gmail.com</p>
                <p class="mb-2"><i class="bi bi-telephone"></i> +880 1909710088</p>
                <div>
                    <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white me-2"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center">
            <small>&copy; <?= date('Y'); ?> Computer Shop BD. All Rights Reserved.</small>
        </div>
    </div>
</footer>

</body>
</html>
