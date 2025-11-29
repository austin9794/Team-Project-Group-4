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


-- Insert 25 Products (5 per category) --

-- CATEGORY 1 — KEYBOARDS (category_id = 1)
INSERT INTO products (category_id, name, description, price, image, stock)
VALUES
(1, 'TECKNET RGB Gaming Keyboard', 'Experience mechanical feel hand comfort with TECKNET RGB gaming keyboard including scientific stepped keycap design and ergonomic typing angle', 32.99, 'keyboard1.jpg', 30),
(1, 'CORSAIR K55 RGB PRO Membrane Wired Gaming Keyboard', 'Light up your desktop with six onboard lighting effects, assign a colour to each lighting zone, or program your own vibrant lighting effects ', 59.99, 'keyboard2.jpg', 50),
(1, 'AULA F75 75% Wireless Mechanical Keyboard', 'AULA F75 wireless mechanical keyboard supports suitable for Bluetooth, 2.4GHz wireless and USB wired connection, can connect up to five devices at the same time, and easily switch by shortcut keys or side button', 82.99, 'keyboard3.jpg', 40),
(1, 'UGREEN Wireless and Bluetooth Keyboard', 'UGREEN wireless keyboard supports bluetooth and 2.4GHz USB connection. You can easily switch modes and connect the keyboard to up to 3 devices at the same time, such as laptop, PC and tablet. ', 27.99, 'keyboard4.jpg', 35),
(1, 'SteelSeries Apex Pro TKL Gen 3 - Gaming Keyboard', 'THE FASTEST KEYBOARD IN THE WORLD — More than just fast, our newly redesigned Hall Effect Switch have 20x faster actuation and 11x quicker response time, with 40 levels of adjustable actuation.', 209.99, 'keyboard5.jpg', 60);

-- CATEGORY 2 — MICE (category_id = 2)
INSERT INTO products (category_id, name, description, price, image, stock)
VALUES
(2, 'Logitech G305 LIGHTSPEED Wireless Gaming Mouse', 'Next-gen HERO mouse sensor delivers up to 10x the power efficiency over other gaming mice with exceptional accuracy and responsiveness thanks to 400 IPS precision and up to 12000 DPI sensitivity ', 59.99, 'mouse1.jpg', 45),
(2, 'Apple Magic Mouse: Bluetooth, rechargeable.', 'Magic Mouse is wireless and rechargeable, with an optimised foot design that lets it glide smoothly across your desk. ', 79.99, 'mouse2.jpg', 80),
(2, 'Logitech G G502 HERO High Performance Wired Gaming Mouse', 'The next generation of the HERO optical sensor brings new precision to your mouse at up to 25,600 DPI while generating no smoothing, filtering or acceleration. USB report rate: 1000 Hz (1 ms) ', 34.99, 'mouse3.jpg', 55),
(2, 'Anker 2.4G Wireless Vertical Ergonomic Optical Mouse', 'Scientific ergonomic design encourages healthy neutral "handshake" wrist and arm positions for smoother movement and less overall strain. ', 23.99, 'mouse4.jpg', 30),
(2, 'TECKNET Bluetooth Mouse, Wireless Mouse with Thumb Scroll', 'This wireless mouse for laptop features a side scroll wheel for efficient horizontal scrolling, along with forward and backward buttons for quickly switching between pages or returning to the previous page, making web browsing and document editing effortless. ', 28.99, 'mouse5.jpg', 90);

-- CATEGORY 3 — HEADSETS (category_id = 3)
INSERT INTO products (category_id, name, description, price, image, stock)
VALUES
(3, 'HyperX Cloud Alpha Gaming Headset with In-line volume control ', 'HyperX Dual Chamber Drivers for more distinction and less distortion. Multi-platform compatibility (on PC, PS4, PS5, Xbox One, Xbox Series X|S)  ', 34.99, 'headset1.jpg', 25),
(3, 'Vakedy Wireless Gaming Headset, 2.4GHz USB & Bluetooth Gaming Headphones', 'This wireless gaming headset offers 2 versatile connection modes: 2.4GHz USB dongle and Bluetooth 5.4, both ensuring stable, delay performance. 2.4GHz USB wireless mode is compatible with PC, PS4, PS5, laptops, Mac, and Switch (', 149.99, 'headset2.jpg', 40),
(3, 'Jabra Evolve 20 Stereo Headset', 'Passive noise cancellation for ideal concentration: Keeps high-frequency noise such as human voices out for better work collaboration and listening experience in any environment ', 34.99, 'headset3.jpg', 70),
(3, 'beyerdynamic DT 990 PRO Over-Ear Studio Monitor Headphones', 'Open Over-Ear headphones for professional mixing, mastering, editing, and listening at home or in the studio ', 138.99, 'headset4.jpg', 15),
(3, 'JLab Go Work 2nd Gen Wireless Headsets with Microphone', 'Connect the wireless headset via USB-C dongle or Bluetooth 5.3 to your PC, Mac, office computer, mobile and more. Or plug-in the included Type-C to Type-C cable for wired laptop headphones with microphone. Connect to 2 devices simultaneously', 49.99, 'headset5.jpg', 50);

