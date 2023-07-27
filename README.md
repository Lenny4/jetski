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

Bundle plugin: https://wordpress.org/plugins/woo-product-bundle/#utm_medium=referral&utm_source=facebook.com&utm_content=social

Api auth: https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/#basic-authentication-with-application-passwords

https://stackoverflow.com/questions/20064271/how-to-use-basic-authorization-in-php-curl
https://woocommerce.github.io/woocommerce-rest-api-docs/?shell#create-a-product
```
curl -X POST http://caddy/wp-json/wc/v3/products \
    -u 'admin:3QHG VXtl h6lx Tn3a RcSE NjlF' \
    -H "Content-Type: application/json" \
    -d '{
  "name": "Premium Quality",
  "type": "simple",
  "regular_price": "21.99",
  "description": "Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.",
  "short_description": "Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.",
  "categories": [
    {
      "id": 9
    },
    {
      "id": 14
    }
  ],
  "images": [
    {
      "src": "http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg"
    },
    {
      "src": "http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg"
    }
  ]
}'
```
