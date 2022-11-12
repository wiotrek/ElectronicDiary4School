
# create docker image for web application and push to docker hub
docker_web.build:
	docker build \
		--no-cache \
		-t \
 		wiotrek/electronic-diary-web:latest -f web/Dockerfile web/.

	docker push wiotrek/electronic-diary-web:latest