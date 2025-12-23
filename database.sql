-- Tour Management System Database Setup
-- File: database.sql

-- Create the database
CREATE DATABASE IF NOT EXISTS tour_management;
USE tour_management;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    email VARCHAR(100),
    full_name VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tours table
CREATE TABLE IF NOT EXISTS tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    additional_images TEXT, -- JSON array of additional image URLs
    amenities TEXT,
    duration VARCHAR(50), -- e.g., "3 days 2 nights"
    capacity INT,
    available_slots INT,
    itinerary TEXT,
    inclusions TEXT,
    exclusions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tour Images table for multiple images
CREATE TABLE IF NOT EXISTS tour_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tour_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    alt_text VARCHAR(255),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tour_id INT NOT NULL,
    booking_date DATE NOT NULL,
    participants INT DEFAULT 1,
    status VARCHAR(20) DEFAULT 'pending',
    total_price DECIMAL(10,2),
    payment_status VARCHAR(20) DEFAULT 'unpaid',
    special_requests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Payments table (optional extension)
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100),
    status VARCHAR(20) DEFAULT 'pending',
    payment_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Reviews table (optional extension)
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tour_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert initial admin user
INSERT INTO users (username, password, role, email, full_name)
VALUES ('admin', '$2y$10$2ryNEpUvEdkqiajCs.u.zesDClMnLjYOmg0K5Yu0ehE/yyc0aw1Em', 'admin', 'admin@tourworld.com', 'System Administrator');

