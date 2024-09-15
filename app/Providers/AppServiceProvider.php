<?php

namespace App\Providers;

use App\Repository\RoomRepository;
use App\Repository\GuestRepository;
use App\Repository\StaffRepository;
use App\Repository\PaymentRepository;
use App\Repository\ServiceRepository;
use App\Repository\FeedbackRepository;
use App\Repository\RoomTypeRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\DepartmentRepository;
use App\ReposatoryInterface\RoomRepositoryInterface;
use App\ReposatoryInterface\GuestRepositoryInterface;
use App\RepositoryInterface\StaffRepositoryInterface;
use App\ReposatoryInterface\ServiceRepositoryInterface;
use App\RepositoryInterface\PaymentRepositoryInterface;
use App\ReposatoryInterface\FeedbackRepositoryInterface;
use App\ReposatoryInterface\RoomTypeRepositoryInterface;
use App\ReposatoryInterface\DepartmentRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(GuestRepositoryInterface::class, GuestRepository::class);
        $this->app->bind(RoomTypeRepositoryInterface::class, RoomTypeRepository::class);
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(FeedbackRepositoryInterface::class, FeedbackRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
