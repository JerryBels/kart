<?php

namespace Tests;

use App\Services\ProductService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->fakeHttpCalls();

        return $app;
    }

    private function fakeHttpCalls()
    {
        Http::preventStrayRequests();

        $productUrl = ProductService::$baseUrl . ProductService::$productsEndpoint . '*';
        Http::fake([
            // Stub a JSON response for GitHub endpoints...
            $productUrl => Http::response([
                'id' => 1,
                'title' => "dummy product",
                'description' => "dummy description",
                'price' => 100,
                'thumbnail' => "https://dummyimage.com/600x400/000/fff",
            ]),
        ]);
    }
}
