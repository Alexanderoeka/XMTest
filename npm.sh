#!/usr/bin/env bash


docker compose run node npm $@

docker compose rm node -f
