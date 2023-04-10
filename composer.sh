#!/usr/bin/env bash



docker compose run php composer $@

docker compose rm php -f

#DOCKER_COMPOSE_EXIST=$(which docker-compose)
#if [ -z "$DOCKER_COMPOSE_EXIST" ]; then
#  docker compose exec -u user -e XDEBUG_CONFIG="" php composer $@
#else
#  docker-compose exec -u user -e XDEBUG_CONFIG="" php composer $@
#fi
