#!/bin/bash

#docker run -it -d php php bin/console $@
#docker compose run php php bin/console $@
docker compose exec -ti php php bin/console $@


#DOCKER_COMPOSE_EXIST=$(which docker-compose)
#
#if [ -z "$DOCKER_COMPOSE_EXIST" ]; then
#  docker compose exec -ti php php bin/console $@
#else
#  docker-compose exec -ti php php bin/console $@
#fi


#  docker compose exec -ti -e XDEBUG_CONFIG="" php php bin/console $@