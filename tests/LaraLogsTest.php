<?php

namespace LaraLogs\Tests;

use Orchestra\Testbench\TestCase;
use LaraLogs\LaraLogsServiceProvider;

class LaraLogsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaraLogsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /** @test */
    public function it_can_load_the_service_provider()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_has_config_file()
    {
        $config = config('laralogs');
        $this->assertIsArray($config);
        $this->assertArrayHasKey('enabled_in_production', $config);
        $this->assertArrayHasKey('allowed_emails', $config);
        $this->assertArrayHasKey('route_prefix', $config);
    }

    /** @test */
    public function it_has_routes_registered()
    {
        $routes = $this->app['router']->getRoutes();
        $routeNames = collect($routes)->map->getName()->filter();
        
        $this->assertTrue($routeNames->contains('laralogs.index'));
        $this->assertTrue($routeNames->contains('laralogs.clear'));
        $this->assertTrue($routeNames->contains('laralogs.download'));
    }
}
