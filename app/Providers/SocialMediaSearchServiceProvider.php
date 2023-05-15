<?php

namespace App\Providers;

use App\Contracts\SearchServiceInterface;
use App\Services\GitHubAPI;
use App\Services\SocialMediaSearchService;
use Illuminate\Support\ServiceProvider;

class SocialMediaSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SearchServiceInterface::class, function () {
            return new GitHubAPI();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
