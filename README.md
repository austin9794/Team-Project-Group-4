## E-Commerce Group Project

This is our group project for the CS2TP module.  
It is a fully functional e-commerce platform with both **customer** and **admin** interfaces.

##  Project Overview

The goal is to design, build, and deploy a website that allows customers to:
- Register, log in, and manage their accounts.
- Browse products by category, search, and filter.
- Add products to a basket, checkout, and view orders.
- Leave ratings and reviews for products.

Admins can:
- Manage users, products, and orders.
- Track stock levels and sales reports.
- Process shipments and handle inventory updates.

---

##  Project Folder Structure

public/ → Main entry point and front-end assets
src/ → Backend logic (controllers, models, helpers)
templates/ → Page templates (customer, admin, auth)
sql/ → Database scripts
docs/ → Documentation


---

## 👥 Team Roles & Responsibilities

| Member | Role | Main Responsibilities |
|--------------|--------------------------------------|--------|
| **1. Umair** | **System Architect & Database Lead** | Project setup, database, backend routing, My Account integration, testing & deployment |
| **2. Amy**   | **Frontend & UI/UX Developer** | Page layout, theme design, responsive front-end |
| **3. Ayaan** | **Authentication & Security Developer** | Login, signup, password management, access control |
| **4. Ikram** | **Basket & Checkout Developer** | Basket logic, checkout flow, order history |
| **5. Palak** | **Admin Dashboard Developer** | Admin panel, stock & order management, reporting |
| **6. Kayroba** | **Product Catalogue & Reviews Developer** | Product listing, filtering, and review system |

---

## 📅 Timeline

| Phase  | Period  | Goal |
|--------|---------|------|
| **Phase 1 – Setup** | Oct–Nov | Project skeleton, database, and static pages |
| **Phase 2 – MVP** | Nov–Dec | Login, products, basket, checkout |
| **Phase 3 – Final** | Jan–May | Admin tools, reviews, reporting, deployment |

---

## ⚙️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP (PDO), MVC-style architecture  
- **Database:** MySQL  
- **Version Control:** GitHub  
- **Server:** University-hosted PHP/MySQL environment  

---

## 🧠 How to Run Locally

1. Clone the repository:
   ```bash
   git clone https://github.com/austin9794/Team-Project-Group-4.git
   
2. Move the project to your htdocs (XAMPP) or local server directory.

3. Import the SQL file in /sql/schema.sql into phpMyAdmin.

4. Open localhost in your browser

---

## 🧾 Contribution Guidelines

Each member works in a separate branch for their feature.

Commit often and write clear messages.

Use pull requests to merge into main.

Test before merging to keep the main branch stable.

---

## 📋 To-Do

Database schema finalization (Umair)

Homepage styling (Amy)

Login/Signup logic (Ayaan)

Basket system (Ikram)

Admin dashboard layout (Palak)

Product display (Kayroba)


---

## 💾  Save and Commit

In VS Code terminal:
```bash
git add README.md
git commit -m "Updated README with roles, structure, and timeline"

--- 

## 🌐 Push to GitHub

git push origin 
