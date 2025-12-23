<?php
require 'config.php';

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message_content = trim($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message_content)) {
        $message = "All fields are required.";
        $messageType = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "error";
    } else {
        // In a real application, you would send an email or save to database
        // For now, we'll just show a success message
        $message = "Thank you for contacting us! We'll get back to you soon.";
        $messageType = "success";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Tour Management</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .contact-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #334155;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .contact-info {
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid #4fd1c5;
        }

        .contact-form {
            background: #1e293b;
            padding: 30px;
            border-radius: 12px;
            border-left: 4px solid #4fd1c5;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: #4fd1c5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #94a3b8;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #334155;
            border-radius: 6px;
            background: #0f172a;
            color: #ffffff;
            font-size: 14px;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: #4fd1c5;
            color: #1a2a3a;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: #38b2ac;
        }

        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-success {
            background: #10b981;
            color: #ffffff;
        }

        .alert-error {
            background: #ef4444;
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 20px;
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
        <div class="contact-container">
            <div class="contact-header">
                <h2>📞 Contact Us</h2>
                <p>Get in touch with our travel experts</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Get In Touch</h3>
                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div>
                            <strong>Address</strong><br>
                            123 Travel Street<br>
                            Adventure City, AC 12345
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div>
                            <strong>Phone</strong><br>
                            +1 (555) 123-4567
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">✉️</div>
                        <div>
                            <strong>Email</strong><br>
                            info@tourworld.com
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">🕒</div>
                        <div>
                            <strong>Business Hours</strong><br>
                            Mon - Fri: 9:00 AM - 6:00 PM<br>
                            Sat: 10:00 AM - 4:00 PM
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <h3>Send us a Message</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>