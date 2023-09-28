#!/bin/bash

echo "Start MariaDB"
systemctl start mariadb

echo "start symfony"
symfony server:stop
symfony server:start --no-tls -d
symfony open:local  
symfony server:log