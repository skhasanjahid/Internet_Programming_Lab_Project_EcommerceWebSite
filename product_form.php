<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = ['name'=>'','specification'=>'','description'=>'','price'=>'','discount'=>'','delivery_charge'=>'','photo'=>''];

if ($id > 0) {
  $res = $conn->query("SELECT * FROM products WHERE id=$id");
  $product = $res->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $spec = $_POST['specification'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
  $discount = $_POST['discount'];
  $delivery = $_POST['delivery_charge'];
  
  // Handle photo upload
  if (!empty($_FILES['photo']['name'])) {
    $filename = time() . "_" . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $filename);
  } else {
    $filename = $product['photo'];
  }

  if ($id > 0) {
    $sql = "UPDATE products SET name='$name', specification='$spec', description='$desc', price='$price',
            discount='$discount', delivery_charge='$delivery', photo='$filename' WHERE id=$id";
  } else {
    $sql = "INSERT INTO products (name, specification, description, price, discount, delivery_charge, photo)
            VALUES ('$name','$spec','$desc','$price','$discount','$delivery','$filename')";
  }

  if ($conn->query($sql)) {
    header("Location: products.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $id ? 'Edit' : 'Add' ?> Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h3><?= $id ? 'Edit' : 'Add' ?> Product</h3>
  <form method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Product Name</label>
        <input type="text" name="name" value="<?= $product['name']; ?>" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Specification</label>
        <input type="text" name="specification" value="<?= $product['specification']; ?>" class="form-control">
      </div>
    </div>
    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control"><?= $product['description']; ?></textarea>
    </div>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>" class="form-control">
      </div>
      <div class="col-md-4 mb-3">
        <label>Discount</label>
        <input type="number" step="0.01" name="discount" value="<?= $product['discount']; ?>" class="form-control">
      </div>
      <div class="col-md-4 mb-3">
        <label>Delivery Charge</label>
        <input type="number" step="0.01" name="delivery_charge" value="<?= $product['delivery_charge']; ?>" class="form-control">
      </div>
    </div>
    <div class="mb-3">
      <label>Photo</label>
      <input type="file" name="photo" class="form-control">
      <?php if ($product['photo']): ?>
        <img src="uploads/<?= $product['photo']; ?>" width="100" class="mt-2">
      <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary"><?= $id ? 'Update' : 'Save' ?> Product</button>
    <a href="products.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>
