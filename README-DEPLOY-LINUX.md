# Deploy Snipe-IT (custom) to Linux (Ubuntu)

This repository contains your custom Snipe-IT. These steps deploy it to a Linux server using Docker Compose, without relying on Docker Desktop.

## What you'll deploy
- MariaDB 10.11 (managed by Compose)
- Your app image built from the official Snipe-IT base (Dockerfile.overlay)
- Persistent volumes for DB, uploads, and logs

## Prereqs on the server (Ubuntu 22.04+)
1) Copy the `deploy/` folder to the server, plus any custom assets needed.
2) Provision Docker + Compose plugin:

```bash
cd deploy/scripts
sudo bash provision-ubuntu.sh
```

3) Prepare folders (recommended layout):

```bash
sudo mkdir -p /opt/snipeit/{deploy,data/uploads,data/storage/logs}
sudo chown -R $USER:$USER /opt/snipeit
```

## Transfer your project
Choose one:

- Git (recommended): push your repo and clone on server:
  ```bash
  cd /opt/snipeit
  git clone <your-repo-url> .
  ```

- rsync/scp tarball (exclude heavy dirs):
  ```bash
  # from your workstation
  rsync -av --delete \
    --exclude '.git' --exclude 'node_modules' --exclude 'vendor' --exclude 'data' \
    ./ user@server:/opt/snipeit/
  ```

Ensure the following exist on server:
- `/opt/snipeit/deploy/docker-compose.prod.yml`
- `/opt/snipeit/Dockerfile.overlay`

## Configure environment
Create `/opt/snipeit/deploy/.env` based on the sample:

```bash
cd /opt/snipeit/deploy
cp .env.example.prod .env
# Edit .env and set: APP_KEY, APP_URL, DB creds, etc.
```

Generate an app key if needed:
```bash
# one-off container run to print a key
docker compose -f docker-compose.prod.yml run --rm app php artisan key:generate --show
# copy the printed key into .env as APP_KEY=
```

## Build and start
From `/opt/snipeit/deploy`:

```bash
# Build the custom overlay image (bakes your code)
docker compose -f docker-compose.prod.yml build app

# Start DB first
docker compose -f docker-compose.prod.yml up -d mariadb

# Start the app
docker compose -f docker-compose.prod.yml up -d app
```

## Initialize database
Run migrations and create the first admin user:

```bash
# Clear caches then migrate (optional clears for safety)
docker compose -f docker-compose.prod.yml run --rm app php artisan cache:clear

docker compose -f docker-compose.prod.yml run --rm app php -d memory_limit=-1 artisan migrate --force --no-interaction

# Create super admin
# You will be prompted for details
docker compose -f docker-compose.prod.yml run --rm app php artisan snipeit:create-admin
```

Open your site: `http://<server-ip-or-domain>`

## Updates / Redeploys
When you change code:

```bash
cd /opt/snipeit/deploy
# Rebuild image with your latest code
docker compose -f docker-compose.prod.yml build app
# Restart app only
docker compose -f docker-compose.prod.yml up -d app
```

If you changed dependencies in composer.json inside your project, prefer to keep them aligned with the base image. For larger changes, consider building a full custom image that runs composer inside the image build (not included here to keep things simple).

## Logs & troubleshooting

```bash
# App logs
docker logs -f snipeit-app

# DB logs
docker logs -f snipeit-mariadb

# HTTP probe (server)
curl -I http://127.0.0.1/
```

Common issues:
- "service apache2 restart" prompts: use `apache2ctl -k graceful` inside container or simply restart the container.
- DB connection errors: verify deploy/.env matches DB values and that `DB_HOST=mariadb`.
- Permission issues on uploads/logs: ensure host folders are writable by the container (`www-data`).

## Optional HTTPS
Terminate TLS with Nginx/Caddy in front of the app (recommended). Keep the container on HTTP and reverse proxy handles TLS.
