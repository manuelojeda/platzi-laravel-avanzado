<?php
// phpcs:disable
namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    // phpcs:enable
    use RefreshDatabase;

    /**
     * Setup function
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Function that test the index function in the controller
     * 
     * @return void
     */
    public function testIndex(): void
    {
        factory(Category::class, 5)->create();
        $response = $this->getJson('/api/categories');

        $response->assertSuccessful();
        $response->assertJsonCount(5);
    }

    /**
     * Function that test the create method
     * 
     * @return void
     */
    public function testCreateNewCategory(): void
    {
        $data = [
            'name' => 'MyCat'
        ];

        $response = $this->postJson('/api/categories', $data);
        $response->assertSuccessful();
        $this->assertDatabaseHas('categories', $data);
    }

    /**
     * Function that test if the category update works
     * 
     * @return void
     */
    public function testUpdateCategory(): void
    {
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'My Updated Cate'
        ];

        $response = $this->patchJson("/api/categories/{$category->getKey()}", $data);
        $response->assertSuccessful();
    }

    /**
     * Function that test if a category is shown
     * 
     * @return void
     */
    public function testShowCategory(): void
    {
        $category = factory(Category::class)->create();
        $response = $this->getJson("/api/categories/{$category->getKey()}");
        $response->assertSuccessful();
    }

    /**
     * Function that test if the delete method works
     * 
     * @return void
     */
    public function testDeleteCategory(): void
    {
        $category = factory(Category::class)->create();
        $response = $this->deleteJson("/api/categories/{$category->getKey()}");
        $response->assertSuccessful();
        $this->assertDeleted($category);
    }
}
