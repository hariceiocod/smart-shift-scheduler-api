# **Smart Shift Scheduler - Backend API**

## **Overview**

Smart Shift Scheduler Backend API is built using Laravel, MongoDB, and Sanctum for authentication. It provides endpoints for managing employee shifts and assignments.

## **Setup Instructions**

### **Prerequisites**

Ensure you have the following installed:

- PHP (>= 8.2.21)
- Laravel Framework (>= 10)
- MongoDB
- Composer
- Sanctum for API authentication

### **Installation**

#### **Clone the Repository**

```sh
git clone https://github.com/hariceiocod/smart-shift-scheduler-api.git
cd smart-shift-scheduler-api
```

#### **Install Dependencies**

```sh
composer install
```

#### **Configure Environment Variables**

```sh
cp .env.example .env
```

Update the necessary fields, particularly the MongoDB connection settings in `.env`:

```ini
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=your_database
```

#### **Install and Configure Sanctum**

```sh
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

#### **Run the Admin Seeder**

```sh
php artisan db:seed --class=AdminSeeder
```

#### **Start the Backend Server**

```sh
php artisan serve
```

## **API Documentation**

### **Authentication**

#### **Register**

- **Endpoint:** `POST /api/register`
- **Request Body:**

```json
{
  "name": "John Doe",
  "email": "user@example.com",
  "password": "yourpassword",
  "max_hours_per_week": 40,
  "availability": ["Monday", "Tuesday", "Wednesday"]
}
```

- **Response:**

```json
{
  "message": "User registered successfully",
  "id": "650e5f2a2b3d4c6a8f9e7d1b",
  "name": "John Doe",
  "email": "user@example.com",
  "role": "employee",
  "max_hours_per_week": 40,
  "availability": ["Monday", "Tuesday", "Wednesday"],
  "created_at": "2025-02-09T12:00:00Z",
  "updated_at": "2025-02-09T12:00:00Z",
  "token": "your-auth-token"
}
```

#### **Login**

- **Endpoint:** `POST /api/login`
- **Request Body:**

```json
{
  "email": "user@example.com",
  "password": "yourpassword"
}
```

- **Response:**

```json
{
  "message": "User logged in successfully",
  "id": "650e5f2a2b3d4c6a8f9e7d1b",
  "name": "John Doe",
  "email": "user@example.com",
  "role": "employee",
  "max_hours_per_week": 40,
  "availability": ["Monday", "Tuesday", "Wednesday"],
  "created_at": "2025-02-09T12:00:00Z",
  "updated_at": "2025-02-09T12:00:00Z",
  "token": "your-auth-token"
}
```

#### **Logout**

- **Endpoint:** `POST /api/logout`
- **Headers:**

```json
{
  "Authorization": "Bearer your-auth-token"
}
```

- **Response:**

```json
{
  "message": "Successfully logged out"
}
```

### **Shift Management**

#### **Get Shifts**

- **Endpoint:** `GET /api/shifts`
- **Response:**

```json
[
  {
    "_id": "60d21b4667d0d8992e610c85",
    "date": "2025-02-10",
    "start_time": "09:00",
    "end_time": "17:00",
    "max_employees": 10,
    "assigned_employees": [],
    "conflict": false,
    "conflict_message": []
  }
]
```

#### **Create Shift**

- **Endpoint:** `POST /api/shifts/create`
- **Request Body:**

```json
{
  "date": "2025-02-10",
  "start_time": "09:00",
  "end_time": "17:00",
  "max_employees": 10
}
```

- **Response:**

```json
{
  "message": "Shift created successfully"
}
```

#### **Update Shift**

- **Endpoint:** `PATCH /api/shifts/update`
- **Request Body:**

```json
{
  "shift_id": "60d21b4667d0d8992e610c86",
  "date": "2025-02-11",
  "start_time": "10:00",
  "end_time": "18:00",
  "max_employees": 12
}
```

- **Response:**

```json
{
  "message": "Shift updated successfully"
}
```

#### **Delete Shift**

- **Endpoint:** `DELETE /api/shifts/delete`
- **Request Body:**

```json
{
  "shift_id": "650e5f2a2b3d4c6a8f9e7d1d"
}
```

- **Response:**

```json
{
  "message": "Shift deleted successfully"
}
```

### **Employee Management**

#### **Get Employees**

- **Endpoint:** `GET /api/employees`
- **Headers:**

```json
{
  "Authorization": "Bearer your-auth-token"
}
```

- **Response:**

```json
[
  {
    "id": "650e5f2a2b3d4c6a8f9e7d1b",
    "name": "John Doe",
    "email": "user@example.com",
    "max_hours_per_week": 40,
    "availability": ["Monday", "Tuesday", "Wednesday"],
    "assigned_shifts": [],
    "conflict": false,
    "conflict_messages": [],
    "created_at": "2025-02-09T12:00:00Z",
    "updated_at": "2025-02-09T12:00:00Z"
  }
]
```

### **Assignment Management**

#### **Get Assignments**

- **Endpoint:** `GET /api/assignments`
- **Response:**

```json
[
  {
    "_id": "60d21b4667d0d8992e610c85",
    "shift_id": 650e5f2a2b3d4c6a8f9e7d1d,
    "start": "2025-02-10 09:00",
    "end": "2025-02-10 17:00",
    "employee_id": "60d21b4667d0d8992e610c87"
  }
]
```

#### **Update Assignment**

- **Endpoint:** `POST /api/assignments/update`
- **Request Body:**

```json
{
  "employee_ids": ["650e5f2a2b3d4c6a8f9e7d1b", "650e5f2a2b3d4c6a8f9e7d1c"],
  "shift_id": "650e5f2a2b3d4c6a8f9e7d1d"
}
```

- **Response:**

```json
{
  "message": "Assignments updated successfully"
}
```

#### **Auto Assign Employees**

- **Endpoint:** `POST /api/assignments/auto-assign`
- **Response:**

```json
{
  "message": "Employees auto assigned successfully"
}
```

## **Conclusion**

This API serves as the backend for the Smart Shift Scheduler, managing employees, shifts, and assignments efficiently. Ensure the API is secured with proper authentication and validation checks for smooth functionality.

