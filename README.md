# Invoice Generator

Invoice Generator is a web-based invoice management system that simplifies creating, managing, and sending invoices. It supports role-based access for **Admins** and **Users**, generates professional PDF invoices with logos and watermarks, and provides email integration for sending invoices directly to clients.

---

## ✨ Features

- **Role-Based Access**
  - **Admin**
    - Add/Delete Users
    - Update Email Credentials
    - Manage all user functionalities
  - **User**
    - Create & Manage Invoices

- **Invoice Management**
  - Create invoices with existing clients (via dropdown) or new clients (auto-added to system)
  - Add multiple items with quantity, rate, and automatic calculation
  - Support for Taxes, Discounts, Partial Payments, and Balance Tracking
  - Attach **Logo** and **Watermark** on invoices
  - Generate professional **PDF Invoices** with clickable payment link
  - View, Edit, Delete invoices from dashboard

- **Email Integration**
  - Configure SMTP settings in Email Settings
  - Send invoices directly to client email from dashboard

---

## 🛠️ Tech Stack

- **Backend:** PHP, MySQL  
- **Frontend:** HTML, CSS, JavaScript  
- **PDF Generation:** TCPDF  
- **Email Integration:** SMTP  

---

## 🚀 Installation & Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/MaazzAhmed/Invoice-Generator-Mazania-Digital-Solution-
   cd invoice-generator
   ```

2. **Database Setup**
   - Inside the project folder, you will find a folder named `db/`
   - Import the database file:
     ```
     db/invoice_system.sql
     ```
   - Create a MySQL database named `invoice_system` and import the above SQL file.

3. **Configure Database Connection**
   - Open the project’s database configuration file (`configuration.php` & `generated.php` or similar depending on your setup).
   - Update your MySQL credentials:
     ```php
     $host = "localhost";
     $username = "root";
     $password = "";
     $database = "invoice_system";
     ```

4. **Run the Project**
   - Place the project folder in your local server directory (`htdocs` for XAMPP, `www` for WAMP).
   - Start Apache and MySQL.
   - Open in browser:
     ```
     http://localhost/invoice-generator
     ```

---

## 🔑 Login Credentials (Demo)
- **Email:** maaza42101@gmail.com  
- **Password:** 123  

---

## 📸 Screenshots
- Dashboard  
- Invoice Creation  
- All Invoices  
- Email Settings  

---

## 📌 Future Improvements
- Online payment gateway integration (Stripe/PayPal)  
- Multi-currency support  
- Advanced reporting & analytics  
- Client portal for invoice tracking  

---

## 📄 License
This project is licensed under the MIT License.  
You are free to use, modify, and distribute with attribution.
