
# create docker image for web application and push to docker hub
docker_web.build:
	docker build \
		--no-cache \
		-t \
 		wiotrek/electronic-diary-web:latest -f web/Dockerfile web/.

	docker push wiotrek/electronic-diary-web:latest


# create docker image for web application and push to docker hub
docker_api-server.build:
	docker build \
		--no-cache \
		-t \
 		wiotrek/electronic-diary-api-server:latest -f api-server/Dockerfile api-server/.

	docker push wiotrek/electronic-diary-api-server:latest