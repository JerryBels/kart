## To install

1. Clone the repo
2. Run `cp .env.example .env`
3. Run `composer install`
4. Run `npm install`
5. Run `npm run build`
6. Run `./vendor/bin/sail up -d`
7. Run `sail artisan key:generate`
8. Run `sail artisan migrate`

Then visit http://localhost and the app should be running like a bike.

For development, I used Laravel with Livewire mostly. Bootstrap to help with the CSS. And Laravel Sail for the Docker environment.

Most of the written code can fe found in `app/Http/Livewire/Kart.php`, `app/Models/Cart.php`, `app/Services/ProductService.php`, `resources/views/livewire/kart.blade.php` and `tests/Feature/*`

You can see the demo live here : https://mythic-field-naeaqrtlfy.ploi.online/

There are tons of things I would like to improve, but I have to remind myself all the time it's a demo :D
