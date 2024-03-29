# Task Backend

Task Backend is a PHP-based project that provides essential user authentication and authorization functionalities. It includes user registration, login, token refresh, authentication, and user profile retrieval.


## Overview

The project is designed to serve as a backend for applications requiring user management. It leverages core PHP principles, object-oriented programming, and secure authentication practices. The implementation follows industry-standard security practices to ensure the protection of user data.

## Features

- **User Registration**: Endpoint for registering new users. Passwords are securely hashed before storage.

- **Login**: Authentication endpoint that validates user credentials and issues a JSON Web Token (JWT) upon successful login.

- **Token Refresh**: Mechanism for refreshing JWT tokens without re-authentication, addressing token expiration.

- **User Authentication**: Endpoint for validating user credentials against the database, ensuring secure access to protected resources.

- **User Profile Retrieval**: Endpoint to fetch user profile information using JWT authentication.

## Installation

To get started, follow the [Installation](#installation) and [Database Setup](#database-setup) sections in the documentation.

## API Endpoints

Detailed information about available API endpoints can be found in the [API Endpoints](#api-endpoints) section. It includes examples of requests and responses for each endpoint.




## Table of Contents

- [Overview](#overview)
- [Installation](#installation)
- [Environment Config](#environment-config)
- [Database Setup](#database-setup)
- [API Endpoints](#api-endpoints)
- [Testing](#testing)
- [Folder Structure](#folder-structure)


## Overview

Provide a concise overview of your project, its purpose, and any key features. Mention the technologies used, if applicable.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/fathah/task-backend.git
   ```

2. Install dependencies using Composer:
     ```bash
    composer install
    ```

3. Set up your database. (Refer to the [Database Setup](#database-setup) section)

4. Configure Environment Variables.

5. Configure your API by editing the necessary configuration files.

## Environment Config
Secrets are stored in a `.env` file. Configure the variables as per the requirements. Following are the required variables for this project.

```bash
DB_HOST = "db_host"
DB_USER = "db_user"
DB_PASSWORD = "db_pass"
DB_DATABASE = "task_db"
JWT_SECRET = "jwt_secret_code"
```


## Database Setup

* Setup a MySQL database.
* Import ([schema.sql](schema.sql)) SQL to the database.
* Configure the credentials `.env` file.



## API Endpoints
Setup the local/prod environement and access the api through `/api` route.
```
http(s)://{baseurl}/v1/{api_endpoint}
```
### Authentication

- **Register User**
  - Endpoint: `/api/auth/register.php`
  - Method: `POST`
  - Description: Register a new user.
  - Request Body:
    ```json
    {
      "email": "user@example.com",
      "password": "userpassword",
      "role": "user"
    }
    ```
- **Login**
  - Endpoint: `/api/auth/login.php`
  - Method: `POST`
  - Description: Authenticate and get a JWT token.
  - Request Body:
    ```json
    {
      "email": "user@example.com",
      "password": "userpassword"
    }
    ```

### User Profile

- **Get User Profile**
  - Endpoint: `/api/user/profile.php`
  - Method: `GET`
  - Description: Get user profile information.
  - Authentication: Bearer Token

### Token Refresh

- **Refresh Token**
  - Endpoint: `/api/auth/refresh-token.php`
  - Method: `POST`
  - Description: Refresh an expired JWT token.
  - Authentication: Bearer Token

## Testing
To ensure the correctness of your application, you can run the provided PHPUnit tests. Make sure you have PHPUnit installed. If not, you can install it using Composer:

```bash
composer require --dev phpunit/phpunit
```

### Running Tests
1. Open a terminal window and navigate to the project root directory.
2. Run the PHPUnit tests:
```bash
vendor/bin/phpunit
```

This command will execute all the test cases in the tests directory.

### Test Cases
#### Authentication Endpoint
```bash
vendor/bin/phpunit v1/tests/EndpointTest.php --filter testAuthenticationEndpoint
```
#### Registration Endpoint
```bash
vendor/bin/phpunit v1/tests/EndpointTest.php --filter testRegistrationEndpoint
```

#### Token Refresh Endpoint
```bash
vendor/bin/phpunit v1/tests/EndpointTest.php --filter testTokenRefreshEndpoint
```

#### User Profile Endpoint
```bash
vendor/bin/phpunit v1/tests/EndpointTest.php --filter testUserProfileEndpoint
```

## Folder Structure

```
- /v1/api              # API Entry Directory
- /v1/src              # Source code files
- /v1/tests            # Unit tests
- /vendor              # Composer Packages
- .env                 # Environment variables (gitignored)
- .gitignore           # Gitignore file
- README.md            # Project documentation
- composer.json        # Composer configuration
- packages.php         # Packages Inclusion Header File
```

## Disclaimer
This project is made for the interview task for _Smucci Vapes, UAE_