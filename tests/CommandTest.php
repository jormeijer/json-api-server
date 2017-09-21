<?php

namespace Tests;

class CommandTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        config(['laravel_api.path.templates_dir' => 'resources/templates/']);
    }

    /** @test */
    public function it_generates_a_schema()
    {
        $this->artisan('laravel-api:generate-schema', ['name' => 'Example', '--path' => 'tests/Data/Output/']);
        $this->assertTrue(file_exists(config('laravel_api.path.schema').'ExampleSchema.php'));
        unlink('tests/Data/Output/'.'ExampleSchema.php');
    }

    /** @test */
    public function it_generates_a_policy()
    {
        $this->artisan('laravel-api:generate-policy', ['name' => 'Example', '--path' => 'tests/Data/Output/']);
        $this->assertTrue(file_exists(config('laravel_api.path.policy').'ExamplePolicy.php'));
        unlink('tests/Data/Output/'.'ExamplePolicy.php');
    }

    /** @test */
    public function it_generates_a_translation()
    {
        $this->artisan('laravel-api:generate-translation', ['name' => 'Example', '--path' => 'tests/Data/Output/']);
        $this->assertTrue(file_exists(config('laravel_api.path.translation').'ExampleTranslation.php'));
        unlink('tests/Data/Output/'.'ExampleTranslation.php');
    }
}
