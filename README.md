# Nerdery user-service
User management microservice

# To spin up the environment:
* `composer install`
* `docker-compose up -d`

# Postman collections (for developers)
* https://www.getpostman.com/collections/0e98ae90ce90fca6b359

# Endpoints:
| Endpoint                                          | Params                                       |
| :------------------------------------------------ | :------------------------------------------- |
| GET /user *(read details of a user)*              | id                                           |
| POST /user *(create a new user)*                  | first_name, last_name, email, image          |
| PUT /user/{id} *(update details of a user)*       | id, first_name, last_name, email, image      |
| DELETE /user/{id} *(delete a user)*               | id                                           |
| GET /user/search *(search users by name, email)*  | query (one of: first_name, last_name, email) |