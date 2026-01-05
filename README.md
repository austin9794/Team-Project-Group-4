## **Level Up Gaming – E-Commerce Platform**
A full-stack PHP & MySQL e-commerce web application developed as part of the CS2 Team Project.
The platform allows customers to browse products, manage accounts, place orders, and interact with a professional shopping basket and checkout flow.

##  Project Overview

**Business Domain:** Online Gaming Accessories 

**Target Audience:** Casual and competitive gamers looking for keyboards, mice, headsets, monitors, and microphones

**Project Goal:** Replace an outdated system with a modern, database-driven e-commerce website featuring secure authentication, product browsing, and order management.

## Core Features

**Customer Features**

- User registration, login, and logout

- Product browsing with categories and search

- Detailed product pages with pricing and stock status

- Shopping basket with:

   - Quantity adjustment

   - Item removal

   - Live total updates


- Dummy checkout flow

- Order placement and order history

- “My Account” section:

   - Personal details

   - Saved delivery addresses

   - Saved payment methods


- Fully functional Contact Us form (stored in database)


**UI / UX**

- Consistent brand identity (logo, colour scheme, typography)

- Responsive layout across pages

- Light/Dark mode toggle

- Clear navigation and feedback messages


## Tech Stack

- **Backend:** PHP (MVC-style routing via index.php)

- **Frontend:** HTML, CSS, JavaScript

- **Database:** MySQL (PDO)

- **Version Control:** GitHub

- **Server:** University-hosted PHP/MySQL environment

## How to Run the Project Locally

Prerequisites

- XAMPP / MAMP / WAMP

- PHP 8+

- MySQL

- Web browser

1. Clone the repository:
   ```bash
    https://github.com/austin9794/Team-Project-Group-4.git

2. Move the project into your server root
    htdocs/Team-Project-Group-4

3. Create the database

- Open phpMyAdmin

- Create a database named: 
   ecommerce_db
   
4. Import database files

- Import /sql/schema.sql

- Then import /sql/seed_data.sql   

5. Check configuration
In src/Config.php:
      define('DB_NAME', 'ecommerce_db');
      define('DB_USER', 'root');
      define('DB_PASS', '');
      define('BASE_URL', '/Team-Project-Group-4/public/');

6. Run the project
    http://localhost/Team-Project-Group-4/public/index.php?page=home


## Test Accounts

Admin

Email: BryanS231@gmail.com

Password: admin123

Customer

Email: johndoe34@gmail.com

Password: customer456


## Timeline

| Phase  | Period  | Goal |
|--------|---------|------|
| **Phase 1 – Setup** | Oct–Nov | Project skeleton, database, and static pages |
| **Phase 2 – MVP** | Nov–Dec | Login, products, basket, checkout |
| **Phase 3 – Final** | Jan–May | Admin tools, reviews, reporting, deployment |

---

## Contribution Guidelines

Each member works in a separate branch for their feature.

Commit often and write clear messages.

Use pull requests to merge into main.

Test before merging to keep the main branch stable.

---

## To-Do

Database schema finalization (Umair)

Homepage styling (Amy)

Login/Signup logic (Ayaan)

Basket system (Ikram)

Admin dashboard layout (Palak)

Product display (Kayroba)


---

##  Save and Commit

In VS Code terminal:
```bash
git add README.md
git commit -m "Updated README with roles, structure, and timeline"

--- 

## Push to GitHub

git push origin 

# Creating Pull Request

stage and then commit your changes on vscode

create a pull request amd wait it for to be aprroved by a contributer

then finally merge with the main branch
