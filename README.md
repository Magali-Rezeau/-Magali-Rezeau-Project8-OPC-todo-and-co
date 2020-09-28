Project8-OPC-todo-and-co


To do list is an application for managing daily tasks.

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/96f87c9203134a9fb395def23527de46)](https://www.codacy.com/manual/Magali-Rezeau/Project8-OPC-todo-and-co/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Magali-Rezeau/Project8-OPC-todo-and-co&amp;utm_campaign=Badge_Grade)

## Installation
1. Clone and download the repository GitHub :
```
    git clone https://github.com/Magali-Rezeau/Project8-OPC-todo-and-co.git
```
2. Configure your environment variables such as connection to the database or your SMTP server or email address in the file `.env`.

3. Download and install the back-end dependencies of the project with [Composer](https://getcomposer.org/download/) :
```
    composer install
```
4. Create the database if it does not already exist, type the command below :
```
    php bin/console doctrine:database:create
```
5. Create the different tables in the database by applying migrations :
```
    php bin/console doctrine:migrations:migrate
```
6. Install fixtures to have a fictional data demo :
```
    php bin/console doctrine:fixtures:load
```
