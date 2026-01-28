-- =====================================================
-- Team Project E-Commerce Platform - Seed Data
-- =====================================================

-- =====================================================
-- ADMIN USERS
-- =====================================================
INSERT INTO `tp_users` (`username`, `email`, `password_hash`, `first_name`, `last_name`, `role`, `is_active`, `is_verified`) VALUES
('admin', 'admin@teamproject.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DXo4FG', 'Admin', 'User', 'admin', TRUE, TRUE),
('staff', 'staff@teamproject.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DXo4FG', 'Staff', 'Member', 'staff', TRUE, TRUE);

-- =====================================================
-- TEST CUSTOMER USERS
-- =====================================================
INSERT INTO `tp_users` (`username`, `email`, `password_hash`, `first_name`, `last_name`, `phone`, `address`, `city`, `postal_code`, `country`, `role`, `is_active`, `is_verified`) VALUES
('john_doe', 'john@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DXo4FG', 'John', 'Doe', '+44 123 456 7890', '123 Main Street', 'London', 'SW1A 1AA', 'United Kingdom', 'customer', TRUE, TRUE),
('jane_smith', 'jane@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DXo4FG', 'Jane', 'Smith', '+44 234 567 8901', '456 Oak Avenue', 'Manchester', 'M1 1AE', 'United Kingdom', 'customer', TRUE, TRUE),
('mike_wilson', 'mike@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DXo4FG', 'Mike', 'Wilson', '+44 345 678 9012', '789 Pine Road', 'Birmingham', 'B1 1AA', 'United Kingdom', 'customer', TRUE, TRUE);

-- =====================================================
-- PRODUCT CATEGORIES
-- =====================================================
INSERT INTO `tp_categories` (`name`, `slug`, `description`, `display_order`, `is_active`) VALUES
('Electronics', 'electronics', 'Electronic devices and gadgets', 1, TRUE),
('Clothing', 'clothing', 'Apparel and fashion items', 2, TRUE),
('Books', 'books', 'Physical and digital books', 3, TRUE),
('Home & Garden', 'home-garden', 'Furniture and home improvement', 4, TRUE),
('Sports & Outdoors', 'sports-outdoors', 'Sports equipment and outdoor gear', 5, TRUE);

-- =====================================================
-- PRODUCTS - ELECTRONICS
-- =====================================================
INSERT INTO `tp_products` (`name`, `slug`, `description`, `price`, `cost`, `category`, `sku`, `quantity_in_stock`, `min_stock_level`, `is_active`, `is_featured`, `created_by`) VALUES
('Wireless Headphones', 'wireless-headphones', 'Premium noise-cancelling wireless headphones with 30-hour battery life', 89.99, 35.00, 'Electronics', 'ELEC-001', 50, 10, TRUE, TRUE, 1),
('USB-C Cable 3-Pack', 'usb-c-cable-3pack', 'High-quality USB-C charging cables, 3 meters each', 24.99, 8.00, 'Electronics', 'ELEC-002', 120, 20, TRUE, FALSE, 1),
('Portable Phone Charger', 'portable-phone-charger', '20000mAh portable charger with fast charging', 39.99, 15.00, 'Electronics', 'ELEC-003', 75, 10, TRUE, TRUE, 1),
('LED Desk Lamp', 'led-desk-lamp', 'Adjustable LED lamp with USB charging port', 34.99, 12.00, 'Electronics', 'ELEC-004', 40, 5, TRUE, FALSE, 1),
('Webcam 1080p', 'webcam-1080p', 'Full HD webcam with built-in microphone', 49.99, 18.00, 'Electronics', 'ELEC-005', 30, 5, TRUE, FALSE, 1);

-- =====================================================
-- PRODUCTS - CLOTHING
-- =====================================================
INSERT INTO `tp_products` (`name`, `slug`, `description`, `price`, `cost`, `category`, `sku`, `quantity_in_stock`, `min_stock_level`, `is_active`, `is_featured`) VALUES
('Premium T-Shirt', 'premium-tshirt', '100% organic cotton comfortable t-shirt', 19.99, 6.00, 'Clothing', 'CLOTH-001', 200, 30, TRUE, TRUE),
('Jeans Blue', 'jeans-blue', 'Classic blue denim jeans, all sizes available', 49.99, 18.00, 'Clothing', 'CLOTH-002', 150, 20, TRUE, FALSE),
('Winter Jacket', 'winter-jacket', 'Warm and waterproof winter jacket', 129.99, 50.00, 'Clothing', 'CLOTH-003', 60, 10, TRUE, TRUE),
('Casual Sneakers', 'casual-sneakers', 'Comfortable everyday sneakers', 69.99, 25.00, 'Clothing', 'CLOTH-004', 80, 15, TRUE, FALSE);

