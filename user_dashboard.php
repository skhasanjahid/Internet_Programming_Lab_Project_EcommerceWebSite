<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

$uid = $_SESSION['user']['id'];

// Check subscription status
$subCheck = $conn->query("SELECT * FROM subscriptions WHERE user_id=$uid AND status='approved' LIMIT 1");
$hasSubscription = $subCheck->num_rows > 0;

// Search functionality
$search = "";
$searchCondition = "";
if (isset($_GET['q']) && $_GET['q'] !== "") {
    $search = $conn->real_escape_string($_GET['q']);
    $searchCondition = " AND (name LIKE '%$search%' OR specification LIKE '%$search%')";
}

// All Products excluding subscriber-only products
$sql = "SELECT * FROM products 
        WHERE delivery_charge > 0 
        AND discount < 25 
        $searchCondition
        ORDER BY id DESC";
$products = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Computer Shop BD - User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        .navbar-brand {
            letter-spacing: 2px;
            font-size: 1.5rem;
        }
        .btn-gradient-blue {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
            transition: background 0.2s, transform 0.2s;
        }
        .btn-gradient-blue:hover {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            color: #fff;
            transform: translateY(-2px) scale(1.03);
        }
        .card-hover-effect {
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .card-hover-effect:hover {
            box-shadow: 0 8px 32px 0 rgba(31, 41, 55, 0.18);
            transform: translateY(-6px) scale(1.03);
            z-index: 2;
        }
        .badge {
            font-size: 0.9rem;
            border-radius: 0.5em;
        }
        .card, .card-img-top {
            border-radius: 1rem !important;
        }
        .text-gradient-blue {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .section-title {
            font-weight: 700;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .card-title {
            font-weight: 600;
        }
        .card-footer {
            border-top: none;
            background: #fff;
        }
        /* Responsive tweaks */
        @media (max-width: 575px) {
            .navbar-brand { font-size: 1.1rem; }
            .section-title { font-size: 1.3rem; }
            .card-title { font-size: 1rem; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="user_dashboard.php">🖥️ Computer Shop BD</a>
        <form class="d-flex ms-auto" method="get" action="">
            <input class="form-control me-2" type="search" placeholder="Search products..." name="q" value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
        <ul class="navbar-nav ms-3">
            <li class="nav-item ms-3">
                <?php
                $subStatus = $conn->query("SELECT * FROM subscriptions WHERE user_id=$uid LIMIT 1");
                if ($subStatus->num_rows > 0) {
                    $row = $subStatus->fetch_assoc();
                    if ($row['status'] === 'approved') {
                        echo '<a class="btn btn-success" href="#">Subscribed</a>';
                    } elseif ($row['status'] === 'pending') {
                        echo '<a class="btn btn-warning text-dark" href="#">Pending</a>';
                    } elseif ($row['status'] === 'rejected') {
                        echo '<a class="btn btn-danger" href="request_subscription.php">Subscribe Again</a>';
                    }
                } else {
                    echo '<a class="btn btn-primary" href="request_subscription.php">Subscribe</a>';
                }
                ?>
            </li>
            <li class="nav-item ms-3">
                <button class="btn btn-danger" onclick="window.location.href='logout.php'">Logout</button>
            </li>
        </ul>
    </div>
</nav>

<!-- Subscriber Sections -->
<?php if ($hasSubscription): ?>
<div class="container mt-4">
    <h3 class="section-title text-center text-gradient-blue">Free Delivery Products</h3>
    <div class="row">
        <?php
        $freeDelivery = $conn->query("SELECT * FROM products WHERE delivery_charge=0 $searchCondition ORDER BY id DESC");
        while ($p = $freeDelivery->fetch_assoc()):
            $discountedPrice = $p['price'] - ($p['price'] * $p['discount'] / 100);
        ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-lg position-relative card-hover-effect">
                <span class="position-absolute top-0 end-0 badge bg-success fs-6 shadow-sm m-3">Free Delivery</span>
                <img src="uploads/<?= $p['photo']; ?>" class="card-img-top rounded-top" style="height:180px;object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold text-primary"><?= htmlspecialchars($p['name']); ?></h5>
                    <p class="text-muted small"><?= htmlspecialchars($p['specification']); ?></p>
                    <div class="mt-3">
                        <?php if ($p['discount'] > 0): ?>
                            <span class="text-muted text-decoration-line-through">৳<?= number_format($p['price'],2); ?></span><br>
                            <span class="fs-5 fw-bold text-success">৳<?= number_format($discountedPrice,2); ?></span>
                            <span class="badge bg-warning text-dark ms-2">-<?= $p['discount']; ?>%</span>
                        <?php else: ?>
                            <span class="fs-5 fw-bold text-dark">৳<?= number_format($p['price'],2); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="product_details.php?id=<?= $p['id']; ?>" class="btn btn-gradient-blue w-100 fw-semibold">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="container mt-4">
    <h3 class="section-title text-center text-gradient-blue">Discounted Products (25%+)</h3>
    <div class="row">
        <?php
        $discounted = $conn->query("SELECT * FROM products WHERE discount >= 25 $searchCondition ORDER BY id DESC");
        while ($p = $discounted->fetch_assoc()):
            $discountedPrice = $p['price'] - ($p['price'] * $p['discount'] / 100);
        ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-lg position-relative card-hover-effect">
                <span class="position-absolute top-0 end-0 badge bg-danger fs-6 shadow-sm m-3">Hot Deal</span>
                <img src="uploads/<?= $p['photo']; ?>" class="card-img-top rounded-top" style="height:180px;object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold text-primary"><?= htmlspecialchars($p['name']); ?></h5>
                    <p class="text-muted small"><?= htmlspecialchars($p['specification']); ?></p>
                    <div class="mt-3">
                        <span class="text-muted text-decoration-line-through">৳<?= number_format($p['price'],2); ?></span><br>
                        <span class="fs-5 fw-bold text-success">৳<?= number_format($discountedPrice,2); ?></span>
                        <span class="badge bg-warning text-dark ms-2">-<?= $p['discount']; ?>%</span>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="product_details.php?id=<?= $p['id']; ?>" class="btn btn-gradient-blue w-100 fw-semibold">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>

<!-- All Products Section -->
<div class="container mt-4">
    <h3 class="section-title text-center text-gradient-blue">All Products</h3>
    <div class="row">
        <?php while ($p = $products->fetch_assoc()): 
            $discountedPrice = $p['price'] - ($p['price'] * $p['discount'] / 100);
        ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-lg position-relative card-hover-effect">
                <?php if ($p['discount'] >= 25): ?>
                    <span class="position-absolute top-0 end-0 badge bg-danger fs-6 shadow-sm m-3">Hot Deal</span>
                <?php elseif ($p['delivery_charge'] == 0): ?>
                    <span class="position-absolute top-0 end-0 badge bg-success fs-6 shadow-sm m-3">Free Delivery</span>
                <?php endif; ?>
                <img src="uploads/<?= $p['photo']; ?>" class="card-img-top rounded-top" style="height:180px;object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold text-primary"><?= htmlspecialchars($p['name']); ?></h5>
                    <p class="text-muted small"><?= htmlspecialchars($p['specification']); ?></p>
                    <div class="mt-3">
                        <?php if ($p['discount'] > 0): ?>
                            <span class="text-muted text-decoration-line-through">৳<?= number_format($p['price'],2); ?></span><br>
                            <span class="fs-5 fw-bold text-success">৳<?= number_format($discountedPrice,2); ?></span>
                            <span class="badge bg-warning text-dark ms-2">-<?= $p['discount']; ?>%</span>
                        <?php else: ?>
                            <span class="fs-5 fw-bold text-dark">৳<?= number_format($p['price'],2); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center">
                    <a href="product_details.php?id=<?= $p['id']; ?>" class="btn btn-gradient-blue w-100 fw-semibold">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
