docker pull ghcr.io/naaando/planningpoker:master
docker run --name=planningpoker -d -p 9001:80 --env-file .env --add-host=host.docker.internal:host-gateway ghcr.io/naaando/planningpoker:master
