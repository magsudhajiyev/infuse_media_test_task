
# Visitor Tracker

Visitor tracker is an application that tracks the visitor data and stores them in database.




## Installation

After cloning the project, set up the database and give db credentials in corresponding lines in banner.php file. 

Navigate to MySQL console and run the following command to create database and insert the sample data specified in database.sql file:

```bash
mysql -u your_username -p your_database_name < database.sql

```


Afterwards, run the project with following command:

```bash
php -S localhost:8000
```
    
## Features

- Detecting the page_url that visitor visited.
- Keeping track of the user's visit count.
