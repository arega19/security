# Study Planner - Authentication System

A comprehensive study planning application with secure user authentication and AES-256 encryption.

## Features

### Authentication & Security

- **User Registration**: Secure signup with password strength validation
- **User Login**: Session-based authentication with CSRF protection
- **Password Security**: Bcrypt hashing with strength requirements
- **Session Management**: Secure PHP sessions with proper cleanup
- **CSRF Protection**: Token-based protection against cross-site request forgery
- **AES-256 Encryption**: Sensitive data (study plans) encrypted with AES-256-CBC

### Database Storage

- **User-specific data**: All data is isolated per user
- **Comprehensive tables**: Tasks, plans, resources, analytics, preferences, etc.
- **Real-time sync**: Frontend cache with database persistence

## File Structure

```
study_planner/
├── api/                    # API endpoints
│   ├── tasks.php          # Task CRUD operations
│   ├── plans.php          # Study plans with encryption
│   ├── resources.php      # Resource management
│   ├── settings.php       # User preferences
│   ├── analytics.php      # Study analytics
│   ├── pomodoro.php       # Pomodoro statistics
│   ├── focus.php          # Focus session ratings
│   ├── schedule.php       # Study scheduling
│   ├── undo.php           # Undo/redo history
│   └── sync.php           # Synchronization state
├── config/
│   └── db.php             # Database configuration
├── includes/
│   ├── auth_check.php     # Authentication middleware
│   ├── security.php       # Security functions (AES, CSRF, validation)
│   └── ...
├── index.php              # Main dashboard (protected)
├── login.php              # Login page
├── signup.php             # Registration page
├── logout.php             # Logout handler
├── profile.php            # User profile management
└── schema.sql             # Database schema
```

## Security Features

### Password Requirements

- Minimum 8 characters
- At least one uppercase letter
- At least one lowercase letter
- At least one number

### Data Encryption

- Study plan topics are encrypted using AES-256-CBC
- Encryption key stored securely in config
- Automatic encryption/decryption in API layer

### Session Security

- PHP sessions with secure configuration
- Session regeneration on login
- Proper session cleanup on logout

### Input Validation

- All user inputs sanitized and validated
- SQL injection prevention with prepared statements
- XSS protection with htmlspecialchars

## API Authentication

All API endpoints require authentication:

```php
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}
```

## Usage

1. **Setup Database**:

   ```bash
   mysql -u root < schema.sql
   ```

2. **Access Application**:

   - Visit `signup.php` to create an account
   - Login via `login.php`
   - Access dashboard at `index.php`

3. **Security Configuration**:
   - Update `AES_KEY` in `config/db.php`
   - Configure proper database credentials
   - Set up HTTPS in production

## Development Notes

- All sensitive data uses AES encryption
- User data is completely isolated
- Frontend uses caching for performance
- Database operations are atomic where necessary
- Error logging to `logs/error.log`

## Production Deployment

- Enable HTTPS
- Use strong AES encryption key
- Configure session security settings
- Set up proper database user with limited privileges
- Enable error logging but disable display
