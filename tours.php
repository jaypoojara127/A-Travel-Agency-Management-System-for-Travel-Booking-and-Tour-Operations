<?php
require 'config.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
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

    $stmt = $pdo->prepare("INSERT INTO tours (name, location, price, description, image_url, additional_images, duration, capacity, available_slots, itinerary, inclusions, exclusions, amenities) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $location, $price, $description, $image_url, json_encode($additional_images), $duration, $capacity, $available_slots, $itinerary, $inclusions, $exclusions, $amenities]);

    $_SESSION['success'] = "Tour added successfully!";
    header("Location: tours.php");
    exit;
}

// Get all tours
$tours = $pdo->query("SELECT * FROM tours ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Tours</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .gallery-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .tour-details {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .tour-details h4 {
            margin-bottom: 10px;
            color: #4fd1c5;
        }
        .tour-details p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Tours</h2>

    <div class="admin-actions">
        <button class="btn" onclick="document.getElementById('add-tour').style.display='block'">Add New Tour</button>
    </div>

    <div id="add-tour" class="modal" style="display:none;">
        <div class="modal-content" style="max-width: 800px;">
            <span class="close" onclick="document.getElementById('add-tour').style.display='none'">&times;</span>
            <h3>Add New Tour</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Tour Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" required>
                </div>
                <div class="form-group">
                    <label>Price per Person ($)</label>
                    <input type="number" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Duration</label>
                    <input type="text" name="duration" placeholder="e.g., 3 Days 2 Nights" required>
                </div>
                <div class="form-group">
                    <label>Capacity</label>
                    <input type="number" name="capacity" required>
                </div>
                <div class="form-group">
                    <label>Available Slots</label>
                    <input type="number" name="available_slots" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Main Image URL</label>
                    <input type="text" name="image_url" placeholder="https://example.com/image.jpg" required>
                </div>
                <div class="form-group">
                    <label>Additional Images (one URL per line)</label>
                    <textarea name="additional_images" rows="4" placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg&#10;https://example.com/image3.jpg"></textarea>
                </div>
                <div class="form-group">
                    <label>Itinerary</label>
                    <textarea name="itinerary" rows="4" placeholder="Day 1: Description&#10;Day 2: Description"></textarea>
                </div>
                <div class="form-group">
                    <label>Inclusions</label>
                    <textarea name="inclusions" rows="3" placeholder="Accommodation, Meals, Guide, Transportation"></textarea>
                </div>
                <div class="form-group">
                    <label>Exclusions</label>
                    <textarea name="exclusions" rows="3" placeholder="International flights, Personal expenses, Travel insurance"></textarea>
                </div>
                <div class="form-group">
                    <label>Amenities</label>
                    <textarea name="amenities" rows="2" placeholder="Professional Guide, Camping Equipment, Meals"></textarea>
                </div>
                <button type="submit" class="btn">Add Tour</button>
            </form>
        </div>
    </div>

    <div class="tours-list">
        <?php foreach ($tours as $tour): ?>
            <div class="tour-card">
                <div class="tour-img" style="background-image: url('<?= $tour['image_url'] ?: 'https://images.unsplash.com/photo-1464822759844-d150f39ac1ac?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' ?>')"></div>
                <div class="tour-info">
                    <h3><?= htmlspecialchars($tour['name']) ?></h3>
                    <p><strong>Location:</strong> <?= htmlspecialchars($tour['location']) ?></p>
                    <p><strong>Duration:</strong> <?= htmlspecialchars($tour['duration']) ?></p>
                    <p><strong>Capacity:</strong> <?= htmlspecialchars($tour['capacity']) ?> (<?= htmlspecialchars($tour['available_slots']) ?> available)</p>
                    <p>$<?= number_format($tour['price'], 2) ?> per person</p>
                    <p><?= htmlspecialchars($tour['description']) ?></p>

                    <?php
                    $additional_images = json_decode($tour['additional_images'], true);
                    if (!empty($additional_images)): ?>
                        <div class="image-gallery">
                            <?php foreach ($additional_images as $img): ?>
                                <img src="<?= htmlspecialchars($img) ?>" alt="Tour image" class="gallery-img">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="tour-details">
                        <?php if (!empty($tour['itinerary'])): ?>
                            <h4>Itinerary</h4>
                            <p><?= nl2br(htmlspecialchars($tour['itinerary'])) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($tour['inclusions'])): ?>
                            <h4>Inclusions</h4>
                            <p><?= nl2br(htmlspecialchars($tour['inclusions'])) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($tour['exclusions'])): ?>
                            <h4>Exclusions</h4>
                            <p><?= nl2br(htmlspecialchars($tour['exclusions'])) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($tour['amenities'])): ?>
                            <h4>Amenities</h4>
                            <p><?= nl2br(htmlspecialchars($tour['amenities'])) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="tour-actions">
                        <a href="edit_tour.php?id=<?= $tour['id'] ?>" class="btn">Edit</a>
                        <a href="delete_tour.php?id=<?= $tour['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this tour?')">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
}
</script>
</body>
</html>