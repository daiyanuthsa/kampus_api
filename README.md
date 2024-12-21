# Student Management API Documentation

## Overview
This API provides endpoints for student management with authentication using Laravel Sanctum. All endpoints except login require authentication via Bearer token.

## Authentication

### Login
```
POST /api/login
```
- Authentication endpoint to receive access token
- Public access (no authentication required)
- Returns a Bearer token for subsequent requests

### Logout
```
POST /api/logout
```
- Invalidates the current access token
- Requires authentication
- Headers:
  - Authorization: Bearer {token}

## Student Endpoints

All student endpoints require authentication with Bearer token in the header:
```
Authorization: Bearer {your-token}
```

### Get All Students
```
GET /api/students
```
- Retrieves list of all students
- Response format:
```json
{
    "success": true,
    "data": [
        {
            "nim": "encrypted-nim",
            "name": "Student Name",
            "ukt_paid": true/false,
            // other student fields
        }
    ]
}
```

### Create Student
```
POST /api/students/create
```
- Creates a new student record
- Request body:
```json
{
    "nim": "required|string",
    "name": "required|string",
    "ukt_paid": "boolean"
}
```

### Get Student by NIM
```
GET /api/students/{nim}
```
- Retrieves a specific student by their NIM
- Response format:
```json
{
    "success": true,
    "data": {
        "nim": "encrypted-nim",
        "name": "Student Name",
        "ukt_paid": true/false,
        // other student fields
    }
}
```

### Update Student
```
PUT /api/students/update/{nim}
```
- Updates an existing student record
- Request body:
```json
{
    "name": "optional|string",
    "ukt_paid": "optional|boolean"
}
```

### Delete Student
```
DELETE /api/students/delete/{nim}
```
- Deletes a student record
- Returns success message upon completion

## Response Formats

### Success Response
```json
{
    "success": true,
    "message": "Success message",
    "data": {} // Optional data object
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message"
}
```

## Error Codes
- 200: Success
- 400: Bad Request
- 401: Unauthorized
- 404: Not Found
- 500: Server Error

## Security Notes
- All NIM values are encrypted in the database
- Authentication is required for all student endpoints
- Tokens are managed through Laravel Sanctum
- Session is invalidated on logout

## Installation

1. Clone the repository
2. Install dependencies:
```bash
composer install
```
3. Configure your `.env` file with database settings
4. Run migrations:
```bash
php artisan migrate
```
5. Generate application key:
```bash
php artisan key:generate
```
6. Modify your admin account at `database\seeders\DatabaseSeeder.php` and seed database:
```bash
php artisan db:seed
```
7. Start the server:
```bash
php artisan serve
```

## Additional Notes
- All student operations use encrypted NIMs for security
- The API performs decryption/encryption automatically
- Request validation is implemented for data integrity
- Logging is implemented for debugging purposes