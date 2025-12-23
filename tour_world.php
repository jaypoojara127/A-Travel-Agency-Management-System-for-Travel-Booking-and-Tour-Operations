<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Get all tours with sample data if empty
$stmt = $pdo->query("SELECT * FROM tours");
$tours = $stmt->fetchAll();

// If no tours, insert sample data
if (empty($tours)) {
    $sampleTours = [
        [
            'name' => 'Mountain Adventure Trek',
            'location' => 'Himalayan Foothills, Nepal',
            'description' => 'Experience the breathtaking beauty of the Himalayas with our guided mountain trek',
            'price' => 450.00,
            'image_url' => 'https://images.unsplash.com/photo-1464822759844-d150f39ac1ac',
            'additional_images' => '["https://images.unsplash.com/photo-1558618666-fcd25c85cd64", "https://images.unsplash.com/photo-1506905925346-21bda4d32df4"]',
            'duration' => '5 Days 4 Nights',
            'capacity' => 15,
            'available_slots' => 8,
            'itinerary' => 'Day 1: Arrival and acclimatization\nDay 2-4: Trekking through mountain trails\nDay 5: Return journey',
            'inclusions' => 'Accommodation, Meals, Guide, Permits, Transportation',
            'exclusions' => 'Personal expenses, Travel insurance, Beverages',
            'amenities' => 'Professional Guide, Camping Equipment, Meals, Transportation'
        ],
        [
            'name' => 'Beach Paradise Getaway',
            'location' => 'Maldives Islands',
            'description' => 'Relax in luxury overwater bungalows with crystal clear waters',
            'price' => 1200.00,
            'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4',
            'additional_images' => '["https://images.unsplash.com/photo-1573843981267-be1999ff37cd", "https://images.unsplash.com/photo-1540541338287-41700207dee6"]',
            'duration' => '7 Days 6 Nights',
            'capacity' => 20,
            'available_slots' => 12,
            'itinerary' => 'Day 1-2: Island hopping and relaxation\nDay 3-5: Water activities and excursions\nDay 6-7: Leisure time and departure',
            'inclusions' => 'Accommodation, Meals, Airport transfers, Water sports equipment',
            'exclusions' => 'International flights, Personal expenses, Gratuities',
            'amenities' => 'Overwater Bungalow, Spa Access, Water Sports, All Meals'
        ],
        [
            'name' => 'Cultural Heritage Tour',
            'location' => 'Ancient Cities, India',
            'description' => 'Explore the rich cultural heritage and historical monuments of India',
            'price' => 350.00,
            'image_url' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da',
            'additional_images' => '["https://images.unsplash.com/photo-1587135941948-670b381f08ce", "https://images.unsplash.com/photo-1524492412937-b28074a5d7da"]',
            'duration' => '6 Days 5 Nights',
            'capacity' => 25,
            'available_slots' => 15,
            'itinerary' => 'Day 1: Delhi arrival and city tour\nDay 2-3: Agra and Taj Mahal\nDay 4-5: Jaipur exploration\nDay 6: Departure',
            'inclusions' => 'Hotel accommodation, Meals, Guide, Entrance fees, Transportation',
            'exclusions' => 'International flights, Personal expenses, Camera fees',
            'amenities' => 'Expert Guide, Entrance Fees, Transportation, Accommodation'
        ]
    ];

    foreach ($sampleTours as $tour) {
        $stmt = $pdo->prepare("INSERT INTO tours (name, location, description, price, image_url, additional_images, duration, capacity, available_slots, itinerary, inclusions, exclusions, amenities) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$tour['name'], $tour['location'], $tour['description'], $tour['price'], $tour['image_url'], $tour['additional_images'], $tour['duration'], $tour['capacity'], $tour['available_slots'], $tour['itinerary'], $tour['inclusions'], $tour['exclusions'], $tour['amenities']]);
    }

    // Refresh tours list
    $stmt = $pdo->query("SELECT * FROM tours");
    $tours = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tour World</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
        }
        .gallery-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .gallery-thumb:hover {
            transform: scale(1.1);
        }
        .tour-details {
            margin-top: 10px;
            font-size: 14px;
        }
        .tour-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
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
        <h1>Available Tours</h1>

        <div class="tour-grid">
            <?php foreach ($tours as $tour): ?>
            <div class="tour-card">
                <div class="tour-img" style="background-image: url('<?= htmlspecialchars($tour['image_url']) ?>')"></div>
                <div class="tour-info">
                    <h3><?= htmlspecialchars($tour['name']) ?></h3>
                    <div class="tour-meta">
                        <span><strong>📍</strong> <?= htmlspecialchars($tour['location']) ?></span>
                        <span><strong>⏱️</strong> <?= htmlspecialchars($tour['duration']) ?></span>
                    </div>
                    <p><?= htmlspecialchars($tour['description']) ?></p>

                    <?php
                    $additional_images = json_decode($tour['additional_images'], true);
                    if (!empty($additional_images)): ?>
                        <div class="image-gallery">
                            <?php foreach (array_slice($additional_images, 0, 4) as $img): ?>
                                <img src="<?= htmlspecialchars($img) ?>" alt="Tour image" class="gallery-thumb" onclick="window.open('<?= htmlspecialchars($img) ?>', '_blank')">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="tour-details">
                        <p><strong>Capacity:</strong> <?= htmlspecialchars($tour['capacity']) ?> (<?= htmlspecialchars($tour['available_slots']) ?> available)</p>
                        <?php if (!empty($tour['inclusions'])): ?>
                            <p><strong>Includes:</strong> <?= htmlspecialchars(substr($tour['inclusions'], 0, 100)) ?>...</p>
                        <?php endif; ?>
                    </div>

                    <p class="tour-price">$<?= number_format($tour['price'], 2) ?> per person</p>
                    <a href="book_tour.php?id=<?= $tour['id'] ?>" class="btn">Book Now</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>