---
description: Repository Information Overview
alwaysApply: true
---

# Shree Unnati Wires & Traders Information

## Summary
A PHP-based business management system and public website for Shree Unnati Wires & Traders, a wire manufacturing and trading company. The system includes a main marketing website and a comprehensive multi-user dashboard for managing different business facets including administration, factory operations, retail stores, and vendors.

## Structure
- **Root**: Contains the public website (`index.php`), authentication (`login.php`, `logout.php`), and shared components (`_conn.php`, `_footer.php`, `_main_nav.php`).
- **Dashboard/**: The core management system with role-specific subdirectories.
    - **Admin/**: Administration dashboard for overall business management, user management, and reporting.
    - **Factory/**: Factory-specific management including production, inventory, and workers.
    - **Retail_Store/**: Retail operations management covering billing, customers, and inventory.
    - **Vendor/**: Vendor management system for orders, deliveries, and payments.
- **unnati_wweb/**: Contains static HTML pages for the marketing website.
- **public/**: Public assets including CSS and images.

## Language & Runtime
**Language**: PHP  
**Runtime**: PHP (Version not specified, but compatible with standard web hosting like InfinityFree)  
**Database**: MySQL (Connection details in `_conn.php`)  
**Frontend**: HTML5, CSS3, Bootstrap 5 (via CDN), JavaScript

## Dependencies
**Main Dependencies**:
- **Bootstrap 5**: UI framework (loaded via CDN)
- **MySQLi**: PHP extension for database connectivity
- **Font Awesome**: Icon library (references found in dashboard files)

## Build & Installation
The project is a standard PHP application that can be deployed by uploading files to a PHP-supported web server.
1. Upload all files to the web server root.
2. Import the provided SQL schema from `u276201717_unnati_wires.sql` or `unnati-wires.sql` into a MySQL database.
3. Configure database connection in `_conn.php`.

## Main Files & Resources
- **Public Entry Point**: `index.php` (Root)
- **Dashboard Entry Point**: `Dashboard/index.php` (Routes users based on session type)
- **Database Connection**: `_conn.php`
- **User Roles**: Admin, Factory, Store, Vendor (defined in `Dashboard/index.php`)
- **SQL Schemas**: `u276201717_unnati_wires.sql`, `unnati-wires.sql`

## Data Management
The system uses a mix of live database connections and mock data:
- `_conn.php` handles the live MySQL connection.
- `Dashboard/Retail_Store/database.php` and `Dashboard/Vendor/database.php` currently contain extensive mock data in PHP arrays, intended to be transitioned to live database queries.

## Testing & Validation
No formal testing framework (like PHPUnit) is present in the repository. Validation is performed manually through the web interface.
