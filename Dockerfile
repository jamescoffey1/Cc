# Use official PHP Apache image
FROM php:8.2-apache

# Copy project files into Apache root
COPY . /var/www/html/

# Expose port 8080 (Render expects your app on 8080)
EXPOSE 8080

# Apache will run by default