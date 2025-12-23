<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tour_id = $_POST['tour_id'];
    $booking_date = $_POST['booking_date'];
    $participants = $_POST['participants'];
    $special_requests = $_POST['special_requests'];

    // Calculate total price
    $stmt = $pdo->prepare("SELECT price FROM tours WHERE id = ?");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();
    $total_price = $tour['price'] * $participants;

    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, tour_id, booking_date, participants, total_price, special_requests) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $tour_id, $booking_date, $participants, $total_price, $special_requests]);

    header("Location: my_bookings.php");
    exit;
}

// Get tour details
$stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->execute([$_GET['id']]);
$tour = $stmt->fetch();

if (!$tour) {
    header("Location: tour_world.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Tour</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }
        .gallery-img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .tour-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .tour-summary h3 {
            color: #4fd1c5;
            margin-bottom: 10px;
        }
        .price-breakdown {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">Tour Management</div>
            <nav>
                <ul>
                    <li><a href="tour_world.php">Tours</a></li>
                    <li><a href="my_bookings.php">My Bookings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Book <?= htmlspecialchars($tour['name']) ?></h2>

            <div class="tour-summary">
                <div class="tour-img" style="background-image: url('<?= htmlspecialchars($tour['image_url']) ?>'); height: 200px; border-radius: 10px;"></div>
                <h3><?= htmlspecialchars($tour['name']) ?></h3>
                <p><strong>Location:</strong> <?= htmlspecialchars($tour['location']) ?></p>
                <p><strong>Duration:</strong> <?= htmlspecialchars($tour['duration']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($tour['description']) ?></p>

                <?php
                $additional_images = json_decode($tour['additional_images'], true);
                if (!empty($additional_images)): ?>
                    <div class="image-gallery">
                        <?php foreach ($additional_images as $img): ?>
                            <img src="<?= htmlspecialchars($img) ?>" alt="Tour image" class="gallery-img">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="price-breakdown">
                    <h4>Price: $<?= number_format($tour['price'], 2) ?> per person</h4>
                    <p><strong>Available Slots:</strong> <?= htmlspecialchars($tour['available_slots']) ?> / <?= htmlspecialchars($tour['capacity']) ?></p>
                </div>
            </div>

            <form method="POST" action="" id="bookingForm">
                <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">

                <div class="form-group">
                    <label>Booking Date</label>
                    <input type="date" name="booking_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label>Number of Participants</label>
                    <input type="number" name="participants" class="form-control" required min="1" max="<?= $tour['available_slots'] ?>" value="1">
                </div>

                <div class="form-group">
                    <label>Special Requests (Optional)</label>
                    <textarea name="special_requests" class="form-control" rows="3" placeholder="Any special requirements or notes..."></textarea>
                </div>

                <div class="price-breakdown">
                    <h4>Total Price: $<span id="totalPrice"><?= number_format($tour['price'], 2) ?></span></h4>
                </div>

                <button type="submit" class="btn">Confirm Booking</button>
                <a href="tour_world.php" class="btn btn-outline">Cancel</a>
            </form>
        </div>
    </div>

    <script>
        // Update total price when participants change
        document.querySelector('input[name="participants"]').addEventListener('input', function() {
            const participants = parseInt(this.value) || 1;
            const pricePerPerson = <?= $tour['price'] ?>;
            const totalPrice = participants * pricePerPerson;
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
        });
    </script>
</body>
</html>