# Lead Ingestion Task

## Overview

This repository contains a Symfony-based application designed to ingest leads. It includes functionality for creating, tagging, validating, and storing lead information, as well as maintaining a history of keepers for each lead.
It also includes a couple of unit and integrations tests.

## Requirements

- PHP >= 8.2
- Composer
- PostgreSQL (or another database supported by Doctrine)

## Installation

1. **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd lead-ingestion
    ```

2. **Install dependencies:**
    ```bash
    composer install
    ```

3. **Set up environment variables:**
    Copy the `.env` file and adjust the settings as needed:
    ```bash
    cp .env .env.local
    ```

4. **Set up the database:**
    Ensure your database is running and the connection parameters in `.env.local` are correct. Then run:
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

5. **Run the application:**
    ```bash
    symfony server:start
    ```

## Running Tests

### Integration Tests

Integration tests are located in `tests/integration`. To run them, use:
```bash
php bin/phpunit tests/integration
```

### Unit Tests

Unit tests are located in `tests/unit`. To run them, use:
```bash
php bin/phpunit tests/unit
```

## Project Structure

- **`src/Controller`**: Contains the controllers for handling HTTP requests.
- **`src/Entity`**: Contains the Doctrine ORM entities.
- **`src/Repository`**: Contains the repositories for accessing the database.
- **`src/Service`**: Contains the business logic.
- **`tests`**: Contains the test cases.

## Key Files

### `LeadController.php`
Handles the creation of leads and returns appropriate responses based on the success or failure of the operation.

### `LeadService.php`
Contains the business logic for creating leads, including validation and tagging.

### `Lead.php`
Defines the `Lead` entity with validation constraints.

### `LeadApiTest.php`
Simple Integration tests for the `LeadController` api which will test all the layers including the DB.

### `LeadServiceTest.php`
Simple Unit tests for the `LeadService` specifically testing the tagging of lead and mocks other services and dependencies.



## Database Migrations
Database migrations are managed using Doctrine Migrations. Migration files are located in the `migrations` directory.

## Configuration

### Doctrine Configuration
Doctrine ORM and DBAL configurations are located in `config/packages/doctrine.yaml`.

## Contact
For any inquiries, please contact me at rehan.ullah.uk@gmail.com

---

This README provides a high-level overview of the project. For more detailed understanding, please refer to the source code.