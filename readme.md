TODO:

```bash
    git clone git@github.com:SultanSagi/new-prize-app.git
    cd new-prize-app
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    
    ./vendor/bin/phpunit
    
    php artisan send:money-prizes 1 3 => send:money-prizes {userId} {count}
```