#!/usr/bin/env bash

set -ex

DIR=$(dirname "$0")
cd $DIR/..

echo "Executing startup..."

echo "Installing dependencies..."
composer install

echo "Installing migrations..."
bin/console doctrine:migrations:migrate -n