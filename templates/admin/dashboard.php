<!-- Admin dashboard -->
 <?php
 include "../config/db.php";
 include "../controllers/AdminController.php";

 
 $stats = $admin-> getDashboardStats();
 <!DOCTYPE html>
 <html>
 <head>

 <title>Admin Dashboard</title>
 </head>
 <body>
 <h1>Dashboard</h1>
 <p> 


# As the Authentication & Security Developer, my responsibility will be to build a secure and reliable login system that protects both user and admin accounts. My focus will be on handling all user authentication, account security, and implementing role-based access control. This will begin with developing the core Sign Up, Login, and Logout functionality with secure database integration, before expanding to password management and ensuring authorised access to customer and admin areas. For the final product, I will strengthen backend security with measures like CSRF protection and comprehensive input validation. Overall, this will give me a robust system that safeguards the entire application 