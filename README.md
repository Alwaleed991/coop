First, how to run the project?

Prerequisites:
PHP 8.1+
Composer
sqlite (or compatible database)

steps:
1- clone the rebo 
2- Install dependencies using composer install 
3- create the .env file and configure your database in the .env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
4- php artisan migrate:fresh --seed
5- Start the server in laragon, docker desktop, Xamp, etc ... 
6- the api will be avalable on this url http://localhost:8000/api/v1

---------------------------------------------------------------------------------------------------------
Second, Authentication Approach

Authentication was implemented using Sanctum with token-based authentication.

steps:
1- User registers or logs in
2- The server provide a personal access token
3- The client stores the token
4- The token is sent with each request using Authorization header 

Note/ all api end-points are private and required authentication

---------------------------------------------------------------------------------------------------------
Third, Database Structure

The system consists of three core entities:

1- Users
id(PK), name, email (unique), password

2- Posts
id(PK), title, body, user_id(FK → id)

3- Comments
id(PK), body, user_id(FK → user_id), post_id(FK → post_id)

Relationships:
One User can have many Posts
One User can have many Comments
One Post can have many Comments

Note/foreign keys and cascade delete rules are used to maintain data integrity.
Note/the ERD diagram is included in the /docs directory.

---------------------------------------------------------------------------------------------------------
forth, Assumptions

1- The application is API-only (no front-end for now)
2- The client is responsible for rendering forms and UI and redirecting between the pages
4- All users must be authenticated to access API endpoints
5- Email uniqueness is enforced at both the database and validation levels
6- The system is Token base there is no using for the sessions or the cookies
