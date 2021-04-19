<?php

namespace App\Providers;

use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\Base\BaseRepository;
use App\Repositories\ClassRepository;
use App\Repositories\ClassRepositoryInterface;
use App\Repositories\SubjectRepository;
use App\Repositories\SubjectRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(ClassRepositoryInterface::class, ClassRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
