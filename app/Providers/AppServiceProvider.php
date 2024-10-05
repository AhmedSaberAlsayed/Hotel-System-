<?php

namespace App\Providers;

use App\Repository\RoomRepository;
use App\Repository\GuestRepository;
use App\Repository\StaffRepository;
use App\Repository\BookingRepository;
use App\Repository\PaymentRepository;
use App\Repository\ServiceRepository;
use App\Repository\FeedbackRepository;
use App\Repository\RoomTypeRepository;
use App\Repository\InventoryRepository;
use App\Repository\SuppliersRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\DepartmentRepository;
use App\Repository\RoomMaintenanceRepository;
use App\RepositoryInterface\RoomRepositoryInterface;
use App\RepositoryInterface\GuestRepositoryInterface;
use App\RepositoryInterface\StaffRepositoryInterface;
use App\RepositoryInterface\BookingRepositoryInterface;
use App\RepositoryInterface\PaymentRepositoryInterface;
use App\RepositoryInterface\ServiceRepositoryInterface;
use App\RepositoryInterface\FeedbackRepositoryInterface;
use App\RepositoryInterface\RoomTypeRepositoryInterface;
use App\RepositoryInterface\InventoryRepositoryInterface;
use App\RepositoryInterface\SuppliersRepositoryInterface;
use App\RepositoryInterface\DepartmentRepositoryInterface;
use App\RepositoryInterface\RoomMaintenanceRepositoryInterface;

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
        $this->app->bind(RoomMaintenanceRepositoryInterface::class, RoomMaintenanceRepository::class);
        $this->app->bind(StaffRepositoryInterface::class, StaffRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(FeedbackRepositoryInterface::class, FeedbackRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(SuppliersRepositoryInterface::class, SuppliersRepository::class);
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
