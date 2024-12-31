# Symfony REST API

This is a REST API built using [Symfony](https://symfony.com/) famework, providing various endpoints to interact
with a system (e.g., users, fames places, etc.). This API is secured using `X-Auth-Token`

I developed this API by following the
[Create a REST API with Symfony 3](https://zestedesavoir.com/tutoriels/1280/creez-une-api-rest-avec-symfony-3/) 
tutorial by Zest du Savoir, to learn the essential principles of REST. Then, I upgraded it to Symfony
4 and later to Symfony 6 by following the
[Upgrading to Symfony 6.0](https://symfonycasts.com/screencast/symfony6-upgrade/upgrade-symfony6)
tutorial by Symfony Cast.

## Table of Contents

This guide will walk you through setting up the project, running the server, and testing the API.

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [API Documentation](#api-documentation)
- [Testing the API](#testing-the-api)

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP (8.1 or higher)
- Composer
- Symfony CLI (optional but recommended)
- Database (MySQL, etc., depending on your setup)

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/rhidja/symfony-rest-api.git
   cd symfony-rest-api

3. Then run the following `make` command to install the application

```shell
make init
```

This command will:

- Run `composer install`.
- Drop the old database if it exists.
- Create a new database.
- Run migrations.
- Run fixtures
- And start the Symfony local server. [https://127.0.0.1:8000](https://127.0.0.1:8000/)

## Running the Application

- A `Postman` collection is included to test different endpoints of the api.

```
./docs/postman_collection.json // Contain a collection of endpoints.
./docs/postman_environnement.json // The environment variables.
```

## API Documentation

To see different endpoints of the api [https://127.0.0.1:8000/api/doc](https://127.0.0.1:8000/api/doc/)

## Testing the API
