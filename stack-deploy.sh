#!/bin/bash

# TESTANDO COISAS DIFERENTES AQUI
echo "----------------------------"
echo "-- Atualizando o ambiente --"
echo "----------------------------"
apt update -y
apt install -y nano git zip unzip jq

echo "-------------------------"
echo "-- Instalando o docker --"
echo "-------------------------"
apt install -y docker.io

# DOCKER COMPOSE - UBUNTU X86
echo "--------------------------------"
echo "-- Instalado o docker compose --"
echo "--------------------------------"
apt install -y docker-compose

# REMOVE TODAS AS IMAGENS E CONTAINERS DA VM
echo "------------------------------------"
echo "-- Removendo resíduos de serviços --"
echo "------------------------------------"
docker system prune -a -f

docker_compose_file=/answer.app/docker/docker-compose.yaml

echo "------------------------------"
echo "-- Incializando os serviços --"
echo "------------------------------"
docker-compose -f $docker_compose_file up