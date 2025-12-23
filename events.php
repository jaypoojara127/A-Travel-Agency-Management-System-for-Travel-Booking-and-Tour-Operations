<?php
require 'config.php';

// Sample events data - in a real application, this would come from a database
$events = [
    [
        'id' => 1,
        'title' => 'Travel Photography Workshop',
        'date' => '2025-01-15',
        'time' => '10:00 AM - 4:00 PM',
        'location' => 'Central Park, New York',
        'description' => 'Learn professional photography techniques from expert photographers. Capture stunning travel moments and improve your photography skills.',
        'image' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d',
        'price' => 75,
        'capacity' => 25,
        'available' => 12,
        'category' => 'Workshop'
    ],
    [
        'id' => 2,
        'title' => 'Adventure Travel Meetup',
        'date' => '2025-01-22',
        'time' => '7:00 PM - 9:00 PM',
        'location' => 'Adventure Hub, Downtown',
        'description' => 'Connect with fellow adventure enthusiasts. Share travel stories, get tips, and plan your next adventure.',
        'image' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9',
        'price' => 0,
        'capacity' => 50,
        'available' => 35,
        'category' => 'Networking'
    ],
    [
        'id' => 3,
        'title' => 'Cultural Exchange Dinner',
        'date' => '2025-02-05',
        'time' => '6:30 PM - 10:00 PM',
        'location' => 'Global Cuisine Restaurant',
        'description' => 'Experience world cuisines while connecting with travelers from different cultures. A night of food, stories, and friendship.',
        'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0',
        'price' => 45,
        'capacity' => 40,
        'available' => 28,
        'category' => 'Social'
    ],
    [
        'id' => 4,
        'title' => 'Sustainable Travel Seminar',
        'date' => '2025-02-12',
        'time' => '2:00 PM - 5:00 PM',
        'location' => 'Green Building Conference Center',
        'description' => 'Learn about eco-friendly travel practices, responsible tourism, and how to minimize your environmental impact while traveling.',
        'image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09',
        'price' => 25,
        'capacity' => 60,
        'available' => 45,
        'category' => 'Educational'
    ],
    [
        'id' => 5,
        'title' => 'Winter Hiking Expedition',
        'date' => '2025-02-20',
        'time' => '8:00 AM - 6:00 PM',
        'location' => 'Mountain Base Camp',
        'description' => 'Join our guided winter hiking adventure. Experience snowy trails, learn winter survival skills, and enjoy breathtaking mountain views.',
        'image' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256',
        'price' => 120,
        'capacity' => 15,
        'available' => 8,
        'category' => 'Adventure'
    ],
    [
        'id' => 6,
        'title' => 'Travel Writing Workshop',
        'date' => '2025-03-01',
        'time' => '11:00 AM - 3:00 PM',
        'location' => 'Creative Arts Center',
        'description' => 'Discover the art of travel writing. Learn to craft compelling stories about your adventures and get published.',
        'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570',
        'price' => 60,
        'capacity' => 20,
        'available' => 15,
        'category' => 'Workshop'
    ]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Events - Tour Management</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .events-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .events-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #334155;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .event-card {
            background: #1e293b;
            border-radius: 12px;
            overflow: hidden;
            border-left: 4px solid #4fd1c5;
            transition: transform 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-5px);
        }

        .event-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .event-category {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #4fd1c5;
            color: #1a2a3a;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .event-content {
            padding: 20px;
        }

        .event-title {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .event-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
            color: #94a3b8;
        }

        .event-description {
            color: #cbd5e1;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .event-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .event-price {
            font-size: 20px;
            font-weight: bold;
            color: #4fd1c5;
        }

        .event-capacity {
            font-size: 12px;
            color: #94a3b8;
        }

        .event-actions {
            display: flex;
            gap: 10px;
        }

        .btn-primary {
            background: #4fd1c5;
            color: #1a2a3a;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #38b2ac;
        }

        .btn-secondary {
            background: #334155;
            color: #ffffff;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .filter-section {
            background: #1e293b;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 4px solid #4fd1c5;
        }

        .filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-btn {
            background: #334155;
            color: #ffffff;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #4fd1c5;
            color: #1a2a3a;
        }

        @media (max-width: 768px) {
            .events-grid {
                grid-template-columns: 1fr;
            }

            .event-meta {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">Tour Management</div>
            <nav>
                <ul>
                    <li><a href="welcome.php">Home</a></li>
                    <li><a href="tour_world.php">Tours</a></li>
                    <li><a href="my_bookings.php">My Bookings</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="events.php">Events</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="events-container">
            <div class="events-header">
                <h2>🎉 Upcoming Events</h2>
                <p>Join our exciting travel events and workshops</p>
            </div>

            <div class="filter-section">
                <h3>Filter by Category</h3>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-category="all">All Events</button>
                    <button class="filter-btn" data-category="workshop">Workshops</button>
                    <button class="filter-btn" data-category="networking">Networking</button>
                    <button class="filter-btn" data-category="social">Social</button>
                    <button class="filter-btn" data-category="educational">Educational</button>
                    <button class="filter-btn" data-category="adventure">Adventure</button>
                </div>
            </div>

            <div class="events-grid">
                <?php foreach ($events as $event): ?>
                <div class="event-card" data-category="<?= strtolower($event['category']) ?>">
                    <div class="event-image" style="background-image: url('<?= htmlspecialchars($event['image']) ?>')">
                        <span class="event-category"><?= htmlspecialchars($event['category']) ?></span>
                    </div>
                    <div class="event-content">
                        <h3 class="event-title"><?= htmlspecialchars($event['title']) ?></h3>
                        <div class="event-meta">
                            <span>📅 <?= date('M j, Y', strtotime($event['date'])) ?></span>
                            <span>📍 <?= htmlspecialchars($event['location']) ?></span>
                        </div>
                        <div class="event-meta">
                            <span>🕒 <?= htmlspecialchars($event['time']) ?></span>
                        </div>
                        <p class="event-description"><?= htmlspecialchars(substr($event['description'], 0, 100)) ?>...</p>
                        <div class="event-details">
                            <div class="event-price">
                                <?php if ($event['price'] == 0): ?>
                                    FREE
                                <?php else: ?>
                                    $<?= number_format($event['price'], 2) ?>
                                <?php endif; ?>
                            </div>
                            <div class="event-capacity">
                                <?= $event['available'] ?>/<?= $event['capacity'] ?> spots left
                            </div>
                        </div>
                        <div class="event-actions">
                            <a href="#" class="btn-primary">Register Now</a>
                            <a href="#" class="btn-secondary">Learn More</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Simple filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');

                const category = button.dataset.category;
                const events = document.querySelectorAll('.event-card');

                events.forEach(event => {
                    if (category === 'all' || event.dataset.category === category) {
                        event.style.display = 'block';
                    } else {
                        event.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>