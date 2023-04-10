# Project : "XM TEST"

##ОСНОВНОЕ 

Чтоб сбилдить весь проект:

    ./buildup.sh

Подтянуть зависимости composer и npm соответственно:

    ./composer.sh install
    ./npm.sh install

Залить миграций и создание новой миграции:

    ./migrate.sh
    ./make_migration.sh

Просто поднять или опустить проект:
    
    ./up.sh
    ./down.sh

Проверить состояние контейнеров: 

    ./ps_docker_compose.sh

Выполнить какую либо команду в контейнере php :

    ./console.sh

Зайти внутрь контейнера по имени SERVICE:

    ./exec_docker.sh



Профайлер по адресу: `http://localhost/_profiler/`

Майлер по адресу: `http://localhost:1080/`



## Возможные казусы 
 
###1
    Если уже запушены какие-либо сервисы типа NGINX или PostgreSQL на тех же портах,
    то подъем контейнеров не произойдет.

###2
    Если в docker-compose или docker compose не находится имени SERVICE,
    консольная команда не запуститься, тк запуск команды в контейнере происходит именно по нему.