-- CATEGORY 4 — MONITORS (category_id = 4)
INSERT INTO products (category_id, name, description, price, image, stock)
VALUES
(4, 'Philips 27E1N1100A - 27 Inch FHD Monitor', ' Built-in stereo speakers for multimedia. HDMI ensures universal digital connectivity. LowBlue mode and Flicker-free easy-on-the eyes viewing ', 94.99, 'monitor1.jpg', 20),
(4, 'ASUS TUF Gaming VG279QM1A Gaming Monitor – 27-inch, Full HD(1920x1080), 280Hz(OC)', 'High-performance 1440p gaming monitor with 144Hz refresh rate and 1ms response time.ASUS Extreme Low Motion Blur Sync (ELMB Sync) technology enables ELMB and variable-refresh-rate technologies to work simultaneously to eliminate ghosting and tearing for sharp gaming visuals with high frame rates.', 129.99, 'monitor2.jpg', 15),
(4, 'Minifire 27 Inch Gaming Monitor, 180Hz, Curved Gaming Monitor', ' Immerse yourself in FHD 1080P clarity with a 180Hz refresh rate, delivering buttery-smooth gameplay and cinematic visuals. Perfect for competitive gaming and multitasking. ', 144.99, 'monitor3.jpg', 25),
(4, 'MSI PRO MP275 27 Inch Full HD Office Monitor', '27-INCH FHD PANEL - The PRO MP275 features a large 27-inch IPS panel with Full-HD (1920x1080) resolution; A high 100Hz refresh rate improves the day-to-day visual experience with smoother, faster frame rates ', 109.99, 'monitor4.jpg', 10),
(4, 'LG Monitor 27U411A-B - FHD 1080p IPS 27 inch, 120 Hz, 5ms GtG, Computer desktop display with VRR, HDR10', 'Brilliant Image Quality in Full HD IPS Display – The 27-inch Full HD (1920x1080) IPS Display with sRGB 99% colour gamut & HDR10 that reproduces vivd colours and detailed images ', 89.99, 'monitor5.jpg', 12);

-- CATEGORY 5 — MICROPHONES (category_id = 5)
INSERT INTO products (category_id, name, description, price, image, stock)
VALUES
(5, 'TONOR Gaming USB Microphone with Adjustable RGB Modes & Brightness', 'The TC310+ gaming mic equiped premium chips and core, coupled with expert tuning by engineers, resulting in ultra-low noise levels and a pure, clean sound. It delivers crystal-clear clarity and full-bodied sound, providing high-fidelity reproduction that brings your recordings to life', 49.99, 'mic1.jpg', 30),
(5, 'FIFINE XLR/USB Gaming Microphone, Studio Dynamic Streaming Mic', ' Featured with high accuracy and decent transmission performance, the XLR dynamic microphone worked with frequency response range of 50Hz-16KHz presents transparent, open and authentic vocal voice. Due to studio recording mic with S/N Ratio more than 80dB', 56.99, 'mic2.jpg', 75),
(5, 'UGREEN USB Microphone 24bit/96KHz RGB Gaming Mic Cardioid Condenser PC Microphone', 'This condenser microphone operates at a high resolution up to 24bit/96kHz. This USB streaming mic captures voice with a rich tone, natural, ensuring your vocals sound full and detailed without compressed. In addition, the noise-cancelling mode can effectively reduces background noise such as keyboard clacking, mouse clicks, or general room hum, ensuring that your voice remains the focus', 36.99, 'mic3.jpg', 50),
(5, 'MAONO Gaming USB Microphone, Noise Cancellation Condenser Mic ', 'This gaming microphone with one-click noise cancellation technology, which can effectively eliminate background noise. Whether multiplayer online games, cooperative games, or competitive games, the USB microphone can capture voices clearly, thereby enhancing the collaboration and competitiveness of the game. ', 52.99, 'mic4.jpg', 18),
(5, 'HyperX QuadCast – Standalone Microphone for streamers, content creators and gamers', ' QuadCast includes a built-in anti-vibration shock mount, internal pop filter, and an adapter for most stands. Quickly check mic status with the LED indicator, and tap-to-mute to prevent audio accidents ', 94.99, 'mic5.jpg', 60);


-- EXAMPLE ORDER
INSERT INTO orders (user_id, total_price, status)
VALUES
(2, 72.99, 'delivered');

INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase)
VALUES
(1, 1, 1, 32.99),
(1, 3, 1, 39.99);


-- Example Reviews --

INSERT INTO reviews (product_id, user_id, rating, comment)
VALUES
(1, 2, 5, 'Excellent feel and nice to use!'),
(3, 1, 4, 'Good sound quality.');


-- Example Inventory Logs --

INSERT INTO inventory_logs (product_id, change_amount, action)
VALUES
(1, -1, 'purchase'),
(3, -1, 'purchase'),
(1, +10, 'restock');
