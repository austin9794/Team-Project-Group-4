-- USERS
INSERT INTO users (name, email, password, role, phone, password_changed)
VALUES
('Bryan Singer', 'BryanS231@gmail.com',
 '$2y$12$6ieDfoEBai1QyKn.w/w7t.nBDvQlzeB214Lbi.M3aJCnsFoc.qIh6', -- admin123
 'admin', '0123456789', 0),

('John Doe', 'johndoe34@gmail.com',
 '$2y$12$9j2iiA.J4z8ewxPT8lPLfOuALEjvO4F0zVHZxPAUu.CJF2pRp7F3y', -- customer456
 'customer', '07891234567', 1),

('Sarah Khan', 'SarahK89@gmail.com',
 '$2a$12$prfqmD/9QZ6.agbibbikJOXPVq0e.5ny1SYAceIIq1.WD6Qvij5hm', -- customer789
 'customer', '07452309761', 1);

-- Insert 5 Categories --

INSERT INTO categories (name, description)
VALUES
('Keyboards', 'Mechanical, wireless, and gaming keyboards'),
('Mice', 'Wired, wireless, and ergonomic mice'),
('Headsets', 'Wired and wireless audio headsets'),
('Monitors', 'Gaming, portable, and 4K monitors'),
('Microphones', 'USB, wireless, and studio microphones');


-- PRODUCTS (25 total)
INSERT INTO products (category_id, name, slug, description, price, stock, low_stock_threshold) VALUES

-- KEYBOARDS (category_id = 1)
(1,'TECKNET RGB Gaming Keyboard', 'keyboard1',
 'Mechanical-feel keyboard with vibrant RGB lighting zones. Features stepped keycaps for ergonomic typing and durable construction ideal for gaming and daily use.',
 32.99, 30, 10),

(1,'CORSAIR K55 RGB PRO', 'keyboard2',
 'Six customisable lighting zones with quiet membrane keys for productivity and gaming. Includes dedicated media controls and spill-resistant design.',
 59.99, 50, 10),

(1,'AULA F75 Wireless Mechanical Keyboard', 'keyboard3',
 'Tri-mode connectivity with Bluetooth, 2.4GHz, and USB-C wired options. Hot-swappable switches and compact 75% layout with enhanced sound dampening.',
 82.99, 40, 10),

(1,'UGREEN Wireless Keyboard', 'keyboard4',
 'Ultra-slim low-profile keyboard supporting Bluetooth and 2.4GHz connections. Can pair with up to three devices, making it perfect for laptops, tablets, and desktops.',
 27.99, 35, 10),

(1,'SteelSeries Apex Pro TKL Gen 3', 'keyboard5',
 'Hall-effect adjustable switches deliver extreme speed and precision. Strong aluminium body and esports-grade performance with deep customization.',
 209.99, 60, 10),

-- MICE (category_id = 2)
(2,'Logitech G305 LIGHTSPEED', 'mouse1',
 'High-accuracy HERO sensor with up to 12,000 DPI. LIGHTSPEED wireless provides low-latency performance and long battery life for gaming and work.',
 59.99, 45, 10),

(2,'Apple Magic Mouse', 'mouse2',
 'Rechargeable Bluetooth mouse with multi-touch surface for intuitive gestures. Sleek, minimal design that glides smoothly across your desk.',
 79.99, 80, 10),
 
(2,'Logitech G502 HERO', 'mouse3',
 '25K DPI sensor for precise tracking and customizable weight tuning. Features 11 programmable buttons for gaming macros or workflow shortcuts.',
 34.99, 55, 10),

(2,'Anker Vertical Ergonomic Mouse', 'mouse4',
 'Ergonomic vertical design that reduces wrist strain during long sessions. Smooth tracking and comfortable grip ideal for work and browsing.',
 23.99, 30, 10),
 
(2,'TECKNET Bluetooth Mouse', 'mouse5',
 'Dual-mode wireless connection via Bluetooth or USB dongle. Side scroll wheel and navigation buttons enhance productivity and web browsing.',
 28.99, 90, 10),

-- HEADSETS (category_id = 3)
(3,'HyperX Cloud Alpha', 'head1',
 'Dual-chamber drivers provide cleaner audio with reduced distortion. Comfortable memory-foam ear cushions and multi-platform compatibility.',
 34.99, 25, 10),

(3,'Vakedy Wireless Gaming Headset', 'head2',
 'Supports Bluetooth and 2.4GHz low-latency wireless modes. Deep bass sound profile and long battery life designed for immersive gaming.',
 149.99, 40, 10),
 
(3,'Jabra Evolve 20', 'head3',
 'Noise-isolating ear cushions for clearer calls and online meetings. Inline controls for easy volume and mute adjustments during classes or work.',
 34.99, 70, 10),

(3,'beyerdynamic DT 990 PRO',  'head4',
 'Professional open-back studio headphones with wide soundstage. Ideal for music production, mixing, and immersive listening sessions.',
 138.99, 15, 10),
 
(3,'JLab Go Work 2nd Gen', 'head5',
 'Wireless headset that connects to two devices simultaneously. Clear-voice microphone with noise reduction and lightweight comfort for long use.',
 49.99, 50, 10),

