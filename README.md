# Learn how to secure a To Do app using authentication & authorization based on JSON Web Tokens (JWT)
### PHP Team Treehouse TechDegree project #8

- [The goal of this project](#the-goal-of-this-project)
- [Installation instructions](#installation-instructions)
- [Tech used](#tech-used)
- [Folder & file structure](#folder--file-structure)

## The goal of this project
#### To secure a To Do app to make sure users, after logging in, can only see & manage their own tasks

**Project instructions (all implemented):** 
- Allow new users to register for your application. Store the user's password as a hash.
- Add the ability for a user to login to your application
- Add the ability to log out of your application
- Allow users to update their password
- Assign all new tasks to the logged in user
- Only return tasks belonging to the logged in user
- Only the home, registration, and login pages should be accessible for unauthenticated visitors. All other pages should require authentication.
- Automatic login on registration
- Secure your logged in user with JWT

## Installation instructions
- Git clone https://github.com/FrederikHulleman/project8-todo-security.git 
- Place the repo in a web server of your choice (XAMPP for Windows, MAMP for Mac)
- After downloading this project, make sure you run the following composer command in the project folder to install the right packages on dev:
    ```bash
    composer install
    ```
- Then make sure composer autoloads all classes automatically by running this command:
    ```bash
    composer dump-autoload -o
    ```
- Register a user account, log in and you're ready to go!  

## Tech used
#### In this project the following main concepts, languages, frameworks, packages and other technologies are applied:
PHP | SQLite | Symfony HTTP Foundation | PHP JWT (firebase) | phpdotenv (vlucas)

## Folder & file structure
#### The most important folders & files within this project:

    .             
    ├── css                         # contains css files  
    ├── inc                         # contains database, bootstrap/settings files & function files 
    ├── procedures                  # contains php files which handle tasks, login, logout, registration & password changes
    ├── templates                   # contains header, footer & nav files 
    └── root                        # contains main php pages: home (index), login, register, account, task & task_list