-- =====================================================
-- PRODUCTS - BOOKS
-- =====================================================
INSERT INTO `tp_products` (`name`, `slug`, `description`, `price`, `cost`, `category`, `sku`, `quantity_in_stock`, `min_stock_level`, `is_active`, `is_featured`) VALUES
('Learning PHP Design Patterns', 'learning-php-design-patterns', 'Comprehensive guide to PHP design patterns', 34.99, 10.00, 'Books', 'BOOK-001', 45, 5, TRUE, FALSE),
('Web Development with MySQL', 'web-development-mysql', 'Master database design with MySQL', 44.99, 15.00, 'Books', 'BOOK-002', 38, 5, TRUE, TRUE),
('JavaScript Mastery', 'javascript-mastery', 'Advanced JavaScript techniques and best practices', 39.99, 12.00, 'Books', 'BOOK-003', 52, 10, TRUE, FALSE);

-- =====================================================
-- PRODUCTS - HOME & GARDEN
-- =====================================================
INSERT INTO `tp_products` (`name`, `slug`, `description`, `price`, `cost`, `category`, `sku`, `quantity_in_stock`, `min_stock_level`, `is_active`, `is_featured`) VALUES
('Coffee Table', 'coffee-table', 'Modern wooden coffee table with storage', 199.99, 80.00, 'Home & Garden', 'HOME-001', 25, 5, TRUE, FALSE),
('Bed Sheets Set', 'bed-sheets-set', 'Luxury Egyptian cotton bed sheets, king size', 79.99, 25.00, 'Home & Garden', 'HOME-002', 60, 10, TRUE, TRUE),
('Kitchen Knife Set', 'kitchen-knife-set', '5-piece stainless steel knife set', 89.99, 30.00, 'Home & Garden', 'HOME-003', 35, 5, TRUE, FALSE);

-- =====================================================
-- INVENTORY
-- =====================================================
INSERT INTO `tp_inventory` (`product_id`, `quantity_available`, `quantity_reserved`, `warehouse_location`) VALUES
(1, 50, 0, 'A-101'),
(2, 120, 5, 'B-202'),
(3, 75, 10, 'A-103'),
(4, 40, 3, 'C-304'),
(5, 30, 2, 'A-105'),
(6, 200, 15, 'B-206'),
(7, 150, 8, 'C-307'),
(8, 60, 5, 'A-208'),
(9, 80, 12, 'B-309'),
(10, 45, 0, 'C-310'),
(11, 38, 2, 'A-211'),
(12, 52, 8, 'B-312'),
(13, 25, 3, 'C-313'),
(14, 60, 6, 'A-314'),
(15, 35, 4, 'B-315');

-- =====================================================
-- SAMPLE ORDER
-- =====================================================
INSERT INTO `tp_orders` (`order_number`, `user_id`, `subtotal`, `tax_amount`, `shipping_cost`, `total_amount`, `status`, `payment_method`, `payment_status`, `shipping_address`, `billing_address`, `notes`) VALUES
('ORD-001-2024', 3, 139.98, 27.99, 10.00, 177.97, 'processing', 'credit_card', 'completed', '123 Main Street, London, SW1A 1AA', '123 Main Street, London, SW1A 1AA', 'Please deliver on weekday');

-- =====================================================
-- SAMPLE ORDER ITEMS
-- =====================================================
INSERT INTO `tp_order_items` (`order_id`, `product_id`, `quantity`, `unit_price`, `line_total`) VALUES
(1, 1, 1, 89.99, 89.99),
(1, 2, 1, 24.99, 24.99),
(1, 3, 1, 39.99, 39.99);

-- =====================================================
-- SAMPLE REVIEWS
-- =====================================================
INSERT INTO `tp_reviews` (`product_id`, `user_id`, `order_id`, `rating`, `title`, `review_text`, `is_verified_purchase`, `is_published`) VALUES
(1, 3, 1, 5, 'Excellent headphones!', 'These headphones are fantastic! Sound quality is amazing and they are very comfortable for extended use.', TRUE, TRUE),
(2, 3, 1, 4, 'Good quality cables', 'Durable cables, work as expected. Good value for money.', TRUE, TRUE),
(3, 2, NULL, 4, 'Great power bank', 'Fast charging and good build quality. Highly recommend.', FALSE, TRUE);

-- =====================================================
-- APPLICATION SETTINGS
-- =====================================================
INSERT INTO `tp_settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Team Project E-Commerce'),
('site_email', 'info@teamproject.local'),
('currency', 'GBP'),
('tax_rate', '0.20'),
('shipping_threshold', '50.00'),
('items_per_page', '12'),
('max_upload_size', '5242880');

-- =====================================================
-- END OF SEED DATA
-- =====================================================

-- Note: Password hash is for 'password123'
-- To generate new hashes, use: password_hash('your_password', PASSWORD_BCRYPT)