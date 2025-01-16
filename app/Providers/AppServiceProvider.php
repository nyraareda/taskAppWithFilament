<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EnumType extends \Doctrine\DBAL\Types\Type
{
    const ENUM = 'enum';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        // Define the SQL declaration for your ENUM type
        return "ENUM('pending', 'completed')";
    }

    public function getName(): string
    {
        return self::ENUM;
    }
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!Type::hasType('enum')) {
            // Add the 'enum' type to Doctrine
            Type::addType('enum', EnumType::class);
        }

        // Mark the enum type as commented for the database platform
        $platform = \DB::getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->markDoctrineTypeCommented(Type::getType('enum'));
    }
}
