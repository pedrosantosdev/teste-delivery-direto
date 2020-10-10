#!/bin/bash

echo "Rodando o supervisord"

/usr/bin/supervisord -n -c /etc/supervisord.conf
