# SprayWow

SprayWow is a Laravel eCommerce project for premium cleaning sprays, product browsing, blog content, user accounts, and admin management.

## GitHub Actions Deploy To Hostinger hPanel

This repository includes a deployment workflow:

- `.github/workflows/deploy-hpanel.yml`

It deploys automatically on pushes to `main`, and it can also be triggered manually from the GitHub Actions tab.

## Required GitHub Secrets

In your GitHub repo:

- `Settings`
- `Secrets and variables`
- `Actions`

Create these secrets:

- `HPANEL_SSH_HOST`
  Your Hostinger SSH host or server IP.
- `HPANEL_SSH_PORT`
  Usually `65002` on Hostinger unless your panel shows a different SSH port.
- `HPANEL_SSH_USER`
  Your Hostinger SSH username.
- `HPANEL_SSH_KEY`
  Your private SSH key content.
- `HPANEL_APP_PATH`
  Full path to the Laravel app directory on the server.
  Example:
  `/home/u867057961/domains/spraywow.com/laravel`
- `HPANEL_PUBLIC_PATH`
  Full path to the public web directory on the server.
  Example:
  `/home/u867057961/domains/spraywow.com/public_html`

## What The Workflow Does

The workflow:

- installs Composer dependencies
- installs Node dependencies
- builds Vite assets
- uploads the Laravel app to your Hostinger app path
- uploads `public/` files to your Hostinger public path
- runs production Laravel commands:
  - `php artisan config:clear`
  - `php artisan cache:clear`
  - `php artisan view:clear`
  - `php artisan migrate --force`
  - `php artisan view:cache`
  - `php artisan route:cache`

## Server Notes

- Keep your real server `.env` file on Hostinger
- The workflow does not overwrite `.env`
- Make sure `storage` and `bootstrap/cache` are writable
- Make sure your database already exists in hPanel
- Make sure SSH access is enabled in Hostinger

## Trigger Deployment

You can deploy by:

1. pushing to `main`
2. opening the GitHub `Actions` tab and running `Deploy To Hostinger`

## Current Project Notes

- This project uses Composer with `vendor2`
- Built frontend assets are generated through Vite
- Laravel public files are intended to be served from `public_html`