-- Insert sample tours
INSERT INTO tours (name, location, description, price, image_url, additional_images, amenities, duration, capacity, available_slots, itinerary, inclusions, exclusions)
VALUES
('Mountain Adventure Trek', 'Himalayan Foothills, Nepal', 'Experience the breathtaking beauty of the Himalayas with our guided mountain trek', 450.00, 'https://images.unsplash.com/photo-1464822759844-d150f39ac1ac', '["https://images.unsplash.com/photo-1558618666-fcd25c85cd64", "https://images.unsplash.com/photo-1506905925346-21bda4d32df4", "https://images.unsplash.com/photo-1464207687429-7505649dae38"]', 'Professional Guide, Camping Equipment, Meals, Transportation', '5 Days 4 Nights', 15, 8, 'Day 1: Arrival and acclimatization\nDay 2-4: Trekking through mountain trails\nDay 5: Return journey', 'Accommodation, Meals, Guide, Permits, Transportation', 'Personal expenses, Travel insurance, Beverages'),
('Beach Paradise Getaway', 'Maldives Islands', 'Relax in luxury overwater bungalows with crystal clear waters', 1200.00, 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4', '["https://images.unsplash.com/photo-1573843981267-be1999ff37cd", "https://images.unsplash.com/photo-1540541338287-41700207dee6", "https://images.unsplash.com/photo-1439066615861-d1af74d74000"]', 'Overwater Bungalow, Spa Access, Water Sports, All Meals', '7 Days 6 Nights', 20, 12, 'Day 1-2: Island hopping and relaxation\nDay 3-5: Water activities and excursions\nDay 6-7: Leisure time and departure', 'Accommodation, Meals, Airport transfers, Water sports equipment', 'International flights, Personal expenses, Gratuities'),
('Cultural Heritage Tour', 'Ancient Cities, India', 'Explore the rich cultural heritage and historical monuments of India', 350.00, 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da', '["https://images.unsplash.com/photo-1587135941948-670b381f08ce", "https://images.unsplash.com/photo-1524492412937-b28074a5d7da", "https://images.unsplash.com/photo-1524492412937-b28074a5d7da"]', 'Expert Guide, Entrance Fees, Transportation, Accommodation', '6 Days 5 Nights', 25, 15, 'Day 1: Delhi arrival and city tour\nDay 2-3: Agra and Taj Mahal\nDay 4-5: Jaipur exploration\nDay 6: Departure', 'Hotel accommodation, Meals, Guide, Entrance fees, Transportation', 'International flights, Personal expenses, Camera fees'),
('African Safari Adventure', 'Serengeti National Park, Tanzania', 'Witness the great migration and wildlife in their natural habitat', 800.00, 'https://images.unsplash.com/photo-1516426122078-c23e76319801', '["https://images.unsplash.com/photo-1547471080-9cc3966067e8", "https://images.unsplash.com/photo-1535941339077-2dd1c7963098", "https://images.unsplash.com/photo-1516426122078-c23e76319801"]', 'Safari Guide, Game Drives, Camping Equipment, Meals', '5 Days 4 Nights', 12, 6, 'Day 1: Arrival and safari briefing\nDay 2-4: Game drives and wildlife viewing\nDay 5: Departure', 'Accommodation, Meals, Guide, Park fees, Transportation', 'International flights, Travel insurance, Personal expenses'),
('Paris Romantic Escape', 'Paris, France', 'Discover the City of Light with its iconic landmarks and cuisine', 600.00, 'https://images.unsplash.com/photo-1502602898536-47ad22581b52', '["https://images.unsplash.com/photo-1511739001486-6bfe10ce785f", "https://images.unsplash.com/photo-1549144511-f099e773c147", "https://images.unsplash.com/photo-1509439581779-6298f75bf6e5"]', 'City Guide, Museum Tickets, Seine River Cruise, Meals', '4 Days 3 Nights', 20, 10, 'Day 1: Eiffel Tower and Champs-Élysées\nDay 2: Louvre Museum and Notre-Dame\nDay 3: Versailles Palace\nDay 4: Montmartre and departure', 'Hotel accommodation, Breakfast, Guide, Entrance fees', 'International flights, Lunch/Dinner, Personal expenses'),
('Bali Island Paradise', 'Bali, Indonesia', 'Experience tropical beaches, volcanoes, and rich culture', 550.00, 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1', '["https://images.unsplash.com/photo-1518548419970-58e3b4079ab2", "https://images.unsplash.com/photo-1573790387438-4da905039392", "https://images.unsplash.com/photo-1537953773345-d172ccf13cf1"]', 'Beach Resort, Spa Access, Cultural Shows, Meals', '6 Days 5 Nights', 18, 9, 'Day 1-2: Beach relaxation in Seminyak\nDay 3: Ubud cultural tour\nDay 4: Mount Batur sunrise trek\nDay 5-6: Leisure and departure', 'Accommodation, Meals, Airport transfers, Cultural activities', 'International flights, Travel insurance, Gratuities'),
('Grand Canyon Expedition', 'Arizona, USA', 'Explore one of the world\'s most spectacular natural wonders', 400.00, 'https://images.unsplash.com/photo-1615551043360-33de8b5f410c', '["https://images.unsplash.com/photo-1464207687429-7505649dae38", "https://images.unsplash.com/photo-1558618666-fcd25c85cd64", "https://images.unsplash.com/photo-1615551043360-33de8b5f410c"]', 'Hiking Guide, Camping Equipment, Meals, Transportation', '4 Days 3 Nights', 15, 7, 'Day 1: Arrival and rim exploration\nDay 2: Hiking trails\nDay 3: Colorado River rafting\nDay 4: Departure', 'Accommodation, Meals, Guide, Park permits', 'Airfare, Personal expenses, Travel insurance'),
('Tokyo Modern Culture', 'Tokyo, Japan', 'Immerse yourself in futuristic technology and traditional culture', 700.00, 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf', '["https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e", "https://images.unsplash.com/photo-1542051841857-5f90071e7989", "https://images.unsplash.com/photo-1540959733332-eab4deabeeaf"]', 'City Guide, Train Passes, Temple Visits, Meals', '5 Days 4 Nights', 22, 11, 'Day 1: Shibuya and Harajuku\nDay 2: Imperial Palace and Asakusa\nDay 3: Mount Fuji day trip\nDay 4: Akihabara and electronics\nDay 5: Departure', 'Hotel accommodation, Meals, Guide, Transportation', 'International flights, Personal expenses, Shopping'),
('Amazon Rainforest Journey', 'Amazon Basin, Brazil', 'Discover the biodiversity of the world\'s largest rainforest', 650.00, 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e', '["https://images.unsplash.com/photo-1506905925346-21bda4d32df4", "https://images.unsplash.com/photo-1558618666-fcd25c85cd64", "https://images.unsplash.com/photo-1441974231531-c6227db76b6e"]', 'Jungle Guide, Canoe Trips, Wildlife Viewing, Meals', '6 Days 5 Nights', 10, 5, 'Day 1: Arrival and jungle lodge\nDay 2-4: Canoe expeditions and hiking\nDay 5: Indigenous village visit\nDay 6: Departure', 'Accommodation, Meals, Guide, Permits', 'International flights, Travel insurance, Personal expenses'),
('Northern Lights Quest', 'Reykjavik, Iceland', 'Chase the aurora borealis in the land of fire and ice', 900.00, 'https://images.unsplash.com/photo-1539635278303-d4002c07eae3', '["https://images.unsplash.com/photo-1506905925346-21bda4d32df4", "https://images.unsplash.com/photo-1464207687429-7505649dae38", "https://images.unsplash.com/photo-1539635278303-d4002c07eae3"]', 'Aurora Guide, Northern Lights Tours, Geothermal Spa, Meals', '5 Days 4 Nights', 16, 8, 'Day 1: Reykjavik exploration\nDay 2: Golden Circle tour\nDay 3: South Coast waterfalls\nDay 4: Northern Lights hunt\nDay 5: Departure', 'Accommodation, Meals, Guide, Transportation', 'International flights, Travel insurance, Gratuities');