#!/bin/bash
set -e
pwd
ls -la 
for f in ./docker/api/init.d/*.sh; do
    echo "RUN FILE: $f"
    . "$f"
done

exec "$@"