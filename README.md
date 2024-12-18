# Assessment

## Requirement

the requirement was to create api endpoint in laravel that will fetch data from any external api and insert that into our database and return the data as json

## Overview

The assessment endpoint is designed to synchronize user data from an external API (dummyjson.com) to the local database, with robust handling of existing users and error scenarios.

## Prerequisites

-   PHP 8.0+
-   Composer
-   Laravel Framework version 9
-   MySQL or PostgreSQL
-   Postman (optional, for API testing)

## Project Setup

### 1. Clone the Repository

```bash
git clone https://github.com/Amir-Zain/codeft
cd <project-directory>
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

1. Copy `.env.example` to `.env`

```bash
cp .env.example .env
```

2. Generate Application Key

```bash
php artisan key:generate
```

### 4. Database Configuration

1. Create Database

-   Open MySQL/PostgreSQL
-   Create a new database for the project

2. Update `.env` File

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=database_username
DB_PASSWORD=database_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

## Testing the Endpoint

1. Start Laravel Server

```bash
php artisan serve
```

Use Postman or cURL

```bash
curl http://localhost:8000/api/assessment
```

(alternate way)
open http://localhost:8000 in browser and click the 'API Link' button you can use an json formatter extension to view the json response

## Endpoint Specification

-   **Route:** `/api/assessment`
-   **HTTP Method:** GET

## Synchronization Process

### Data Source

-   External API: `https://dummyjson.com/users`
-   Fetches a list of users with comprehensive user details

### Synchronization Behavior

-   Checks for existing users by email
-   Updates existing users or creates new users
-   Prevents duplicate entries by using unique email constraint
-   Securely hashes user passwords

### Response Structures

#### Successful Response

```json
[
    {
        "id": 1,
        "first_name": "John",
        "last_name": "Doe",
        "phone": "1234567890",
        "age": 30,
        "height": 175.5,
        "weight": 70.25,
        "gender": "male",
        "email": "john.doe@example.com"
    }
    // ... more user objects
]
```

#### Error Responses

1. API Fetch Failure

```json
{
    "message": "Failed to fetch data",
    "error": "Detailed error message"
}
```

2. Internal Server Error

```json
{
    "message": "An error occurred during request",
    "error": "Detailed error message"
}
```
