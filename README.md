# **Smart Shift Scheduler - Backend API**

## **Overview**

Smart Shift Scheduler Backend API is built using Laravel, MongoDB, and
Sanctum for authentication. It provides endpoints for managing employee
shifts and assignments.

## **Setup Instructions**

### **Prerequisites**

Ensure you have the following installed:

-   PHP (version 8.2.21)

-   Laravel Framework (version 10)

-   MongoDB

-   Composer

-   Sanctum for API authentication

### **Installation**

**Clone the repository**:

> git clone https://github.com/hariceiocod/smart-shift-scheduler-api.git
>
> cd smart-shift-scheduler-api

**Install dependencies:**

> composer install

**Configure environment variables:**

> cp .env.example .env

**Update the necessary fields, particularly the MongoDB connection
settings in** .env:

> DB_CONNECTION=mongodb
> 
> DB_HOST=127.0.0.1
> 
> DB_PORT=27017
> 
> DB_DATABASE=your_database
> 

**Install and configure Sanctum:**

> php artisan vendor:publish --provider=\"Laravel\\Sanctum\\SanctumServiceProvider\"

> php artisan migrate

**Run the Admin Seeder:**

> php artisan db:seed \--class=AdminSeeder

**Start the backend server:**

> php artisan serve

## **API Documentation**

### **Authentication**

#### **Register**

**Endpoint:** POST /api/register

**Request Body:**

{

\"name\": \"John Doe\",

\"email\": \"user@example.com\",

\"password\": \"yourpassword\",

\"max_hours_per_week\": 40,

\"availability\": \[\"Monday\", \"Tuesday\", \"Wednesday\"\]

}

**Response:**

{

\"message\": \"User registered successfully\",

\"id\": \"650e5f2a2b3d4c6a8f9e7d1b\",

\"name\": \"John Doe\",

\"email\": \"user@example.com\",

\"role\": \"employee\",

\"max_hours_per_week\": 40,

\"availability\": \[\"Monday\", \"Tuesday\", \"Wednesday\"\],

\"created_at\": \"2025-02-09T12:00:00Z\",

\"updated_at\": \"2025-02-09T12:00:00Z\",

\"token\": \"your-auth-token\"

}

#### **Login**

**Endpoint:** POST /api/login

**Request Body:**

{

\"email\": \"user@example.com\",

\"password\": \"yourpassword\"

}

**Response:**

{

\"message\": \"User logged in successfully\",

\"token\": \"your-auth-token\"

}

#### **Logout**

**Endpoint:** POST /api/logout

**Headers:**

{

\"Authorization\": \"Bearer your-auth-token\"

}

**Response:**

{

\"message\": \"Successfully logged out\"

}

###**Shift Management**

**Get Shifts**

Endpoint: GET /api/shifts

**Response:**

[
  {
    "_id": "60d21b4667d0d8992e610c85",
    "date": "2025-02-10",
    "start_time": "09:00",
    "end_time": "17:00",
    "max_employees": 10,
    "assigned_employees": [],
    "conflict": false,
    "conflict_message": ""
  }
]

**Create Shift**

Endpoint: POST /api/shifts/create

**Request Body:**

{
  "date": "2025-02-10",
  "start_time": "09:00",
  "end_time": "17:00",
  "max_employees": 10
}

**Response:**

{
  "message": "Shift created successfully"
}

**Update Shift**

Endpoint: PATCH /api/shifts/update

**Request Body:**

{
  "shift_id": "60d21b4667d0d8992e610c86",
  "date": "2025-02-11",
  "start_time": "10:00",
  "end_time": "18:00",
  "max_employees": 12
}

**Response:**

{
  "message": "Shift updated successfully"
}

**Delete Shift**

Endpoint: DELETE /api/shifts/delete

**Request Body:**

{
  "shift_id": 1
}

**Response:**

{
  "message": "Shift deleted successfully"
}


### **Employee Management**

#### **Get Employees**

**Endpoint:** GET /api/employees

**Headers:**

{

\"Authorization\": \"Bearer your-auth-token\"

}

**Response:**

\[

{

\"id\": \"650e5f2a2b3d4c6a8f9e7d1b\",

\"name\": \"John Doe\",

\"email\": \"user@example.com\",

\"max_hours_per_week\": 40,

\"availability\": \[\"Monday\", \"Tuesday\", \"Wednesday\"\],

\"assigned_shifts\": \[\],

\"conflict\": false,

\"created_at\": \"2025-02-09T12:00:00Z\",

\"updated_at\": \"2025-02-09T12:00:00Z\"

}

\]

### **Assignment Management**

#### **Update Assignment**

**Endpoint:** POST /api/assignments/update

**Request Body:**

{

\"id\": \"650e5f2a2b3d4c6a8f9e7d1b\",

\"employee_ids\": \[\"650e5f2a2b3d4c6a8f9e7d1b\",
\"650e5f2a2b3d4c6a8f9e7d1c\"\],

\"shift_id\": \"650e5f2a2b3d4c6a8f9e7d1d\"

}

**Response:**

{

\"message\": \"Assignments updated successfully\"

}

#### **Auto Assign Employees**

**Endpoint:** POST /api/assignments/auto-assign

**Response:**

{

\"message\": \"Employees auto assigned successfully\"

}

## **Conclusion**

This API serves as the backend for the Smart Shift Scheduler, managing
employees, shifts, and assignments efficiently. Make sure to secure the
API with proper authentication and validation checks for smooth
functionality.
