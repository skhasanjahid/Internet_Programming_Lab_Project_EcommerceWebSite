<?php
include 'db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = md5($_POST['password']); // later we can change this to password_hash()

  $check = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($check->num_rows > 0) {
    $error = "⚠️ Email already exists!";
  } else {
    $sql = "INSERT INTO users (username, email, password, role)
            VALUES ('$username', '$email', '$password', 'user')";
    if ($conn->query($sql)) {
      $success = "✅ Registration complete! You can now login.";
    } else {
      $error = "❌ Registration failed. Please try again.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="text-center mb-3">User Registration</h4>
          
          <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
          <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

          <form method="post">
            <div class="mb-3">
              <label>Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
          </form>
          <div class="text-center mt-3">
            <a href="index.php">Already have an account? Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