-- MONITORS (category_id = 4)
(4,'Philips 27E1N1100A 27"', 'monitor1',
 '27-inch Full HD IPS panel with wide viewing angles. Built-in speakers and Flicker-Free technology enhance multimedia and productivity use.',
 94.99, 20, 10),

(4,'ASUS TUF VG279QM1A 280Hz', 'monitor2',
 'Ultra-fast 280Hz refresh rate ideal for competitive gaming. ELMB Sync technology reduces ghosting for sharper, smoother visuals.',
 129.99, 15, 10),
 
(4,'Minifire 27" 180Hz Curved Monitor', 'monitor3',
 'Curved Full HD panel with 180Hz refresh rate for smooth gameplay. Frameless design provides an immersive viewing experience.',
 144.99, 25, 10),

(4,'MSI PRO MP275', 'monitor4',
 '27-inch IPS display with 100Hz refresh rate for everyday work. Delivers crisp colours and wide viewing angles for office and study environments.',
 109.99, 20, 10),
 
(4,'LG 27U411A-B', 'monitor5',
 '27-inch IPS display with HDR10 and VRR support. Produces vivid colours and fast response times for entertainment and casual gaming.',
 89.99, 25, 10),

-- MICROPHONES (category_id = 5)
(5,'TONOR RGB USB Microphone', 'mic1',
 'High-clarity microphone with built-in noise reduction. RGB lighting adds style and enhances gaming or streaming setups.',
 49.99, 30, 10),

(5,'FIFINE XLR/USB Dynamic Microphone', 'mic2',
 'Dual USB and XLR compatibility for flexible studio or gaming use. Warm vocal tone with low noise floor for cleaner recordings.',
 56.99, 75, 10),
 
(5,'UGREEN 24bit/96KHz Condenser Microphone', 'mic3',
 'High-resolution audio capture with crisp detail. Noise-cancelling mode reduces background distractions for clear communication.',
 36.99, 50, 10),
 
(5,'MAONO USB Noise-Cancellation Mic', 'mic4',
 'One-tap noise cancellation removes ambient sounds. Balanced, clean audio suited for meetings, streaming, and gaming.',
 52.99, 18, 10),

(5,'HyperX QuadCast', 'mic5',
 'Premium USB microphone with tap-to-mute, pop filter, and shock mount. Multiple pickup patterns for versatile recording environments.',
 94.99, 60, 10);

-- Product Images

-- HEADSET 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head1/01.png', 1, 1
FROM products WHERE slug = 'head1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head1/02.png', 0, 2
FROM products WHERE slug = 'head1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head1/03.png', 0, 3
FROM products WHERE slug = 'head1';

-- HEADSET 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head2/01.png', 1, 1
FROM products WHERE slug = 'head2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head2/02.png', 0, 2
FROM products WHERE slug = 'head2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head2/03.png', 0, 3
FROM products WHERE slug = 'head2';

-- HEADSET 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head3/01.png', 1, 1
FROM products WHERE slug = 'head3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head3/02.png', 0, 2
FROM products WHERE slug = 'head3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head3/03.png', 0, 3
FROM products WHERE slug = 'head3';

-- HEADSET 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head4/01.png', 1, 1
FROM products WHERE slug = 'head4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head4/02.png', 0, 2
FROM products WHERE slug = 'head4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head4/03.png', 0, 3
FROM products WHERE slug = 'head4';

-- HEADSET 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head5/01.png', 1, 1
FROM products WHERE slug = 'head5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head5/02.png', 0, 2
FROM products WHERE slug = 'head5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/headsets/head5/03.png', 0, 3
FROM products WHERE slug = 'head5';

-- KEYBOARD 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard1/01.png', 1, 1
FROM products WHERE slug = 'keyboard1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)                 
SELECT product_id, 'products/keyboards/keyboard1/02.png', 0, 2
FROM products WHERE slug = 'keyboard1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard1/03.png', 0, 3
FROM products WHERE slug = 'keyboard1';

-- KEYBOARD 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard2/01.png', 1, 1
FROM products WHERE slug = 'keyboard2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard2/02.png', 0, 2
FROM products WHERE slug = 'keyboard2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard2/03.png', 0, 3
FROM products WHERE slug = 'keyboard2';

-- KEYBOARD 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard3/01.png', 1, 1
FROM products WHERE slug = 'keyboard3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard3/02.png', 0, 2
FROM products WHERE slug = 'keyboard3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard3/03.png', 0, 3
FROM products WHERE slug = 'keyboard3'; 

-- KEYBOARD 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard4/01.png', 1, 1
FROM products WHERE slug = 'keyboard4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard4/02.png', 0, 2
FROM products WHERE slug = 'keyboard4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard4/03.png', 0, 3
FROM products WHERE slug = 'keyboard4';

-- KEYBOARD 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard5/01.png', 1, 1
FROM products WHERE slug = 'keyboard5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard5/02.png', 0, 2
FROM products WHERE slug = 'keyboard5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/keyboards/keyboard5/03.png', 0, 3
FROM products WHERE slug = 'keyboard5';

