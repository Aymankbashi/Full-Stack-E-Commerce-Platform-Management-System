<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">Full-Stack E-Commerce Platform & Management System</h1>

<p align="center">
  A comprehensive, feature-rich e-commerce platform and management system built with Laravel, featuring multi-language support (Arabic & English), robust admin controls, integrated customer support chat, and advanced product management.
</p>

---

## 📋 Table of Contents
1. [Introduction](#-introduction)
2. [Key Features](#-key-features)
3. [Project Structure](#-project-structure)
4. [System Architecture & Modules](#-system-architecture--modules)
5. [Prerequisites](#-prerequisites)
6. [Installation & Setup](#-installation--setup)
7. [Testing & Performance](#-testing--performance)
8. [License](#-license)

---

## 🚀 Introduction
This project is an advanced, scalable E-Commerce platform developed using the **Laravel** framework. It delivers a full-fledged ecosystem for online retail operations, offering a secure shopping experience for customers and a powerful dashboard for administrators and support agents.

---

## ✨ Key Features

* **Multi-Language Support:** Full localization for Arabic and English, dynamically managed via `Accept-Language` headers and `lang` localization files with RTL/LTR layout support.
* **Advanced Product Management:** Comprehensive system for managing products, categories, stock tracking, and discounts with Eloquent query filtering (by price range, ratings, and categories).
* **Session-Based Shopping Cart:** Real-time calculation of totals, item quantities, and discount applications.
* **Order Tracking & Processing:** Seamless checkout workflow, order history management, and status updates (`Order` and `OrderItem` models).
* **Live Customer Support System:** Integrated real-time chat sessions between customers and support agents, complete with agent dashboards, session assignments, and canned response templates (`ReplyTemplate`).
* **Admin Dashboard:** Centralized control panel for managing users, roles, permissions, system status, and monitoring store analytics (`AdminController`).
* **Review & Rating System:** Allows users to leave product reviews, ratings, and comments.
* **Security & Performance:** CSRF protection, secure password hashing, route authorization via Middleware, and built-in query caching and pagination.

---

## 📂 Project Structure
* **`app/Http/`**: Contains Controllers and Middleware.
* **`app/Models/`**: Database Eloquent models (User, Role, Product, Order, SupportSession, etc.).
* **`database/`**: Migration files, factories, and seeders.
* **`lang/`**: Localization and translation files (Arabic/English).
* **`resources/views/`**: Blade templates for storefront, customer dashboard, and admin panel.
* **`routes/`**: Web and API routing files.

---

## ⚙️ Prerequisites
Ensure the following are installed on your development environment:
* **PHP** (^8.2 or higher)
* **Composer**
* **Node.js & NPM**
* **MySQL** or compatible database server

---

## 📥 Installation & Setup

Follow these steps to set up the project locally:

### 1. Clone the Repository
```bash
git clone [https://github.com/Aymankbashi/Full-Stack-E-Commerce-Platform-Management-System.git](https://github.com/Aymankbashi/Full-Stack-E-Commerce-Platform-Management-System.git)
cd Full-Stack-E-Commerce-Platform-Management-System
