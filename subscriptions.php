<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

// Handle approve/reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'] === 'approve' ? 'approved' : 'rejected';
    $conn->query("UPDATE subscriptions SET status='$action' WHERE id=$id");
    header("Location: subscriptions.php");
    exit;
}

// Fetch all subscription requests
$subs = $conn->query("
    SELECT s.*, u.username, u.email 
    FROM subscriptions s 
    JOIN users u ON s.user_id = u.id
    ORDER BY s.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Subscriptions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
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

<!-- Subscription Table -->
<div class="container mt-4">
  <h3>Subscription Requests</h3>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>User</th>
        <th>Email</th>
        <th>Status</th>
        <th>Requested At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $subs->fetch_assoc()): ?>
        <?php 
          $status = $row['status'];
          $color = $status == 'approved' ? 'success' : ($status == 'rejected' ? 'danger' : 'warning');
        ?>
        <tr>
          <td><?= htmlspecialchars($row['username']); ?></td>
          <td><?= htmlspecialchars($row['email']); ?></td>
          <td><span class="badge bg-<?= $color ?>"><?= ucfirst($status) ?></span></td>
          <td><?= $row['created_at']; ?></td>
          <td>
            <?php if ($status == 'pending'): ?>
              <a href="?action=approve&id=<?= $row['id']; ?>" class="btn btn-sm btn-success">Approve</a>
              <a href="?action=reject&id=<?= $row['id']; ?>" class="btn btn-sm btn-danger">Reject</a>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