-- MICROPHONE 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic1/01.png', 1, 1
FROM products WHERE slug = 'mic1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic1/02.png', 0, 2
FROM products WHERE slug = 'mic1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic1/03.png', 0, 3
FROM products WHERE slug = 'mic1';

-- MICROPHONE 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic2/01.png', 1, 1
FROM products WHERE slug = 'mic2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic2/02.png', 0, 2
FROM products WHERE slug = 'mic2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic2/03.png', 0, 3
FROM products WHERE slug = 'mic2';

-- MICROPHONE 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic3/01.png', 1, 1
FROM products WHERE slug = 'mic3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic3/02.png', 0, 2
FROM products WHERE slug = 'mic3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic3/03.png', 0, 3
FROM products WHERE slug = 'mic3';

-- MICROPHONE 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic4/01.png', 1, 1
FROM products WHERE slug = 'mic4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic4/02.png', 0, 2
FROM products WHERE slug = 'mic4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic4/03.png', 0, 3
FROM products WHERE slug = 'mic4';

-- MICROPHONE 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic5/01.png', 1, 1
FROM products WHERE slug = 'mic5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic5/02.png', 0, 2
FROM products WHERE slug = 'mic5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/microphones/mic5/03.png', 0, 3
FROM products WHERE slug = 'mic5';

-- MONITOR 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor1/01.png', 1, 1
FROM products WHERE slug = 'monitor1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor1/02.png', 0, 2
FROM products WHERE slug = 'monitor1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor1/03.png', 0, 3
FROM products WHERE slug = 'monitor1';

-- MONITOR 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor2/01.png', 1, 1
FROM products WHERE slug = 'monitor2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor2/02.png', 0, 2
FROM products WHERE slug = 'monitor2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor2/03.png', 0, 3
FROM products WHERE slug = 'monitor2';

-- MONITOR 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor3/01.png', 1, 1
FROM products WHERE slug = 'monitor3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor3/02.png', 0, 2
FROM products WHERE slug = 'monitor3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor3/03.png', 0, 3
FROM products WHERE slug = 'monitor3';

-- MONITOR 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor4/01.png', 1, 1
FROM products WHERE slug = 'monitor4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor4/02.png', 0, 2
FROM products WHERE slug = 'monitor4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor4/03.png', 0, 3
FROM products WHERE slug = 'monitor4';

-- MONITOR 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor5/01.png', 1, 1
FROM products WHERE slug = 'monitor5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor5/02.png', 0, 2
FROM products WHERE slug = 'monitor5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/monitors/monitor5/03.png', 0, 3
FROM products WHERE slug = 'monitor5';

-- MICE 1 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse1/01.png', 1, 1
FROM products WHERE slug = 'mouse1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse1/02.png', 0, 2
FROM products WHERE slug = 'mouse1';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse1/03.png', 0, 3
FROM products WHERE slug = 'mouse1';

-- MICE 2 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse2/01.png', 1, 1
FROM products WHERE slug = 'mouse2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse2/02.png', 0, 2
FROM products WHERE slug = 'mouse2';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse2/03.png', 0, 3
FROM products WHERE slug = 'mouse2';

-- MICE 3 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse3/01.png', 1, 1
FROM products WHERE slug = 'mouse3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse3/02.png', 0, 2
FROM products WHERE slug = 'mouse3';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse3/03.png', 0, 3
FROM products WHERE slug = 'mouse3';

-- MICE 4 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse4/01.png', 1, 1
FROM products WHERE slug = 'mouse4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse4/02.png', 0, 2
FROM products WHERE slug = 'mouse4';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse4/03.png', 0, 3
FROM products WHERE slug = 'mouse4';

-- MICE 5 IMAGES
INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse5/01.png', 1, 1
FROM products WHERE slug = 'mouse5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse5/02.png', 0, 2
FROM products WHERE slug = 'mouse5';

INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
SELECT product_id, 'products/mice/mouse5/03.png', 0, 3
FROM products WHERE slug = 'mouse5';

-- ADDRESSES
INSERT INTO addresses (user_id, full_address, is_default) VALUES
(2, '12 High Street, Birmingham, B1 1AA', 1),
(3, '45 Queen Road, London, E1 6AN', 1);

-- EXAMPLE ORDER
INSERT INTO orders
(user_id, total_price, status, address_id)
VALUES
(2, 32.99, 'pending', 1),
(3, 149.99, 'processing', 2),
(2, 24.99, 'shipped', 1);


INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
VALUES
(1, 1, 1, 32.99),
(2, 3, 1, 39.99),
(3, 2, 1, 149.99);


-- REVIEWS
INSERT INTO reviews (product_id, user_id, rating, comment)
VALUES
(1, 2, 5, 'Excellent feel and nice to use!'),
(3, 1, 4, 'Good sound quality.');

-- INVENTORY LOGS
INSERT INTO inventory_logs
(product_id, change_amount, action, admin_id)
VALUES
(1, -1, 'purchase', 1),
(2, -1, 'purchase', 1),
(2, 10, 'restock', 1),
(3, -5, 'manual_adjust', 1);
