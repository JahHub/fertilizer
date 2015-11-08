#!/bin/bash

CONFIGURATION='DEV'
DATABASE_HOST='127.0.0.1'
DATABASE_PORT='~'
DATABASE_USER='root'
DATABASE_PASSWORD='~'
SECRET='vpzICjj0bdGlY3zTzQXnUb81TmS5Mn1B18AWtpNKKA'

if [ ! -z "$TRAVIS" ]; then
    CONFIGURATION='TRAVIS'
    DATABASE_HOST='127.0.0.1'
    DATABASE_PORT='~'
    DATABASE_USER='root'
    DATABASE_PASSWORD='~'
elif [ ! -z "$SCRUTINIZER" ]; then
    CONFIGURATION='SCRUTINIZER'
    DATABASE_HOST='localhost'
    DATABASE_PORT='~'
    DATABASE_USER='root'
    DATABASE_PASSWORD='~'
fi

echo "Detected configuration : $CONFIGURATION"
echo "Parameters:"
echo -e "\t - DATABASE_HOST =>     '$DATABASE_HOST'"
echo -e "\t - DATABASE_PORT =>     '$DATABASE_PORT'"
echo -e "\t - DATABASE_USER =>     '$DATABASE_USER'"
echo -e "\t - DATABASE_PASSWORD => '$DATABASE_PASSWORD'"
echo -e "\t - SECRET =>            '$SECRET'"

echo "Creating app/config/parameters.yml"
sed \
    -e "s/\${DATABASE_HOST}/$DATABASE_HOST/" \
    -e "s/\${DATABASE_PORT}/$DATABASE_PORT/" \
    -e "s/\${DATABASE_USER}/$DATABASE_USER/" \
    -e "s/\${DATABASE_PASSWORD}/$DATABASE_PASSWORD/" \
    -e "s/\${SECRET}/$SECRET/" \
    app/config/parameters.yml.dist > app/config/parameters.yml
