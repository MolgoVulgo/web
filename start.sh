#!/bin/bash

echo "start symfony"
symfony server:stop
symfony server:start --no-tls -d
symfony open:local  
symfony server:log