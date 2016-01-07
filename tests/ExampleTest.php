<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    protected $jsonHeaders = ['Content-Type' => 'application/json', 'Accept' => 'application/json'];

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Product Service');
    }

    public function testProductsList()
    {
        $products = factory(\App\Product::class, 3)->create();

        $this->get(route('api.products.index'))
             ->assertResponseOk();

        array_map(function($product) {
            $this->seeJson($product->jsonSerialize());
        }, $products->all());
    }

    public function testProductDescriptionsList()
    {
        $product = factory(\App\Product::class)->create();
        $product->descriptions()->saveMany(factory(\App\Description::class, 3)->make());

        $this->get(route('api.products.descriptions.index', ['products' => $product->id]))
             ->assertResponseOk();

        array_map(function ($description) {
            $this->seeJson($description->jsonSerialize());
        }, $product->descriptions->all());
    }

    public function testProductCreation()
    {
        $product = factory(\App\Product::class)->make(['name' => 'beets']);

        $this->post(route('api.products.store'), $product->jsonSerialize())
            ->seeInDatabase('products', ['name' => $product->name])
            ->assertResponseOk();
    }

    public function testProductDescriptionCreation()
    {
        $product = factory(\App\Product::class)->create(['name' => 'beets']);
        $description = factory(\App\Description::class)->make();

        $this->post(route('api.products.descriptions.store', ['products' => $product->id]), $description->jsonSerialize())
            ->seeInDatabase('descriptions', ['body' => $description->body])
            ->assertResponseOk();
    }

    public function testProductUpdate()
    {
        $product = factory(\App\Product::class)->create(['name' => 'beets']);
        $product->name = 'feets';

        $this->put(route('api.products.update', ['products' => $product->id]), $product->jsonSerialize())
            ->seeInDatabase('products', ['name' => $product->name])
            ->assertResponseOk();
    }

    public function testCreateProductFailsIfNameNotProvided()
    {
        $this->post(route('api.products.store'), ['name' => ''], $this->jsonHeaders)
             ->seeJson(['name' => ['The name field is required.']])
             ->assertResponseStatus(422);
    }

    public function testCreateProductFailsIfNameAlreadyExists()
    {
        $product = factory(\App\Product::class)->create(['name' => 'feets']);

        $this->post(route('api.products.store'), ['name' => $product->name], $this->jsonHeaders)
             ->seeJson(['name' => ['The name field is already taken.']])
             ->assertResponseStatus(422);
    }

    // public function testCreateProductFailsIfNameAlreadyExists()
    // {
    //     $name = 'feets';
    //     $product1 = factory(\App\Product::class)->create(['name' => $name]);
    //     $product2 = factory(\App\Product::class)->make(['name' => $name]);

    //     $this->post(route('api.products.store'), $product2->jsonSerialize(), $this->jsonHeaders)
    //          ->seeJson(['name' => ['The name field is already taken.']])
    //          ->assertResponseStatus(422);
    // }

    // public function testProductCreationFailsWhenNameNotProvided()
    // {
    //     $product = factory(\App\Product::class)->make(['name' => '']);

    //     $this->post(route('api.products.store'), $product->jsonSerialize(), )
    //         ->seeJson(['name' => ['The name field is required']])
    //         ->assertResponseStatus(422);
    // }

}