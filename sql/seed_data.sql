-- USERS
INSERT INTO users (name, email, password, role, phone, address)
VALUES
('Bryan Singer', 'BryanS231@gmail.com',
 '$2y$12$6ieDfoEBai1QyKn.w/w7t.nBDvQlzeB214Lbi.M3aJCnsFoc.qIh6', -- admin123
 'admin', '0123456789', '456 Admin Street'),

('John Doe', 'johndoe34@gmail.com',
 '$2y$12$9j2iiA.J4z8ewxPT8lPLfOuALEjvO4F0zVHZxPAUu.CJF2pRp7F3y', -- customer456
 'customer', '07891234567', '123 Example Road');


-- Insert 5 Categories --

INSERT INTO categories (name, description)
VALUES
('Keyboards', 'Mechanical, wireless, and gaming keyboards'),
('Mice', 'Wired, wireless, and ergonomic mice'),
('Headsets', 'Wired and wireless audio headsets'),
('Monitors', 'Gaming, portable, and 4K monitors'),
('Microphones', 'USB, wireless, and studio microphones');


-- PRODUCTS (25 total)
INSERT INTO products (category_id, name, description, price, stock) VALUES
-- KEYBOARDS (category_id = 1)
(1,'TECKNET RGB Gaming Keyboard',
 'Mechanical-feel keyboard with vibrant RGB lighting zones. Features stepped keycaps for ergonomic typing and durable construction ideal for gaming and daily use.',
 32.99,'keyboard1.png',30),

(1,'CORSAIR K55 RGB PRO',
 'Six customisable lighting zones with quiet membrane keys for productivity and gaming. Includes dedicated media controls and spill-resistant design.',
 59.99,'keyboard2.png',50),

(1,'AULA F75 Wireless Mechanical Keyboard',
 'Tri-mode connectivity with Bluetooth, 2.4GHz, and USB-C wired options. Hot-swappable switches and compact 75% layout with enhanced sound dampening.',
 82.99,'keyboard3.png',40),

(1,'UGREEN Wireless Keyboard',
 'Ultra-slim low-profile keyboard supporting Bluetooth and 2.4GHz connections. Can pair with up to three devices, making it perfect for laptops, tablets, and desktops.',
 27.99,'keyboard4.png',35),

(1,'SteelSeries Apex Pro TKL Gen 3',
 'Hall-effect adjustable switches deliver extreme speed and precision. Strong aluminium body and esports-grade performance with deep customization.',
 209.99,'keyboard5.png',60),

-- MICE (category_id = 2)
(2,'Logitech G305 LIGHTSPEED',
 'High-accuracy HERO sensor with up to 12,000 DPI. LIGHTSPEED wireless provides low-latency performance and long battery life for gaming and work.',
 59.99,'mouse1.png',45),

(2,'Apple Magic Mouse',
 'Rechargeable Bluetooth mouse with multi-touch surface for intuitive gestures. Sleek, minimal design that glides smoothly across your desk.',
 79.99,'mouse2.png',80),

(2,'Logitech G502 HERO',
 '25K DPI sensor for precise tracking and customizable weight tuning. Features 11 programmable buttons for gaming macros or workflow shortcuts.',
 34.99,'mouse3.png',55),

(2,'Anker Vertical Ergonomic Mouse',
 'Ergonomic vertical design that reduces wrist strain during long sessions. Smooth tracking and comfortable grip ideal for work and browsing.',
 23.99,'mouse4.png',30),

(2,'TECKNET Bluetooth Mouse',
 'Dual-mode wireless connection via Bluetooth or USB dongle. Side scroll wheel and navigation buttons enhance productivity and web browsing.',
 28.99,'mouse5.png',90),

-- HEADSETS (category_id = 3)
(3,'HyperX Cloud Alpha',
 'Dual-chamber drivers provide cleaner audio with reduced distortion. Comfortable memory-foam ear cushions and multi-platform compatibility.',
 34.99,'head1.png',25),

