# Project : "XM TEST"

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
 
###1
    If any NGINX or PostgreSQL services are already running on the same ports,
        then the up of containers will not happen.

###2
    If there is no SERVICE name in docker-compose or docker compose,
        the console command will not start, because the command is launched in the container by it.