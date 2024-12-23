# Symfony rest api application

- This API is developed using the framework [Symfony](https://symfony.com/) version 6.2
- This API is secured using `X-Auth-Token`
- Fos Rest Bundle
  [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle)

- `Makefile` is included for easy testing. To see different commands, run

```shell
make help
```

- A `Postman` collection is included to test different endpoints of the api.

```
./docs/postman_collection.json // Contain a collection of endpoints.
./docs/postman_environnement.json // The environment variables.
```

## Test this API

1. Clone the project using the following command :

```shell
git clone https://github.com/rhidja/symfony-rest-api.git
```

2. Go to the project directory 

```shell
cd symfony-rest-api/
```

3. Then run the following `make` command to start the application

```shell
make init
```

This command will:

- Run `composer install`.
- Drop the old database if it exists.
- Create a new database.
- Run migrations.
- Import fixtures
- And start the Symfony local server. [https://127.0.0.1:8000](https://127.0.0.1:8000/)

4. To see different endpoints of the api [https://127.0.0.1:8000/api/doc](https://127.0.0.1:8000/api/doc/)

5. Import the `Postman` the two json files above, included in the project, collection above to test the api Utiliser Postman pour explorer l'API.

8. Une collection Postman est incluse dans ce projet. Importer les dans Postman
