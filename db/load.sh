#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U yiiaffinity -d yiiaffinity < $BASE_DIR/yiiaffinity.sql
    if [ -f "$BASE_DIR/yiiaffinity_test.sql" ]; then
        psql -h localhost -U yiiaffinity -d yiiaffinity < $BASE_DIR/yiiaffinity_test.sql
    fi
    echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U yiiaffinity -d yiiaffinity
fi
psql -h localhost -U yiiaffinity -d yiiaffinity_test < $BASE_DIR/yiiaffinity.sql
echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U yiiaffinity -d yiiaffinity_test
