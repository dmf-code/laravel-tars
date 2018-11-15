<?php

namespace Lxj\Laravel\Tars;

use Laravelista\LumenVendorPublish\VendorPublishCommand;
use Lxj\Laravel\Tars\Commands\Deploy;
use Lxj\Laravel\Tars\Commands\Tars;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    /**
     * Register commands.
     */
    protected function registerCommands()
    {
        $this->commands([
            VendorPublishCommand::class,
            Deploy::class,
            Tars::class,
        ]);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        app()->configure('tars');

        $tarsServantDir = base_path('app/Tars/servant');
        $tarsServantImplDir = base_path('app/Tars/impl');
        $tarsCservantDir = base_path('app/Tars/cservant');

        if (!is_dir($tarsServantDir)) {
            mkdir($tarsServantDir, 0777, true);
        }
        if (!is_dir($tarsServantImplDir)) {
            mkdir($tarsServantImplDir, 0777, true);
        }
        if (!is_dir($tarsCservantDir)) {
            mkdir($tarsCservantDir, 0777, true);
        }

        $publicResources = [
            __DIR__ . '/index.php' => base_path('index.php'),
            __DIR__ . '/config/tars.php' => base_path('config/tars.php'),
            __DIR__ . '/Tars/cservant/.gitkeep' => $tarsCservantDir . '/.gitkeep',
        ];

        $this->publishes(array_merge($publicResources, [
            __DIR__ . '/services.http.php' => base_path('services.php'),
            __DIR__ . '/../tars/tars.proto.http.php' => base_path('../tars/tars.proto.php'),
        ]), 'tars.http');

        $this->publishes(array_merge($publicResources, [
            __DIR__ . '/services.tars.php' => base_path('services.php'),
            __DIR__ . '/../scripts/tars2php.sh' => base_path('../scripts/tars2php.sh'),
            __DIR__ . '/../tars/tars.proto.tars.php' => base_path('../tars/tars.proto.php'),
            __DIR__ . '/Tars/servant/.gitkeep' => $tarsServantDir . '/.gitkeep',
            __DIR__ . '/Tars/impl/.gitkeep' => $tarsServantImplDir . '/.gitkeep',
            __DIR__ . '/Tars/cservant/.gitkeep' => $tarsCservantDir . '/.gitkeep',
        ]), 'tars.tars');
    }
}
