docker pull ghcr.io/naaando/planningpoker:master
docker rm -f planningpoker
docker run --name=planningpoker -d -p 9001:80 --restart=always --env-file .env --add-host=host.docker.internal:host-gateway ghcr.io/naaando/planningpoker:master
