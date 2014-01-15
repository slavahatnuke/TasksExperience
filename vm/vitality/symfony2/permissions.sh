#!/bin/bash

#sudo mount -o remount,acl /home/vagrant/project/

#APACHEUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data' | grep -v root | head -1 | cut -d\  -f1`
#sudo setfacl -R -m u:"$APACHEUSER":rwX -m u:`whoami`:rwX app/cache app/logs
#sudo setfacl -dR -m u:"$APACHEUSER":rwX -m u:`whoami`:rwX app/cache app/logs


sudo rm -rf app/cache/* app/logs/*

sudo chmod 777 -R app/cache app/logs

sudo chmod 777 app/console