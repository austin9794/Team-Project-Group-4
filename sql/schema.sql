-- Ensure safe mode
SET FOREIGN_KEY_CHECKS = 0;

-- Users Table --

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('customer','admin') DEFAULT 'customer',
  phone VARCHAR(20),

  password_changed BOOLEAN DEFAULT 0,
  last_login TIMESTAMP NULL,

  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Adresses Table --

CREATE TABLE addresses (
  address_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,

  label VARCHAR(50) NOT NULL,

  full_name VARCHAR(100) NOT NULL,
  address_line1 VARCHAR(150) NOT NULL,
  address_line2 VARCHAR(150) NULL,
  city VARCHAR(100) NOT NULL,
  county VARCHAR(100) NULL,
  postcode VARCHAR(20) NOT NULL,
  country VARCHAR(50) NOT NULL DEFAULT 'United Kingdom',

  is_default BOOLEAN DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);



-- Payment Table --

CREATE TABLE payment_methods (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    card_brand VARCHAR(20),
    card_last4 VARCHAR(4),
    expiry_month INT,
    expiry_year INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_default BOOLEAN DEFAULT 0,

    FOREIGN KEY (user_id) REFERENCES users(user_id) 
    ON DELETE CASCADE
);

-- Categories Table --

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);


-- Products Table --

CREATE TABLE products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,

  low_stock_threshold INT DEFAULT 10,
  is_active BOOLEAN DEFAULT 1,

  category_id INT NOT NULL,
  slug VARCHAR(150) UNIQUE,

  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (category_id) REFERENCES categories(category_id)
);


-- Index for faster category filtering
CREATE INDEX idx_products_category
    ON products(category_id);


-- Product Images Table --

CREATE TABLE product_images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT 0,
    sort_order INT DEFAULT 1,

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_product_images_product
    ON product_images(product_id);

-- Orders Table --

CREATE TABLE orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,

  status ENUM( 'pending',
    'processing',
    'shipped',
    'delivered',
    'returned'
  ) DEFAULT 'pending',

  address_id INT NULL,
  payment_id INT NULL,

  processed_at TIMESTAMP NULL,
  shipped_at TIMESTAMP NULL,
  delivered_at TIMESTAMP NULL,

  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  shipping_address TEXT NOT NULL,
  payment_summary VARCHAR(100) NOT NULL,

  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (address_id) REFERENCES addresses(address_id),
  FOREIGN KEY (payment_id) REFERENCES payment_methods(payment_id)
);


-- Forms --
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE INDEX idx_orders_user
    ON orders(user_id);


-- Order Items Table --

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_purchase DECIMAL(10,2) NOT NULL,
    returned_quantity INT DEFAULT 0,

    FOREIGN KEY (order_id)
        REFERENCES orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    UNIQUE (order_id, product_id)
);


-- Reviews Table --

CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating TINYINT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    order_item_id INT NOT NULL AFTER product_id,

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (order_item_id)
       REFERENCES order_items(order_item_id)
       ON DELETE CASCADE
       ON UPDATE CASCADE, 

    FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_reviews_product
    ON reviews(product_id);


-- Returns Table --

CREATE TABLE returns (
    return_id INT AUTO_INCREMENT PRIMARY KEY,

    order_id INT NOT NULL,
    order_item_id INT NOT NULL,
    user_id INT NOT NULL,

    quantity INT NOT NULL,
    reason VARCHAR(255),

    status ENUM('pending', 'approved', 'rejected', 'refunded')
           DEFAULT 'pending',

    requested_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    processed_at DATETIME NULL,

    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (order_item_id) REFERENCES order_items(order_item_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


-- Iventory Log Table (For Reports and Alerts) --

CREATE TABLE inventory_logs (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,

  change_amount INT NOT NULL,
  action ENUM(
    'restock',
    'purchase',
    'return',
    'manual_adjust'
  ) NOT NULL,

  admin_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (product_id) REFERENCES products(product_id),
  FOREIGN KEY (admin_id) REFERENCES users(user_id)
    ON DELETE SET NULL
);


CREATE INDEX idx_inventory_product
    ON inventory_logs(product_id);


-- Aadmin Activity Log Table --

CREATE TABLE admin_actions (
  action_id INT AUTO_INCREMENT PRIMARY KEY,
  admin_id INT NOT NULL,

  action_type VARCHAR(50) NOT NULL,
  description TEXT,

  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (admin_id) REFERENCES users(user_id)
);

SET FOREIGN_KEY_CHECKS = 1;
