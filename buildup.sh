#!/bin/bash

#docker compose up --build

./npm.sh install

docker compose up --build -d

./composer.sh install