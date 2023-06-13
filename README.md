### Step 1: Stop track .env.local

```bash
git update-index --assume-unchanged .env.local
```

Run project:
```
docker compose -f docker-compose.yml -f docker-compose.dev.yml up --build
./runc composer install
```
Go on http://caddy/

https://stackoverflow.com/questions/3663520/php-auth-user-not-set

tester avec xdebug
public/wordpress/wp-admin/includes/class-wp-site-health.php:2056

sudo nano /etc/hosts
127.0.0.1       caddy

if you want to edit
- sudo chown -R alexandre:www-data *
then (to give wordpress the right to edit file):
- ./runc chown -R www-data:www-data *
