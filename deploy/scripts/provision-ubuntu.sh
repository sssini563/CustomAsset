#!/usr/bin/env bash
set -euo pipefail

# Provision Ubuntu 22.04+ with Docker Engine and Compose plugin
# Usage: sudo bash provision-ubuntu.sh

if [[ $EUID -ne 0 ]]; then
  echo "Please run as root: sudo bash provision-ubuntu.sh" >&2
  exit 1
fi

apt-get update -y
apt-get install -y ca-certificates curl gnupg lsb-release
install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
chmod a+r /etc/apt/keyrings/docker.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  tee /etc/apt/sources.list.d/docker.list > /dev/null

apt-get update -y
apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

systemctl enable --now docker
usermod -aG docker ${SUDO_USER:-$USER}

echo "Docker installed. You may need to log out and back in for group changes to take effect."
