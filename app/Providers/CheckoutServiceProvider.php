<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Cart;
use App\Contracts\CartItem;
use App\Contracts\Coupon;
use App\Contracts\Customer;
use App\Contracts\Order;
use App\Contracts\OrderItem;
use App\Contracts\Product;
use App\Helpers\Address\GeoNames;
use App\Models\ConfigurableModel;
use R64\Stripe\PaymentProcessor;

class CheckoutServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Product::class, function () {
            $productClass = config('checkout.product_model');

            return new ConfigurableModel(new $productClass);
        });

        $this->app->bind(\App\Models\Product::class, function () {
            return \App\Facades\Product::getModel();
        });

        $this->app->bind(Customer::class, function () {
            $customerClass = config('checkout.customer_model');

            return new ConfigurableModel(new $customerClass);
        });

        $this->app->bind(\App\Models\Customer::class, function () {
            return \App\Facades\Customer::getModel();
        });

        $this->app->bind(Cart::class, function () {
            $cartClass = config('checkout.cart_model');

            return new ConfigurableModel(new $cartClass);
        });

        $this->app->bind(\App\Models\Cart::class, function () {
            return \App\Facades\Cart::getModel();
        });

        $this->app->bind(CartItem::class, function () {
            $cartItemClass = config('checkout.cart_item_model');

            return new ConfigurableModel(new $cartItemClass);
        });

        $this->app->bind(\App\Models\CartItem::class, function () {
            return \App\Facades\CartItem::getModel();
        });

        $this->app->bind(Order::class, function () {
            $orderClass = config('checkout.order_model');

            return new ConfigurableModel(new $orderClass);
        });

        $this->app->bind(\App\Models\Order::class, function () {
            return \App\Facades\Order::getModel();
        });

        $this->app->bind(OrderItem::class, function () {
            $orderItemClass = config('checkout.order_item_model');

            return new ConfigurableModel(new $orderItemClass);
        });

        $this->app->bind(\App\Models\OrderItem::class, function () {
            return \App\Facades\OrderItem::getModel();
        });

        $this->app->bind(Coupon::class, function () {
            $couponClass = config('checkout.coupon_model');

            return new ConfigurableModel(new $couponClass);
        });

        $this->app->bind(\App\Models\Coupon::class, function () {
            return \App\Facades\Coupon::getModel();
        });



        $this->app->singleton(StripePaymentHandler::class, function (Container $app) {
            $paymentHandler = config('checkout.stripe_payment');

            return new $paymentHandler($app->get(PaymentProcessor::class));
        });

   

  
    }

    public function boot(Filesystem $filesystem)
    {
        $globals_dir = app_path('Helpers/Globals.php');
        require_once $globals_dir;
        $this->publishConfig();
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/' => base_path('config'),
        ], 'config');
    }

    protected function publishDatabaseMigrations(Filesystem $filesystem)
    {
        $time = time();

        if (!class_exists('CreateCheckoutProductsTable')) {
            $migrationFileName = $this->getMigrationFilename('create_products_table', $time, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_1_create_products_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('CreateCustomersTable')) {
            $migrationFileName = $this->getMigrationFilename('create_customers_table', $time + 1, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_2_create_customers_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('CreateCouponsTable')) {
            $migrationFileName = $this->getMigrationFilename('create_coupons_table', $time + 2, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_3_create_coupons_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('CreateCartsTable')) {
            $migrationFileName = $this->getMigrationFilename('create_carts_table', $time + 3, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_4_create_carts_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('CreateCartItemsTable')) {
            $migrationFileName = $this->getMigrationFilename('create_cart_items_table', $time + 4, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_5_create_cart_items_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('CreateOrdersTable')) {
            $migrationFileName = $this->getMigrationFilename('create_orders_table', $time + 5, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_6_create_orders_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('CreateOrderItemsTable')) {
            $migrationFileName = $this->getMigrationFilename('create_order_items_table', $time + 6, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_7_create_order_items_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('CreateOrderPurchasesTable')) {
            $migrationFileName = $this->getMigrationFilename('create_order_purchases_table', $time + 7, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_02_17_8_create_order_purchases_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('AddOptionsToCartsAndOrdersTable')) {
            $migrationFileName = $this->getMigrationFilename('add_options_to_carts_and_orders_table', $time + 8, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_03_24_9_add_options_to_carts_and_orders_table.php' => $migrationFileName,
            ], 'migrations');
        }

        if (!class_exists('AddPaypalColumnsToOrderPurchasesTable')) {
            $migrationFileName = $this->getMigrationFileName('add_paypal_columns_to_order_purchases_table', $time + 9, $filesystem);
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_06_03_10_add_paypal_columns_to_order_purchases_table.php' => $migrationFileName,
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/../database/factories/' => database_path('factories'),
        ], 'migrations');

    }

    protected function publishPolicies()
    {
        $this->publishes([
            __DIR__ . '/../Policies/' => app_path('Policies'),
        ], 'policies');
    }

    protected function publishNovaResources()
    {
        $this->publishes([
            __DIR__ . '/../Nova/' => app_path('Nova'),
        ], 'nova');
    }


    protected function guestRouteConfiguration()
    {
        return [
            'namespace' => 'App\Http\Controllers',
            'as' => 'checkout.api.',
            'prefix' => 'api',
            'middleware' => ['throttle:60,1', 'bindings'],
        ];
    }

    protected function apiRouteConfiguration()
    {
        return [
            'namespace' => 'App\Http\Controllers',
            'as' => 'checkout.api.',
            'prefix' => 'api',
            'middleware' => 'api',
        ];
    }

    protected function getMigrationFileName($migrationName, $time, Filesystem $filesystem)
    {
        $timestamp = date('Y_m_d_His', $time);

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($migrationName, $filesystem) {
                return $filesystem->glob($path . '*_' . $migrationName . '.php');
            })->push($this->app->databasePath() . "/migrations/{$timestamp}_{$migrationName}.php")
            ->first();
    }
}
