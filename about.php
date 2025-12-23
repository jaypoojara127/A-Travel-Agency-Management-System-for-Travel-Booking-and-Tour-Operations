<?php
require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>About Us - Tour Management</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .about-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .about-header {
            text-align: center;
            margin-bottom: 50px;
            padding-bottom: 20px;
            border-bottom: 1px solid #334155;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .about-content {
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid #4fd1c5;
        }

        .about-image {
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid #4fd1c5;
            text-align: center;
        }

        .about-image img {
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 60px;
        }

        .stat-card {
            background: #1e293b;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #4fd1c5;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #4fd1c5;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #94a3b8;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .team-section {
            margin-bottom: 60px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .team-member {
            background: #1e293b;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #4fd1c5;
        }

        .team-photo {
            width: 100px;
            height: 100px;
            background: #4fd1c5;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
        }

        .mission-section {
            background: #1e293b;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #4fd1c5;
        }

        .mission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .mission-item {
            padding: 20px;
        }

        .mission-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .about-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
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
        <div class="about-container">
            <div class="about-header">
                <h2>🏢 About Tour World</h2>
                <p>Your trusted partner in creating unforgettable travel experiences</p>
            </div>

            <div class="about-grid">
                <div class="about-content">
                    <h3>Our Story</h3>
                    <p>Founded in 2010, Tour World has been at the forefront of adventure travel, connecting travelers with extraordinary destinations around the globe. What started as a small team of passionate explorers has grown into a leading travel agency, serving thousands of satisfied customers each year.</p>

                    <p>We believe that travel is not just about visiting new places—it's about creating memories, forging connections, and discovering the beauty of our diverse world. Our experienced team of travel consultants works tirelessly to craft personalized experiences that cater to every traveler's unique preferences and dreams.</p>

                    <p>From breathtaking mountain treks to luxurious beach getaways, cultural explorations to wildlife adventures, we offer a comprehensive range of tours designed to suit every type of traveler. Our commitment to excellence, safety, and sustainability has made us a trusted name in the travel industry.</p>
                </div>

                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828" alt="Travel Adventure" style="width: 100%; max-width: 400px;">
                    <p>Creating unforgettable travel experiences since 2010</p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">10,000+</div>
                    <div class="stat-label">Happy Travelers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Destinations</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4.9/5</div>
                    <div class="stat-label">Customer Rating</div>
                </div>
            </div>

            <div class="mission-section">
                <h3 style="text-align: center; margin-bottom: 20px;">Our Mission & Values</h3>
                <div class="mission-grid">
                    <div class="mission-item">
                        <div class="mission-icon">🎯</div>
                        <h4>Excellence</h4>
                        <p>We strive for excellence in every aspect of our service, from trip planning to execution.</p>
                    </div>
                    <div class="mission-item">
                        <div class="mission-icon">🌍</div>
                        <h4>Sustainability</h4>
                        <p>We're committed to responsible tourism that preserves destinations for future generations.</p>
                    </div>
                    <div class="mission-item">
                        <div class="mission-icon">🤝</div>
                        <h4>Personalization</h4>
                        <p>Every journey is unique, and we tailor experiences to match your individual preferences.</p>
                    </div>
                    <div class="mission-item">
                        <div class="mission-icon">🛡️</div>
                        <h4>Safety First</h4>
                        <p>Your safety and security are our top priorities throughout your entire journey.</p>
                    </div>
                </div>
            </div>

            <div class="team-section">
                <h3 style="text-align: center; margin-bottom: 30px;">Meet Our Team</h3>
                <div class="team-grid">
                    <div class="team-member">
                        <div class="team-photo">👨‍💼</div>
                        <h4>Sarah Johnson</h4>
                        <p>Founder & CEO</p>
                        <p>15+ years in adventure travel</p>
                    </div>
                    <div class="team-member">
                        <div class="team-photo">👩‍💼</div>
                        <h4>Mike Chen</h4>
                        <p>Head of Operations</p>
                        <p>Expert in logistics & planning</p>
                    </div>
                    <div class="team-member">
                        <div class="team-photo">👨‍🏫</div>
                        <h4>David Rodriguez</h4>
                        <p>Senior Travel Consultant</p>
                        <p>Specializes in cultural tours</p>
                    </div>
                    <div class="team-member">
                        <div class="team-photo">👩‍🎨</div>
                        <h4>Emma Thompson</h4>
                        <p>Customer Experience Manager</p>
                        <p>Dedicated to your satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>