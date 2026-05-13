#!/usr/bin/env bash
set -euo pipefail

if [ "$(id -u)" -eq 0 ]; then
    SUDO=""
else
    SUDO="sudo"
fi

if ! command -v apt-get >/dev/null 2>&1; then
    echo "Šis skriptas skirtas Debian/Ubuntu Linux VM aplinkai su apt-get."
    exit 1
fi

echo "Atnaujinami paketai..."
$SUDO apt-get update

echo "Diegiami kompiliatoriai ir baziniai programavimo įrankiai..."
$SUDO apt-get install -y \
    build-essential \
    ca-certificates \
    cmake \
    curl \
    gcc \
    g++ \
    git \
    gnupg \
    lsb-release \
    make \
    pkg-config \
    software-properties-common \
    unzip \
    zip

if ! command -v docker >/dev/null 2>&1; then
    echo "Diegiamas Docker Engine..."
    $SUDO install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | $SUDO gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    $SUDO chmod a+r /etc/apt/keyrings/docker.gpg
    echo \
      "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
      $(. /etc/os-release && echo "$VERSION_CODENAME") stable" \
      | $SUDO tee /etc/apt/sources.list.d/docker.list > /dev/null
    $SUDO apt-get update
    $SUDO apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
else
    echo "Docker jau įdiegtas."
fi

$SUDO systemctl enable docker
$SUDO systemctl start docker

if [ -n "$SUDO" ]; then
    $SUDO usermod -aG docker "$USER"
    echo "Vartotojas $USER pridėtas prie docker grupės. Atsijunkite ir prisijunkite iš naujo, kad docker veiktų be sudo."
fi

docker --version || $SUDO docker --version
docker compose version || $SUDO docker compose version

echo "Linux VM paruošimas baigtas."
