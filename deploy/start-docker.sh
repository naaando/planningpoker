docker pull ghcr.io/naaando/planningpoker:master
docker run -dp 9001:80 --env-file .env ghcr.io/naaando/planningpoker:master
