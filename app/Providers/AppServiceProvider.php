<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Money\Formatter\IntlMoneyFormatter;
use Illuminate\Contracts\Foundation\Application;
use Money\Currencies\ISOCurrencies;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        ISOCurrencies::class => ISOCurrencies::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->singleton(ISOCurrencies::class, fn () => new ISOCurrencies());

        $this->app->singleton(IntlMoneyFormatter::class, function (Application $app) {
            $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
            return new IntlMoneyFormatter($numberFormatter, $app->make(ISOCurrencies::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();

        $this->app->resolving(IntlMoneyFormatter::class, function (IntlMoneyFormatter $c, Application $app) {
            // Called when container resolves objects of type "Transistor"...
            // ray('resolving ISOCurrencies', $c);
        });
    }
}
