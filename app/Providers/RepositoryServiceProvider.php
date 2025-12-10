<?php

namespace App\Providers;

use App\Contracts\CareerRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\EmployeeRepositoryInterface;
use App\Contracts\FaqCategoryRepositoryInterface;
use App\Contracts\FaqRepositoryInterface;
use App\Contracts\HeroBannerRepositoryInterface;
use App\Contracts\MarketplaceRepositoryInterface;
use App\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Contracts\PostRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\SettingRepositoryInterface;
use App\Contracts\StoreRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Contracts\WarrantyClaimRepositoryInterface;
use App\Repositories\CareerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\FaqCategoryRepository;
use App\Repositories\FaqRepository;
use App\Repositories\HeroBannerRepository;
use App\Repositories\MarketplaceRepository;
use App\Repositories\NewsletterSubscriberRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SettingRepository;
use App\Repositories\StoreRepository;
use App\Repositories\UserRepository;
use App\Repositories\WarrantyClaimRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
        EmployeeRepositoryInterface::class, 
        EmployeeRepository::class
        );

        $this->app->bind(
        UserRepositoryInterface::class, 
        UserRepository::class
        );

        $this->app->bind(
        CategoryRepositoryInterface::class, 
        CategoryRepository::class
        );

        $this->app->bind(
        HeroBannerRepositoryInterface::class, 
        HeroBannerRepository::class
        );

        $this->app->bind(
        MarketplaceRepositoryInterface::class,
        MarketplaceRepository::class
        );

        $this->app->bind(
        ProductRepositoryInterface::class,
        ProductRepository::class
        );

        $this->app->bind(
        PostRepositoryInterface::class,
        PostRepository::class
        );

        $this->app->bind(
        StoreRepositoryInterface::class,
        StoreRepository::class
        );

        $this->app->bind(
        CareerRepositoryInterface::class,
        CareerRepository::class
        );

        // ...
        $this->app->bind(
        SettingRepositoryInterface::class,
        SettingRepository::class
        );

        $this->app->bind(
        FaqRepositoryInterface::class,
        FaqRepository::class
        );

        $this->app->bind(
        NewsletterSubscriberRepositoryInterface::class,
        NewsletterSubscriberRepository::class
        );

        $this->app->bind(
        WarrantyClaimRepositoryInterface::class,
        WarrantyClaimRepository::class
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
