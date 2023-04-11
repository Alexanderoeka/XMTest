# Project : "XM TEST"

## Application Deployment Steps

#### 1

    Copy .env.dist to .env in main and api derictory

#### 2

    Execute ./buildup.sh command

#### 3

    Execute ./migrate.sh command

#### 4

    Execute ./get_companies.sh

## BASIC

Build whole project:

    ./buildup.sh

Get the composer and npm dependencies, respectively:

    ./composer.sh install
    ./npm.sh install

Create a new migration and fill in migrations :

    ./make_migration.sh
    ./migrate.sh

Up or down project:

    ./up.sh
    ./down.sh

Check condition of containers:

    ./ps_docker_compose.sh

Execute some command inside container of php :

    ./console.sh

Go inside the container by name SERVICE:

    ./exec_docker.sh

Clean cache of Symfony api:

    ./clear_cache.sh

Set companies to DB from remote json for hints:

    ./get_companies.sh

Execute tests for project:

    ./test.sh

Profiler at: `http://localhost/_profiler/`

Mailer at: `http://localhost:1080/`

## Possible incidents

### 1

    If any NGINX or PostgreSQL services are already running on the same ports,
        then the up of containers will not happen.

### 2

    If there is no SERVICE name in docker-compose or docker compose,
        the console co  mmand will not start, because the command is launched in the container by it.

### 3

    Commands that connected with docker mightn't execute without sudo.
         Depends on how you configured docker before

## Explanation about I did about architecture:

### 1

    Backend based on the DDD principle. Because it allows you to conveniently 
     expand the functionality of the application.

### 2

    Separate Common folder for the basic functionality

### 3

    Divisions into different data types in the form of DateTimeRange,
     different Dto and Transformers

### 4

    Different types of errors for the subsequent determination of the causes
     of the application failure

### 5

    Handler that catches exceptions, including Dto exceptions. 
     What makes the controller methods look cleaner

### 6

    Separate layers inside the domain and common, for example Factory and Request.
     What to take out logic and does not clog up the code

### 7

    Data providers for integration testing, which allows you to more clearly
     define the functionality of the application

### 8

    Prepared a test environment for testing in the form of integration tests 
     using dama/doctrine-test-bundle. To return the database to its original 
     form between each test and at the end of testing (which, in principle, was 
     not needed as part of the current tasks)

### 9

    A console command that allows you to get data for prompts when entering data in the 
     company search field.

### 10

    Implemented it in BaseService via autowire EntityManager, wrapped it in 
     the persist remove flush function, for convenient work with data 
     (which was not needed as part of the tasks)

### 11

    Frontend based on React and Typescript. Because this makes it very convenient to expand 
     the frontend of the application and handle its state.


## Haven't implemented because of time

### 1

    Good strict types for frontend Typescript. 
     Didnt make good separate components styles and etc.

### 2

    Didnt make good enough test, for instance: coverage of unitTests

### 3

    Did not make an architecture for extending events by sending messages