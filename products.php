<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
<ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="products.php">Manage  the Products</a></li>
        <li class="nav-item"><a class="nav-link" href="subscriptions.php">Manage  the subscription</a></li>
      </ul>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <h3>Manage Products</h3>
  <a href="product_form.php" class="btn btn-success mb-3">+ Add New Product</a>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Specification</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Delivery</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $products->fetch_assoc()): ?>
      <tr>
        <td><img src="uploads/<?= $row['photo']; ?>" width="60" height="60" style="object-fit:cover;"></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['specification']; ?></td>
        <td><?= $row['price']; ?></td>
        <td><?= $row['discount']; ?></td>
        <td><?= $row['delivery_charge']; ?></td>
        <td>
          <a href="product_form.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="delete_product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
