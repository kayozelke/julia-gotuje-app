# JuliaGotuje.pl

The project of culinary blog CMS based on Laravel framework.

## Overview

JuliaGotuje.pl is a web-based application designed for managing and publishing culinary blog posts. Inspired by popular platforms like aniagotuje.pl, it provides functionality for both public users and administrators, offering a seamless experience for browsing, publishing, and managing recipes and blog entries.

## Features

### Public Section (Guest Users)
- Browse categories and posts within a category.
- View individual posts (e.g., recipes, culinary events).
- Search posts by title and content.
- Like posts (optional feature).
- Download posts as PDF for printing (optional feature).

### Admin Section (Logged-in Users)
#### Post Management
- Add posts with specific types: recipe or general entry.
- Assign posts to a single category.
- Edit, delete, hide/unhide posts.
- Schedule posts for future publication (date and time).
- Advanced text editing via [SunEditor](https://github.com/JiHong88/SunEditor).
- Manage images for posts:
  - Upload and organize images.
  - Use images as thumbnails or embed them in text.
  - Support for prioritized image order.

#### Category Management
- Add, edit, and delete categories
- Set category as child of another one

#### Image Management
- Upload images in accepted formats (JPG, JPEG, PNG, WEBP, etc.).
- Batch upload multiple images.
- Edit titles and descriptions.

#### General Settings
- Set the number of visible posts per page.
- Add external links (e.g., social media) with customizable icons in the footer.

#### Other
- Use responsive tables and pagination for easy navigation.
- Dashboard summary for admin stats (e.g., post counts, image counts, disk usage).

## Non-functional Requirements
- Responsive design, suitable for mobile devices.
- Secure storage of admin passwords using Bcrypt hashing.
- Maximum image upload size: 8 MB.

## Technical Details
- **PHP Framework:** Laravel
- **Public Template:** [Spurgeon](https://styleshout.com/demo/?theme=spurgeon)
- **Admin Template:** [Sneat](https://themewagon.com/themes/free-responsive-bootstrap-5-html5-admin-template-sneat/)
- **Embed Text Editor:** [SunEditor](https://github.com/JiHong88/SunEditor)
- **CSS Framework:** Bootstrap 5
- **Database:** MySQL
- **Other:** [DataTables](https://datatables.net/)

## Installation
1. Install PHP 8.3/8.4
2. Install MysQL/MariaDB client
3. Clone repository
4. Run .sql file via SQL client, ex. `mysql -u root < juliagotuje.sql`
5. Copy file `.env.example` to `.env` and configure `.env` to your needs (URL, database host, credentials); set your APP_DEBUG to false
6. Install composer, run `composer install` inside app directory
7. Install and configure web server (Apache/Nginx), root directory should be `public/` and the index file `index.php`

## Authors
[kayozelke](https://github.com/kayozelke) & [javieranka](https://github.com/javieranka), 2025

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
