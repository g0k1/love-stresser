
![Logo](https://i.ibb.co/d5TBCCz/logo.png)


# 📃 | The official source code for love-stresser.me

## 📜 Description

This repository contains the official source code for [love-stresser.me](https://love-stresser.me). The platform provides a powerful stress-testing tool with various features such as customizable profiles, attack systems, animated visuals, member management, blacklist functionality, and a simple admin system.

## 🚀 Features

- **Customizable Profiles**: Users can personalize their profiles with custom settings and preferences. 🖼️
- **Plans**: Multiple tiers of subscription plans, each offering different levels of functionality. 💼
- **Attack System**: Includes a fully-featured attack system for testing with DDoS methods. 💥
- **Animated Visuals**: The platform offers visually engaging and animated interfaces for a dynamic user experience. 🎨
- **Member Page**: A dedicated page where all registered users can manage their accounts. 👥
- **Blacklist System**: Securely manages and blocks blacklisted users from accessing the platform. 🚫
- **Simple Administration System**: An easy-to-use admin panel to manage users, plans, and platform settings. 🛠️
- **IP Grabber Integration**: Contains folders for domain IP grabbers to track IP addresses. 📡
- **Alert System**: The HTML folder includes a mechanism to send an alert if the page is loaded or "pinged," indicating whether the IP has been discovered. 🚨

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

5. **Configure the Database**:
    In the file `love-stresser.me/componements/php/database_conn.php`, update the database credentials:
    ```php
    $servername = "localhost";
    $username = "YOUR_DATABASE_USER";
    $password = "YOUR_DATABASE_PASSWORD";
    $dbname = "YOUR_DATABASE_NAME";
    ```

6. **Set up Discord Webhooks**:
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

3. **User Registration and Profile Customization**:
    Users can sign up, log in, and customize their profiles directly from the platform.

4. **Plan Management**:
    Users can view and select different subscription plans, including free and paid tiers.

5. **Attack System**:
    Once registered, users can access the stress-testing feature to conduct attacks.

6. **Admin Dashboard**:
    Manage user accounts, monitor usage, and control blacklisted members from the easy-to-use admin dashboard.

7. **IP Grabber Integration**:
    Utilize the folders for domain IP grabbers to monitor and track IP addresses effectively.

8. **Alert System**:
    The HTML folder includes a script that triggers an alert if the page is loaded or "pinged," helping to detect if an IP has been discovered.

## ⚠️ Notes

- **Permissions**: Make sure the platform has the correct permissions set for server security.
- **Sellix Integration**: Ensure all Sellix links are correctly configured for automatic purchases.
- **Monitoring IP Exposure**: Configure your Discord webhook to receive alerts if your server's IP is exposed.

---

This project is provided "as-is" without any warranties. Use responsibly and at your own risk. 🌐
