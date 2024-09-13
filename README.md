# ![Logo](https://i.ibb.co/d5TBCCz/logo.png)

# [📃](https://github.com/g0k1/love-stresser) | The Official Source Code for love-stresser.me

## [📜](https://github.com/g0k1/love-stresser) Description

Welcome to the official source code for love-stresser.me! This project provides a robust platform for stress-testing with a range of features, including customizable profiles, attack systems, member management, and more.

## [🚀](https://github.com/g0k1/love-stresser) Features

- **Customizable Profiles**: Personalize user profiles with custom settings. [🖼️](https://github.com/g0k1/love-stresser)
- **Subscription Plans**: Various tiers of plans to suit different needs. [💼](https://github.com/g0k1/love-stresser)
- **Attack System**: Advanced tools for executing stress tests. [💥](https://github.com/g0k1/love-stresser)
- **Animated Visuals**: Engaging user interfaces with animations. [🎨](https://github.com/g0k1/love-stresser)
- **Member Management**: Manage user accounts and memberships. [👥](https://github.com/g0k1/love-stresser)
- **Blacklist System**: Control access with a blacklist feature. [🚫](https://github.com/g0k1/love-stresser)
- **Simple Admin Dashboard**: Easy management of users and settings. [🛠️](https://github.com/g0k1/love-stresser)
- **IP Grabber Integration**: Track IP addresses through designated folders. [📡](https://github.com/g0k1/love-stresser)
- **Alert System**: Receive Discord notifications if your IP is discovered. [🚨](https://github.com/g0k1/love-stresser)
- **Discord Authentication**: Configure login via Discord. [🔐](https://github.com/g0k1/love-stresser)

## [🛠️](https://github.com/g0k1/love-stresser) Prerequisites

Ensure you have the following installed on your server:

##### 1. **Web Server**: Nginx or Apache. [🌐](https://github.com/g0k1/love-stresser)
##### 2. **PHP**: Including required extensions. [🔧](https://github.com/g0k1/love-stresser)
##### 3. **phpMyAdmin**: For managing your MySQL database. [📊](https://github.com/g0k1/love-stresser)

## [📥](https://github.com/g0k1/love-stresser) Installation

### 1. Connect to Your Server

```bash
ssh username@your_server_ip
```
### 2. Install Required Software

#### For Nginx
Install Nginx:
```bash
sudo apt update
sudo apt install nginx
```

Install PHP and Extensions:
```bash
sudo apt install php php-fpm php-mysql php-curl php-json php-gd php-mbstring
```
Install phpMyAdmin:
```bash
sudo apt install phpmyadmin
```

#### Configure Nginx: 
Create a configuration file:
```bash
sudo nano /etc/nginx/sites-available/love-stresser
```
Add the following content:
```apache
server {
    listen 80;
    server_name your_domain_or_ip;

    root /var/www/love-stresser-source;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Enable the Configuration:
```bash
sudo ln -s /etc/nginx/sites-available/love-stresser /etc/nginx/sites-enabled/
sudo systemctl restart nginx
```
#### For Apache
Install Apache:
```bash
sudo apt update
sudo apt install apache2
```
Install PHP and Extensions:
```bash
sudo apt install php php-mysql php-curl php-json php-gd php-mbstring
```
Install phpMyAdmin:
```bash
sudo apt install phpmyadmin
```
#### Configure Apache: 
Create a configuration file:
```bash
sudo nano /etc/apache2/sites-available/love-stresser.conf
```
Add the following content:
```apache
<VirtualHost *:80>
    ServerAdmin webmaster@your_domain_or_ip
    DocumentRoot /var/www/love-stresser-source
    ServerName your_domain_or_ip

    <Directory /var/www/love-stresser-source>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
Enable the Configuration:
```bash
sudo a2ensite love-stresser.conf
sudo systemctl reload apache2
```
### 3. Clone the Repository
```bash
cd /var/www
sudo git clone https://github.com/yourusername/love-stresser-me.git love-stresser-source
```
### 4. Configure the Application
Update Configuration Files:

**love-stresser.me/html:** Edit line 8 in **html/config.js** to set your Discord webhook URL.
```javascript
const webhookUrl = "YOUR_DISCORD_WEBHOOK";
love-stresser.me/IP/index.php: Update lines 511-514 with your domain names.
```
```html
<option value="yourdomain1.com" class="domain">yourdomain1.com</option>
<option value="yourdomain2.com" class="domain">yourdomain2.com</option>
```
**love-stresser.me/componements/php/api_token.php:** Set your custom API token.
```php
<?php
$token = 'YOUR_CUSTOM_API_TOKEN';
?>
```
**love-stresser.me/componements/php/database_conn.php:** Configure your database connection details.
```php
<?php
$servername = "localhost";
$username = "YOUR_DATABASE_USER";
$password = "YOUR_DATABASE_PASSWORD";
$dbname = "YOUR_DATABASE_NAME";
?>
```
**love-stresser.me/componements/php/discord_server.php:** Set your Discord server invitation links and codes.

```php
<?php
$ban_server_full_link = 'YOUR_DISCORD_INVITATION';
$server_full_link = 'YOUR_DISCORD_INVITATION';
$serverInviteCode = 'YOUR_INVITE_CODE';
?>
```
**love-stresser.me/componements/php/plans.php:** Configure your automatic purchase links.
```php
<?php
$links = [
  'free' => '',
  'starter1' => 'YOUR_SELLIX_LINK',
  'starter2' => 'YOUR_SELLIX_LINK',
  'starter3' => 'YOUR_SELLIX_LINK',
  'exp1' => 'YOUR_SELLIX_LINK',
  'exp2' => 'YOUR_SELLIX_LINK',
  'exp3' => 'YOUR_SELLIX_LINK',
  'pro1' => 'YOUR_SELLIX_LINK',
  'pro2' => 'YOUR_SELLIX_LINK',
  'pro3' => 'YOUR_SELLIX_LINK',
  'infinity' => 'YOUR_SELLIX_LINK'
];
?>
```
Configure Discord Authentication: Set up the Discord login in the **/authentication** folder.

Update Discord URLs: Ensure all Discord invite URLs in **love-stresser.me/componements/php/discord_server.php** are correct.

### 5. Finalize Setup

Restart Services:
```bash
sudo systemctl restart nginx    # For Nginx
sudo systemctl restart apache2  # For Apache
```
Verify Installation: Open your web browser and navigate to **http://your_domain_or_ip** to check if the application is running.

[📺](https://github.com/g0k1/love-stresser) Preview
Check out the [preview video](https://www.youtube.com/watch?v=Y5-9QIq_HeA) for a walkthrough of the website setup and features.

[⚠️](https://github.com/g0k1/love-stresser) Notes
Permissions: Ensure the server has the necessary permissions for the application files.
Compliance: Follow all applicable guidelines and terms of service to avoid misuse of the application.

## Made with [🤍](https://github.com/g0k1/love-stresser) by

- **@Meandoyou** (*goki*)
- **@StingAving** (*stingaving*)
