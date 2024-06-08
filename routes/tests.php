name: 🚀 Deployment

on: push:
  branches: [ 'main' ]

jobs:
  web-deploy:
    name: Deploy
    runs-on: ubuntu-latest
    steps:
      - name: Get latest code
        uses: actions/checkout@v2.3.2

      - name: Install Dependencies
        run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

      - name: Copy .env
        run: php -r "file_exists('.env') || copy('.env.example', '.env');"

      - name: Config Clearing
        run: php artisan config:clear

      - name: Cache Clearing
        run: php artisan cache:clear

      - name: Generate App Key
        run: php artisan key:generate

      - name: Generate storage link
        run: php artisan storage:link

      - name: Directory Permissions
        run: chmod -R 777 storage bootstrap/cache
      
      - name: Sync files
        uses: SamKirkland/FTP-Deploy-Action@4.0.0
        with:
          server: ftp.myappa.tech
          username: cd@myappa.tech
          password: QH2Zz9YYjYv2
          server-dir: /public_html/homemates/