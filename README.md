# VisitorManagementSystem
# Visitor Management System (VMS)

A comprehensive PHP-based Visitor Management System designed to manage visitor registrations, check-ins, check-outs, and generate reports with QR code functionality.

## Features

- **Visitor Registration**: Register new visitors with pre-registration support
- **Check-in/Check-out**: Track visitor entry and exit times
- **QR Code Generation**: Automatic QR code generation for visitor passes
- **User Authentication**: Role-based access control
- **Reports & Analytics**: Generate visitor reports and charts
- **CSV Export**: Export visitor data to CSV format
- **Blacklist Management**: Maintain a blacklist of unauthorized visitors
- **Dashboard**: Real-time dashboard with current visitor information

## System Requirements

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Apache/XAMPP with mod_rewrite enabled
- GD library for image/QR code generation

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd VMS
   ```

2. **Database Setup**
   - Create a new MySQL database named `visitor_db`
   - Import the database schema (if provided)
   - Update database credentials in `config/config.php`

3. **Configuration**
   - Copy `config.example.php` to `config.php`
   - Update database credentials:
     ```php
     $host = "localhost";
     $user = "root";
     $pass = "";
     $db = "visitor_db";
     ```

4. **Directory Permissions**
   - Ensure `uploads/` directory is writable:
     ```bash
     chmod 755 uploads/
     chmod 755 assets/qrcodes/
     ```

5. **Access the Application**
   - Open your browser and navigate to: `http://localhost/VMS/`
   - Default login credentials (update after first login):
     - Username: `admin`
     - Password: `admin`

## File Structure

```
VMS/
├── src/                      # Core application files
│   ├── auth.php             # Authentication functions
│   ├── header.php           # Common header template
│   └── ...
├── public/                   # Publicly accessible files
│   ├── dashboard.php        # Main dashboard
│   ├── login.php            # Login page
│   ├── logout.php           # Logout handler
│   └── ...
├── lib/                      # Third-party libraries
│   ├── phpqrcode/           # QR code generation library
│   └── ...
├── uploads/                  # User uploads (git-ignored)
│   ├── docs/
│   ├── id/
│   └── photos/
├── assets/                   # Static assets
│   ├── css/
│   ├── js/
│   ├── logo/
│   └── qrcodes/
├── config/                   # Configuration files
│   └── config.example.php   # Example configuration
├── README.md                # This file
├── LICENSE                  # License file
└── .gitignore              # Git ignore rules
```

## Usage

### Visitor Registration
1. Navigate to **Pre-Register** page
2. Fill in visitor details
3. Submit form
4. System generates unique visitor ID and QR code

### Check-in/Check-out
1. Scan QR code or enter visitor ID
2. Click **Check-in** or **Check-out**
3. System records timestamp

### Reports
1. Navigate to **Reports** section
2. View visitor history and analytics
3. Export data to CSV if needed

## Security Notes

- Never commit `config.php` with sensitive credentials
- Always use `config.example.php` as template
- Implement HTTPS in production
- Use strong passwords for admin accounts
- Regularly backup the database
- Sanitize all user inputs

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For issues, feature requests, or questions, please open an issue on GitHub.

## Authors

- Development Team
- email: ashishkumar7807445804@gmail.com

- linked In :https://www.linkedin.com/in/ashishkumar0002/
---

**Last Updated**: February 2026
