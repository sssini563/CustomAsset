#!/usr/bin/env bash
set -euo pipefail

# Initialize host storage directories used by docker compose for Snipe-IT
# Run this on the host (Ubuntu) where docker compose will run.

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
DATA_DIR="$ROOT_DIR/data"

echo "Ensuring data directories under: $DATA_DIR"

mkdir -p "$DATA_DIR/storage/framework/views"
mkdir -p "$DATA_DIR/storage/framework/cache"
mkdir -p "$DATA_DIR/storage/framework/sessions"
mkdir -p "$DATA_DIR/storage/logs"
mkdir -p "$DATA_DIR/uploads"
mkdir -p "$DATA_DIR/snipeit"

# Try to set ownership to www-data (33:33). If sudo available use it.
chown_cmd="chown -R 33:33 \"$DATA_DIR\" || true"
if command -v sudo >/dev/null 2>&1; then
  echo "Setting owner to www-data using sudo"
  sudo chown -R 33:33 "$DATA_DIR" || true
else
  echo "sudo not found - attempting chown without sudo"
  $chown_cmd || true
fi

chmod -R 775 "$DATA_DIR" || true

# Create empty laravel.log if missing
if [ ! -f "$DATA_DIR/storage/logs/laravel.log" ]; then
  touch "$DATA_DIR/storage/logs/laravel.log"
  if command -v sudo >/dev/null 2>&1; then
    sudo chown 33:33 "$DATA_DIR/storage/logs/laravel.log" || true
  fi
fi

echo "Host storage initialized. You can now run: docker compose up -d"
