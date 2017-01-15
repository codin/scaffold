default:
	make build && make run

build:
	docker-compose build

run: 
	docker-compose up