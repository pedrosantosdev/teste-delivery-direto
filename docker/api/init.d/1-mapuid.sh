#!/bin/bash
echo 'RUN MAPUID'
set -e

# Change uid and gid of www-data to match current dir's owner

uid=1000
gid=1000

     usermod -u $uid www-data 2> /dev/null && {
      groupmod -g $gid www-data 2> /dev/null || usermod -a -G $gid www-data
    }
    
    sed -ri "s/^www-data:x:82:82:/www-data:x:$uid:$gid:/" /etc/passwd


echo UID: $(id -u 'www-data')
echo GID: $(id -g 'www-data')