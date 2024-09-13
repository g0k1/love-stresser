# 💘 The Official Source Code for love-stresser.me 💘

## 📜 Description

This repository contains the official source code for [love-stresser.me](https://love-stresser.me). It includes essential configurations for Discord alerts, domain management, automatic purchase links via Sellix, and database connections.

## 🚀 Features

- **Discord Alerts**: Automatically sends a Discord alert if the server's dedicated IP is exposed. 📡
- **Domain Configuration**: Easily update the domains used in the platform. 🌐
- **Sellix Integration**: Automatic purchase links for various plans using Sellix. 🛒
- **Database Configuration**: Simple setup for MySQL database connections. 🗄️

## 🛠️ Prerequisites

Before setting up the platform, ensure you have the following installed on your server:

1. **Nginx or Apache**: A web server for serving your application. 🌍
2. **PHP and Extensions**: The platform is built with PHP, so you need PHP and its extensions. 🖥️
3. **phpMyAdmin**: Manage your MySQL database easily via a web interface. 🗃️

## 📥 Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/YOUR_USERNAME/love-stresser-source.git
    cd love-stresser-source
    ```

2. **Install Nginx or Apache**:
    - **For Nginx**:
      ```bash
      sudo apt update
      sudo apt install nginx
      ```

    - **For Apache**:
      ```bash
      sudo apt update
      sudo apt install apache2
      ```

3. **Install PHP and required extensions**:
    ```bash
    sudo apt install php php-cli php-fpm php-mysql php-curl php-json php-gd php-mbstring
    ```

4. **Install phpMyAdmin**:
    ```bash
    sudo apt install phpmyadmin
    ```

5. **Configure Database**:
    In the file `love-stresser.me/componements/php/database_conn.php`, update the database credentials:
    ```php
    $servername = "localhost";
    $username = "YOUR_DATABASE_USER";
    $password = "YOUR_DATABASE_PASSWORD";
    $dbname = "YOUR_DATABASE_NAME";
    ```

6. **Configure Webhooks**:
    In the file `html/index.php`, set up your Discord webhook for IP exposure alerts:
    ```javascript
    const webhookUrl = "YOUR_DISCORD_WEBHOOK";
    ```

7. **Configure Domain Names**:
    In the file `love-stresser.me/IP/index.php` (lines 511 to 514), update the domain values:
    ```html
    <option value="YOUR_DOMAIN" class="domain">YOUR_DOMAIN</option>
    ```

8. **Configure Sellix Links**:
    In the file `love-stresser.me/componements/php/plans.php` (lines 132 to 144), update the Sellix links:
    ```php
    $links = [
      'free' => '',
      'starter1' => 'YOUR_SELLIX_LINK',
      'starter2' => 'YOUR_SELLIX_LINK',
      // ...
      'infinity' => 'YOUR_SELLIX_LINK'
    ];
    ```

## 🚀 Usage

1. **Start your web server**:
    - For Nginx:
      ```bash
      sudo systemctl start nginx
      ```
    - For Apache:
      ```bash
      sudo systemctl start apache2
      ```

2. **Access phpMyAdmin**:
    Open your browser and navigate to `http://YOUR_SERVER_IP/phpmyadmin` to manage your database.

3. **Monitor IP Exposure**:
    The Discord webhook will notify you if your server's IP is discovered.

## ⚠️ Notes

- **Ensure Correct Permissions**: Make sure your web server and phpMyAdmin are correctly set up to avoid security issues.
- **Sellix Integration**: Use valid Sellix links to manage the automatic purchase system for users.

---

This project is provided "as-is" without any warranties. Use at your own risk. 🌐
