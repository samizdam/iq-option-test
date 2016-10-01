#!/usr/bin/env bash

# stop and remove old containers
docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)

sudo docker build -t eventbus:latest /vagrant/eventbus/
sudo docker run --name eventbus -p 6379:6379 -d eventbus:latest

sudo docker build -t publisher:latest /vagrant/publisher/
sudo docker run --name publisher -d publisher:latest