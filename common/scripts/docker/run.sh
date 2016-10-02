#!/usr/bin/env bash

# stop and remove old containers
docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)

# join all services via network
sudo docker network create docker.network

# build and run eventbus (redis server in current implementation)
sudo docker build -t eventbus:latest /vagrant/eventbus/
sudo docker run --net=docker.network --name eventbus -p 6379:6379 -d eventbus:latest

# build and run subscriber service (implementation of component 'Б', who listen messages)
sudo docker build -t subscriber:latest /vagrant/subscriber/
sudo docker run --net=docker.network --name subscriber -d subscriber:latest



#sudo docker build -t publisher:latest /vagrant/publisher/
#sudo docker run --net=docker.network --name publisher -d publisher:latest