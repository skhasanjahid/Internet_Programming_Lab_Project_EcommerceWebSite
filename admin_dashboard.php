<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Computer Shop BD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .card-hover:hover {
      transform: translateY(-3px);
      transition: 0.3s;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .dashboard-title {
      font-weight: 700;
      color: #333;
    }
    footer {
      background: #212529;
      color: #bbb;
      padding: 15px 0;
      text-align: center;
      margin-top: 50px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold" href="admin_dashboard.php">⚙️ Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="products.php">📦 Manage Products</a></li>
        <li class="nav-item"><a class="nav-link" href="subscriptions.php">🧾 Manage Subscriptions</a></li>
      </ul>
      <span class="navbar-text text-white me-3">👤 <?= htmlspecialchars($_SESSION['user']['username']); ?></span>
      <button class="btn btn-danger" onclick="window.location.href='logout.php'">Logout</button>
    </div>
  </div>
</nav>

<!-- Dashboard Content -->
<div class="container mt-5">
  <?php if (isset($_SESSION['login_success'])): ?>
    <div class="alert alert-success shadow-sm">
      <?= $_SESSION['login_success']; ?>
    </div>
    <?php unset($_SESSION['login_success']); ?>
  <?php endif; ?>

  <h2 class="dashboard-title mb-4 text-center">Welcome to Admin Dashboard</h2>
  <p class="text-center text-muted mb-5">Manage your products, subscriptions, and oversee your store efficiently.</p>

  <div class="row text-center">
    <!-- Products Card -->
    <div class="col-md-6 mb-4">
      <div class="card card-hover shadow-sm border-0">
        <div class="card-body py-5">
          <h5 class="card-title fw-bold">Manage Products</h5>
          <p class="text-muted">Add, update, or delete product listings.</p>
          <a href="products.php" class="btn btn-primary px-4">Go to Products</a>
        </div>
      </div>
    </div>

    <!-- Subscription Card -->
    <div class="col-md-6 mb-4">
      <div class="card card-hover shadow-sm border-0">
        <div class="card-body py-5">
          <h5 class="card-title fw-bold">Manage Subscriptions</h5>
          <p class="text-muted">Approve or reject user subscription requests.</p>
          <a href="subscriptions.php" class="btn btn-success px-4">Go to Subscriptions</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  <small>&copy; <?= date('Y'); ?> Computer Shop BD | Admin Panel</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
