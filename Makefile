default:
	make build && make run

build:
	docker build -t codin/scaffold .

run: 
	docker run -a stdin -a stdout -i -t -p 80:80 codin/scaffold