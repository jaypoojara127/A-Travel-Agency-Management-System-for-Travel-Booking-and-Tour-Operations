<?php
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Get tour details
$stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->execute([$_GET['id']]);
$tour = $stmt->fetch();

if (!$tour) {
    header("Location: tours.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']);
    $duration = trim($_POST['duration']);
    $capacity = trim($_POST['capacity']);
    $available_slots = trim($_POST['available_slots']);
    $itinerary = trim($_POST['itinerary']);
    $inclusions = trim($_POST['inclusions']);
    $exclusions = trim($_POST['exclusions']);
    $amenities = trim($_POST['amenities']);

    // Handle additional images
    $additional_images = [];
    if (!empty($_POST['additional_images'])) {
        $additional_images = array_filter(array_map('trim', explode("\n", $_POST['additional_images'])));
    }

    $stmt = $pdo->prepare("UPDATE tours SET name = ?, location = ?, price = ?, description = ?, image_url = ?, additional_images = ?, duration = ?, capacity = ?, available_slots = ?, itinerary = ?, inclusions = ?, exclusions = ?, amenities = ? WHERE id = ?");
    $stmt->execute([$name, $location, $price, $description, $image_url, json_encode($additional_images), $duration, $capacity, $available_slots, $itinerary, $inclusions, $exclusions, $amenities, $tour['id']]);

    $_SESSION['success'] = "Tour updated successfully!";
    header("Location: tours.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tour</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .current-images {
            margin-top: 10px;
        }
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .gallery-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Tour</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label>Tour Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($tour['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($tour['location']) ?>" required>
        </div>
        <div class="form-group">
            <label>Price per Person ($)</label>
            <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($tour['price']) ?>" required>
        </div>
        <div class="form-group">
            <label>Duration</label>
            <input type="text" name="duration" value="<?= htmlspecialchars($tour['duration']) ?>" placeholder="e.g., 3 Days 2 Nights" required>
        </div>
        <div class="form-group">
            <label>Capacity</label>
            <input type="number" name="capacity" value="<?= htmlspecialchars($tour['capacity']) ?>" required>
        </div>
        <div class="form-group">
            <label>Available Slots</label>
            <input type="number" name="available_slots" value="<?= htmlspecialchars($tour['available_slots']) ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" required><?= htmlspecialchars($tour['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Main Image URL</label>
            <input type="text" name="image_url" value="<?= htmlspecialchars($tour['image_url']) ?>" placeholder="https://example.com/image.jpg" required>
        </div>
        <div class="form-group">
            <label>Additional Images (one URL per line)</label>
            <textarea name="additional_images" rows="4" placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg&#10;https://example.com/image3.jpg"><?php
                $additional_images = json_decode($tour['additional_images'], true);
                if (!empty($additional_images)) {
                    echo implode("\n", $additional_images);
                }
            ?></textarea>
            <?php if (!empty($additional_images)): ?>
                <div class="current-images">
                    <label>Current Additional Images:</label>
                    <div class="image-gallery">
                        <?php foreach ($additional_images as $img): ?>
                            <img src="<?= htmlspecialchars($img) ?>" alt="Tour image" class="gallery-img">
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Itinerary</label>
            <textarea name="itinerary" rows="4" placeholder="Day 1: Description&#10;Day 2: Description"><?= htmlspecialchars($tour['itinerary']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Inclusions</label>
            <textarea name="inclusions" rows="3" placeholder="Accommodation, Meals, Guide, Transportation"><?= htmlspecialchars($tour['inclusions']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Exclusions</label>
            <textarea name="exclusions" rows="3" placeholder="International flights, Personal expenses, Travel insurance"><?= htmlspecialchars($tour['exclusions']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Amenities</label>
            <textarea name="amenities" rows="2" placeholder="Professional Guide, Camping Equipment, Meals"><?= htmlspecialchars($tour['amenities']) ?></textarea>
        </div>
        <button type="submit" class="btn">Update Tour</button>
        <a href="tours.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>