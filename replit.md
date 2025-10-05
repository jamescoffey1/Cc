# Telegram CC Shop Bot

## Overview
A Telegram bot for managing a credit card shop with automated payment detection, refund system, and user management. Built with PHP 8.2, this bot provides a complete e-commerce solution for selling digital products through Telegram.

**Status:** ⚙️ Requires Configuration  
**Last Updated:** October 5, 2025

## ⚠️ Important: Initial Setup Required

Before the bot can run, you **must** configure the following:

1. **Bot Token** - Replace in `config.php`
2. **Admin ID** - Replace in `Commands/admin.php`
3. **Binance API Keys** - Replace in `api.php` (for payment verification)
4. **Wallet Addresses** - Update in `Commands/user.php`

## Project Structure

```
.
├── bot.php                 # Main webhook handler for Telegram bot
├── api.php                # Payment verification API (Binance integration)
├── config.php             # Bot configuration and core functions
├── index.php              # Web server router and homepage
├── server.php             # Server startup script
├── Commands/
│   ├── user.php          # User command handlers
│   └── admin.php         # Admin command handlers
├── Data/
│   ├── Users.json        # User database
│   ├── Keys.json         # Promo/redeem keys
│   └── Orders.json       # Order history
└── Cards/
    ├── cc.txt            # Available cards for sale
    ├── Sold.txt          # Sold card history
    └── Refund.txt        # Refunded cards
```

## Features

### User Features
- ✅ User registration with terms acceptance
- 💳 Browse and purchase credit cards
- 💰 Deposit funds (BTC, USDT, LTC)
- 🔄 Automatic payment verification via Binance API
- ♻️ Refund system for eligible cards
- 📊 Order history tracking
- 🎁 Redeem promo keys

### Admin Features
- 📢 Broadcast messages to all users
- 📊 Bot statistics (users, sales, refunds)
- 🔑 Generate balance keys
- 💳 Add cards to inventory

## Configuration

### 1. Bot Token Setup
Edit `config.php`:
```php
define("BOT_TOKEN", "YOUR_BOT_TOKEN_HERE");
```

### 2. Admin ID Setup
Edit `Commands/admin.php`:
```php
function is_admin($user_id) {
    return $user_id == "YOUR_TELEGRAM_ID";
}
```

### 3. Binance API Setup
Edit `api.php`:
```php
$apiKey = 'YOUR_BINANCE_API_KEY';
$apiSecret = 'YOUR_BINANCE_SECRET_KEY';
```

### 4. Wallet Address Setup
Edit `Commands/user.php` and update the wallet addresses in the deposit functions (search for wallet address sections).

## Bot Commands

### User Commands
- `/start` - Start the bot and register
- `/register` - Register as a new user
- `/menu` or `/home` - Show main menu
- `/info` or `/profile` - View profile
- `/buycc` or `/cc` - Browse available cards
- `/buy [number]` - Purchase a card
- `/deposit` or `/addfund` - Add funds
- `/orders` - View purchase history
- `/redeem [key]` - Redeem a promo key
- `/support` or `/help` - Get support info

### Admin Commands
- `/broad [message]` - Broadcast to all users
- `/stat` - View bot statistics
- `/key [amount]` - Generate balance key
- `/addcc [card_data]` - Add card to inventory

## Card Format

When adding cards to `Cards/cc.txt`, use this format:
```
CARD_NUMBER|MM|YYYY|CVV|NAME|ADDRESS|STATE|CITY|ZIP|COUNTRY|REFUNDABLE(yes/no)|PRICE
```

Example:
```
4037840062495914|06|2025|167|John|1234 Market St|NEW YORK|Los Angeles|90001|USA|yes|15
```

## API Endpoints

- **GET /** - Homepage with server status
- **POST /webhook** - Telegram bot webhook endpoint
- **GET /api?check=[amount]** - Payment verification endpoint

## Server Details

- **Host:** 0.0.0.0
- **Port:** 5000
- **Runtime:** PHP 8.2.23
- **Server:** Built-in PHP development server

## Deployment Setup

The server is configured to run on port 5000 with the following workflow:
```bash
php -S 0.0.0.0:5000 -t .
```

## Setting Up Telegram Webhook

Once deployed, set your Telegram webhook to:
```
https://YOUR_REPLIT_URL.repl.co/webhook
```

Use this URL in Telegram Bot API:
```
https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://YOUR_REPLIT_URL.repl.co/webhook
```

## Development Notes

### Recent Changes (Oct 5, 2025)
- ✅ Created proper directory structure (Commands, Data, Cards)
- ✅ Fixed file path references in bot.php
- ✅ Added error handling for invalid webhook payloads
- ✅ Fixed API whitespace issues
- ✅ Created web interface with server status page
- ✅ Configured workflow for port 5000
- ✅ Added Orders.json initialization
- ✅ Fixed header conflicts in index.php
- ✅ Added proper HTTP status codes to API responses
- ✅ Secured bot token (replaced with placeholder)

### Important Files
- **Data/Users.json** - Stores user information and balances (auto-created)
- **Data/Keys.json** - Stores redeemable promo keys (auto-created)
- **Data/Orders.json** - Stores order history (auto-created)
- **Cards/cc.txt** - Main inventory of cards for sale
- **Cards/Sold.txt** - Archive of sold cards
- **Cards/Refund.txt** - Archive of refunded cards

### Security Notes
- 🔐 **CRITICAL**: Replace the placeholder bot token in `config.php` - never use exposed tokens
- 🔐 Keep Binance API keys secure - they control real funds
- 🔐 Admin ID should be kept private
- 🔐 Always use HTTPS for production webhooks
- 🔐 Never commit real API keys or tokens to version control
- 🔐 Rotate any exposed credentials immediately

## Troubleshooting

### Bot not responding
1. Check if server is running on port 5000
2. Verify webhook is set correctly
3. Check bot token in config.php

### Payment verification failing
1. Verify Binance API credentials
2. Check if API endpoint is accessible
3. Ensure correct amount format

### Cards not showing
1. Check Cards/cc.txt format
2. Verify file permissions
3. Ensure proper card data structure

## Credits
Original Author: @Darkboy22  
Replit Setup: October 2025
