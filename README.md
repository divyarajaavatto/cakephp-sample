## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication

TODO: pls summarize how to check "Authentication" bahavior
1. If user is not exisit in the database, we have provision to add user in the database.
2. Regarding login, user has to pass correct email address and password then only user can access the portal as requested.
3. E.G. email : divyaraj@gmail.com and password: 123456789
4. Once user login user can see the artical list.
5. User can also logout from the application

### Article Management

TODO: pls summarize how to check "Article Management" bahavior

1. After login user can see the all the articles from the database.
2. Creted endpoints for CRUD as requested (List, Add, Edit, View and Delete).
3. For the postman collection required bearear token to pass in header, so for that you hvae to login using (http://localhost:34251/api/users/login.json)
4. Attach postman colletion for reference to check endpoints for article management.


### Like Feature
1. Once user login, User can like the Article listed in application.
2. Once user like the  Article, he can not further like the article and unlike the article as requested.
3. We show the total number of like in article list.
4. I have created migration for Like table migration if it will not work then you can refer attached sql file.


CREATE TABLE likes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        article_id INT,
        created_at DATETIME,
        updated_at DATETIME,
        FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );


TODO: pls summarize how to check "Like Feature" bahavior
