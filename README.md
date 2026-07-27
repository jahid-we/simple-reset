# Simple Reset

A modern, lightweight, and secure WordPress plugin for safely cleaning your website by deleting posts, pages, media, comments, users, WooCommerce data, and other WordPress content with built-in protection, activity logging, and confirmation safeguards.

---

## ✨ Features

### Content Cleanup

- 📝 Delete All Posts
- 📄 Delete All Pages
- 🖼️ Delete All Media
- 💬 Delete All Comments
- 📂 Delete All Categories (Default category protected)
- 🏷️ Delete All Tags
- 👤 Delete All Users (Current user & administrators protected)
- 🗑️ Empty Trash
- 📝 Delete Post Revisions
- 📋 Delete Auto Drafts
- 🎨 Reset Theme Customizer

### Custom Post Types

- 📦 Delete Custom Post Types
- 🛡️ Automatically protects the active Elementor Site Kit

### WooCommerce

- 🛒 Delete WooCommerce Products
- 🎟️ Delete WooCommerce Coupons

### Dashboard

- 📊 Live Statistics Dashboard
- 📈 WordPress Content Overview
- 💻 System Information

### Security

- 🔒 Nonce Verification
- 👮 Capability Checks
- 🔐 Restrict access by User ID
- 💾 Optional Backup Confirmation
- 📧 Email Notifications
- ⚠️ Confirmation Modal before destructive actions

### Activity Logs

- 📝 Complete Activity Logging
- 🌐 Stores User, IP Address, Timestamp & Action
- 📋 One-click Copy Raw Logs
- 🗃️ Dedicated Database Log Table

### Settings

- ⚙️ Global Reset Enable / Disable
- 👤 Allowed User IDs
- 💾 Backup Confirmation Requirement
- 📧 Email Alert Settings
- ⚠️ Custom Warning Message

### Import / Export

- 📤 Export Plugin Settings (.json)
- 📥 Import Plugin Settings (.json)

---

## 📸 Screenshots

| Dashboard                          | Reset Tools                            |
| ---------------------------------- | -------------------------------------- |
| ![Dashboard](assets/dashboard.png) | ![Reset Tools](assets/reset-tools.png) |

---

## 🚀 Installation

1. Download or clone this repository.
2. Upload the `simple-reset` folder to:

```
wp-content/plugins/
```

3. Activate **Simple Reset** from the Plugins screen.
4. Navigate to:

```
Dashboard → Reset
```

---

## ⚠️ Important

Simple Reset performs **permanent deletion** of WordPress content.

Always create a complete backup before executing any cleanup operation.

### Protected Items

- Current logged-in administrator
- Administrator accounts
- Default WordPress category
- Active Elementor Site Kit

---

## 🛠 Requirements

| Requirement | Version |
| ----------- | ------- |
| WordPress   | 5.8+    |
| PHP         | 8.0+    |

---

## 📂 Plugin Structure

```
simple-reset/
├── src/
│   ├── Admin.php
│   ├── Assets.php
│   ├── Log.php
│   ├── Plugin.php
│   ├── Reset.php
│   ├── Settings.php
│   └── Statistics.php
│
├── templates/
│   ├── dashboard.php
│   ├── reset-tools.php
│   ├── custom-post-types.php
│   ├── settings.php
│   ├── logs.php
│   └── parts/
│
├── vendor/
├── composer.json
└── simple-reset.php
```

---

## 🔒 Security Features

- WordPress Nonce Verification
- Capability Validation
- Input Sanitization & Escaping
- Protected Administrator Accounts
- Protected Default Category
- Protected Active Elementor Kit
- Backup Confirmation Option
- User ID Restriction
- Activity Logging

---

## 🚧 Roadmap

Planned features for future releases:

- Delete WooCommerce Orders
- Delete WooCommerce Customers
- Delete WooCommerce Product Categories
- Delete WooCommerce Product Tags
- Database Optimization
- Reset Widgets
- Full Site Reset
- Scheduled Cleanup
- Multisite Support

---

## 👨‍💻 Developer

**Jahid Hasan**

GitHub: https://github.com/jahid-we

---

## 📄 License

Licensed under the **GPL v2 or later**.

See the LICENSE file for details.

---

## ⭐ Support

If you find this project useful, please consider giving it a ⭐ on GitHub.
