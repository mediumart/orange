<?php

namespace Mediumart\Orange\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var string
     */
    protected $token = 'i6m2iIcY0SodWSe...L3ojAXXrH';
    
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Mediumart\Orange\OrangeServiceProvider::class,
        ];
    }
}
