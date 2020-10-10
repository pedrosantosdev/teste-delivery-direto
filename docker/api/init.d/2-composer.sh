#!/bin/bash
    composer clearCache
if [ "false" == "$APP_DEBUG" ]; then
    composer install --no-plugins --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader
else
    composer install --no-plugins --no-scripts --optimize-autoloader
fi
