#!/bin/bash

sudo apt-get update -y

sudo apt-get -y install python-software-properties python g++ make
sudo add-apt-repository -y ppa:chris-lea/node.js
sudo apt-get update -y

sudo apt-get -y install nodejs
sudo npm install -g vitality