(3,'Vakedy Wireless Gaming Headset',
 'Supports Bluetooth and 2.4GHz low-latency wireless modes. Deep bass sound profile and long battery life designed for immersive gaming.',
 149.99,'head2.png',40),

(3,'Jabra Evolve 20',
 'Noise-isolating ear cushions for clearer calls and online meetings. Inline controls for easy volume and mute adjustments during classes or work.',
 34.99,'head3.png',70),

(3,'beyerdynamic DT 990 PRO',
 'Professional open-back studio headphones with wide soundstage. Ideal for music production, mixing, and immersive listening sessions.',
 138.99,'head4.png',15),

(3,'JLab Go Work 2nd Gen',
 'Wireless headset that connects to two devices simultaneously. Clear-voice microphone with noise reduction and lightweight comfort for long use.',
 49.99,'head5.png',50),

-- MONITORS (category_id = 4)
(4,'Philips 27E1N1100A 27"',
 '27-inch Full HD IPS panel with wide viewing angles. Built-in speakers and Flicker-Free technology enhance multimedia and productivity use.',
 94.99,'mon1.png',20),

(4,'ASUS TUF VG279QM1A 280Hz',
 'Ultra-fast 280Hz refresh rate ideal for competitive gaming. ELMB Sync technology reduces ghosting for sharper, smoother visuals.',
 129.99,'mon2.png',15),

(4,'Minifire 27" 180Hz Curved Monitor',
 'Curved Full HD panel with 180Hz refresh rate for smooth gameplay. Frameless design provides an immersive viewing experience.',
 144.99,'mon3.png',25),

(4,'MSI PRO MP275',
 '27-inch IPS display with 100Hz refresh rate for everyday work. Delivers crisp colours and wide viewing angles for office and study environments.',
 109.99,'mon4.png',10),

(4,'LG 27U411A-B',
 '27-inch IPS display with HDR10 and VRR support. Produces vivid colours and fast response times for entertainment and casual gaming.',
 89.99,'mon5.png',12),

-- MICROPHONES (category_id = 5)
(5,'TONOR RGB USB Microphone',
 'High-clarity microphone with built-in noise reduction. RGB lighting adds style and enhances gaming or streaming setups.',
 49.99,'mic1.png',30),

(5,'FIFINE XLR/USB Dynamic Microphone',
 'Dual USB and XLR compatibility for flexible studio or gaming use. Warm vocal tone with low noise floor for cleaner recordings.',
 56.99,'mic2.png',75),

(5,'UGREEN 24bit/96KHz Condenser Microphone',
 'High-resolution audio capture with crisp detail. Noise-cancelling mode reduces background distractions for clear communication.',
 36.99,'mic3.png',50),

(5,'MAONO USB Noise-Cancellation Mic',
 'One-tap noise cancellation removes ambient sounds. Balanced, clean audio suited for meetings, streaming, and gaming.',
 52.99,'mic4.png',18),

(5,'HyperX QuadCast',
 'Premium USB microphone with tap-to-mute, pop filter, and shock mount. Multiple pickup patterns for versatile recording environments.',
 94.99,'mic5.png',60);


-- EXAMPLE ORDER
INSERT INTO orders (user_id, total_price, status)
VALUES
(2, 72.99, 'delivered');

INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
VALUES
(1, 1, 1, 32.99),
(1, 3, 1, 39.99);


-- REVIEWS
INSERT INTO reviews (product_id, user_id, rating, comment)
VALUES
(1, 2, 5, 'Excellent feel and nice to use!'),
(3, 1, 4, 'Good sound quality.');

-- INVENTORY LOGS
INSERT INTO inventory_logs (product_id, change_amount, action)
VALUES
(1, -1, 'purchase'),
(3, -1, 'purchase'),
(1, 10, 'restock');
