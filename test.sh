#!/bin/bash

#docker compose exec -ti php php bin/phpunit ./tests/Integration/IntegrationSomeTest.php
docker compose exec -ti php php bin/phpunit $@