#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

# Nuskaityti host IP adresą (Linux/macOS)
HOST_IP="${APP_BASE_URL:-}"
if [ -z "$HOST_IP" ]; then
    # Automatinis detektavimas: pirmas nešiupaš IP (ne loopback)
    if command -v hostname &> /dev/null; then
        HOST_IP=$(hostname -I | awk '{print $1}')
    fi
    if [ -z "$HOST_IP" ] || [ "$HOST_IP" = "127.0.0.1" ]; then
        HOST_IP="localhost"
    fi
fi

BASE_URL="http://${HOST_IP}:8080/"

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🐳 Pradedame Docker konteineryje..."
echo "📍 Base URL: $BASE_URL"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

export APP_BASE_URL="$BASE_URL"
docker compose up -d --build

echo "Laukiama, kol aplikacijos konteineris bus pasiekiamas..."
sleep 8

docker compose exec app php spark migrate --all

if [ "${1:-}" = "--seed" ]; then
    docker compose exec app php spark db:seed DemoSeeder
fi

echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "✅ Projektas paleistas!"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🌐 Pasiekiama iš šios mašinos: http://localhost:8080"
echo "🌐 Pasiekiama iš VU tinklo:    http://${HOST_IP}:8080"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

if [ "${1:-}" = "--seed" ]; then
    echo "👤 Demo prisijungimas: sysadmin@example.test / Pamoka123"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
fi
