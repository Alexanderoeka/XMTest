#!/bin/bash



#VALU=$(docker compose ps -a node --filter "status=exited" | grep node >/dev/null)

if docker compose ps -a node --filter "status=exited" | grep node >/dev/null ;
then
  echo 'TRUE'
else
  echo 'FALSE'
fi

#DOCKER_COMPOSE_EXIST=$(which docker-compose)
#
#if [ -z "$DOCKER_COMPOSE_EXIST" ]; then
#  docker compose exec node yarn $@
#else
#  docker-compose exec node yarn $@
#fi