# Cannalot Dashboard - Setup Complete! 🎉

## Current Status
✅ PHP MVC Dashboard is running
✅ File-based storage initialized with sample data  
✅ Server running on port 8000
✅ All routes and controllers working correctly

## Access Your Dashboard

**Current Working URLs:**
- http://localhost:8000 (immediately accessible)
- http://cannalot.local:8000 (requires hosts file setup - see below)

**Login Credentials:**
- Email: john@example.com
- Password: password

## To Enable cannalot.local Domain

### Method 1: Use the Setup Script (Recommended)
1. Right-click PowerShell and select "Run as Administrator"
2. Navigate to this directory
3. Run: `.\setup_local_domain.ps1`

### Method 2: Manual Setup
1. Open Notepad as Administrator
2. Open: `C:\Windows\System32\drivers\etc\hosts`
3. Add this line: `127.0.0.1 cannalot.local`
4. Save the file
5. Access: http://cannalot.local:8000

## What's Included

### Sample Data
- 5 Users (including admin: john@example.com)
- 5 Cannabis products
- 5 Sample orders

### Features Working
- Dashboard with statistics
- User management (view, create, edit, delete)
- File-based storage (no database required)
- Responsive modern UI
- MVC architecture

### Files Created
- `data/users.json` - User accounts
- `data/products.json` - Product catalog  
- `data/orders.json` - Order history
- `setup_local_domain.ps1` - Domain setup script
- `init_file_storage.php` - Data initialization

## Server Management

**Start Server:**
```bash
php -S 0.0.0.0:8000
```

**Stop Server:**
Press Ctrl+C in the terminal where the server is running

## Next Steps

1. Set up the cannalot.local domain using the instructions above
2. Customize the dashboard for your specific needs
3. Add more products, users, or modify the data structure
4. Optional: Configure MySQL/SQLite database if needed

## Troubleshooting

**If localhost:8000 doesn't work:**
- Ensure the PHP server is running
- Check that port 8000 isn't being used by another application

**If cannalot.local:8000 doesn't work:**
- Verify the hosts file entry was added correctly
- Try clearing your browser cache
- Make sure the server is running with `0.0.0.0:8000` (not `localhost:8000`)

The dashboard is now fully functional and ready to use! 🚀
