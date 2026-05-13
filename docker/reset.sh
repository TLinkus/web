#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

docker compose down -v
docker compose up -d --build
sleep 8
docker compose exec app php spark migrate --all
docker compose exec app php spark db:seed DemoSeeder

echo "Duomenų bazė perkurta ir užpildyta demo duomenimis."
