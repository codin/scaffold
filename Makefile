default:
	make build && make run

build:
	docker-compose build

ssh:
	docker exec -i -t scaffold_application /bin/bash

run: 
	docker-compose up