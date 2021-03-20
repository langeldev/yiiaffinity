#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE yiiaffinity_test;"
    psql -U postgres -c "CREATE USER yiiaffinity PASSWORD 'yiiaffinity' SUPERUSER;"
else
    [ "$1" = "test" ] || sudo -u postgres dropdb --if-exists yiiaffinity
    sudo -u postgres dropdb --if-exists yiiaffinity_test
    [ "$1" = "test" ] || sudo -u postgres dropuser --if-exists yiiaffinity
    [ "$1" = "test" ] || sudo -u postgres psql -c "CREATE USER yiiaffinity PASSWORD 'yiiaffinity' SUPERUSER;"
    [ "$1" = "test" ] || sudo -u postgres createdb -O yiiaffinity yiiaffinity
    [ "$1" = "test" ] || sudo -u postgres psql -d yiiaffinity -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O yiiaffinity yiiaffinity_test
    sudo -u postgres psql -d yiiaffinity_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    [ "$1" = "test" ] && exit
    LINE="localhost:5432:*:yiiaffinity:yiiaffinity"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
