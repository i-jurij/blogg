Blog on Laravel with the Orchid admin panel (https://orchid.software/)   
based on this [https://alexchas-dev.ru/](https://alexchas-dev.ru/)

---
# Installing the project on the development environment

```bash
mkdir projects && cd projects
git clone https://github.com//ijurij/blogg.git
cd laravel-orchid-blog
composer install
npm install
npm run dev
php artisan storage:link
cp .env.example .env

# create db with name from env before this step
#  ======== Without Docker
php artisan migrate --seed
# Create a user with the maximum (at the time of creation) rights:
php artisan orchid:admin admin admin@admin.com admin

# ======== For Docker (Sail)
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
sail up -d
sail artisan migrate --seed
# Create a user with the maximum (at the time of creation) rights:
sail artisan orchid:admin admin email@email.com 123456

# check in the browser: http://localhost 
```
