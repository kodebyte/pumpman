<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
        \App\Contracts\EmployeeRepositoryInterface::class, 
        \App\Repositories\EmployeeRepository::class
        );

        $this->app->bind(
        \App\Contracts\UserRepositoryInterface::class, 
        \App\Repositories\UserRepository::class
        );

        $this->app->bind(
        \App\Contracts\CategoryRepositoryInterface::class, 
        \App\Repositories\CategoryRepository::class
        );

        $this->app->bind(
        \App\Contracts\HeroBannerRepositoryInterface::class, 
        \App\Repositories\HeroBannerRepository::class
        );

        $this->app->bind(
        \App\Contracts\MarketplaceRepositoryInterface::class,
        \App\Repositories\MarketplaceRepository::class
        );

        $this->app->bind(
        \App\Contracts\ProductRepositoryInterface::class,
        \App\Repositories\ProductRepository::class
        );

        $this->app->bind(
        \App\Contracts\PostRepositoryInterface::class,
        \App\Repositories\PostRepository::class
        );

        $this->app->bind(
        \App\Contracts\StoreRepositoryInterface::class,
        \App\Repositories\StoreRepository::class
        );

        $this->app->bind(
        \App\Contracts\CareerRepositoryInterface::class,
        \App\Repositories\CareerRepository::class
        );

        // ...
        $this->app->bind(
        \App\Contracts\SettingRepositoryInterface::class,
        \App\Repositories\SettingRepository::class
        );

        $this->app->bind(
        \App\Contracts\FaqRepositoryInterface::class,
        \App\Repositories\FaqRepository::class
        );

        $this->app->bind(
        \App\Contracts\NewsletterSubscriberRepositoryInterface::class,
        \App\Repositories\NewsletterSubscriberRepository::class
        );

        $this->app->bind(
        \App\Contracts\WarrantyClaimRepositoryInterface::class,
        \App\Repositories\WarrantyClaimRepository::class
        );

        $this->app->bind(
        \App\Contracts\PostTypeRepositoryInterface::class,
        \App\Repositories\PostTypeRepository::class
        );

        $this->app->bind(
        \App\Contracts\OrderRepositoryInterface::class,
        \App\Repositories\OrderRepository::class
        );

        $this->app->bind(
        \App\Contracts\CourierRepositoryInterface::class,
        \App\Repositories\CourierRepository::class
        );

        $this->app->bind(
        \App\Contracts\ProductHighlightRepositoryInterface::class,
        \App\Repositories\ProductHighlightRepository::class
        );

        $this->app->bind(
        \App\Contracts\ContactMessageRepositoryInterface::class,
        \App\Repositories\ContactMessageRepository::class
        );

        $this->app->bind(
        \App\Contracts\SeoSettingRepositoryInterface::class,
        \App\Repositories\SeoSettingRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
