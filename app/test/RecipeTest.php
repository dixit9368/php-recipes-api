<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\RecipeController;
use App\Models\Recipe;
use PDO;

class RecipeTest extends TestCase
{
    private $db;
    private $recipeController;

    protected function setUp(): void
    {
        // Set up an in-memory SQLite database for testing
        $this->db = new PDO('sqlite::memory:');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create tables for testing
        $this->db->exec("
            CREATE TABLE recipes (
                id INTEGER PRIMARY KEY,
                name TEXT,
                prep_time INTEGER,
                difficulty TEXT,
                vegetarian BOOLEAN
            );
        ");
        $this->db->exec("
            CREATE TABLE ratings (
                id INTEGER PRIMARY KEY,
                recipe_id INTEGER,
                rating INTEGER,
                FOREIGN KEY (recipe_id) REFERENCES recipes (id) ON DELETE CASCADE
            );
        ");

        $this->recipeController = new RecipeController($this->db);
    }

    public function testListRecipes()
    {
        $this->recipeController->createRecipe(); // Add a recipe to list
        $this->expectOutputString(json_encode([
            [
                'id' => 1,
                'name' => 'Test Recipe',
                'prep_time' => 30,
                'difficulty' => 'Easy',
                'vegetarian' => true
            ]
        ]));

        $this->recipeController->listRecipes();
    }

    public function testCreateRecipe()
    {
        $_POST = [
            'name' => 'Test Recipe',
            'prep_time' => 30,
            'difficulty' => 'Easy',
            'vegetarian' => true
        ];

        $this->expectOutputString(json_encode(['id' => 1]));

        $this->recipeController->createRecipe();
    }

    public function testGetRecipe()
    {
        $this->recipeController->createRecipe(); // Add a recipe to retrieve

        $this->expectOutputString(json_encode([
            'id' => 1,
            'name' => 'Test Recipe',
            'prep_time' => 30,
            'difficulty' => 'Easy',
            'vegetarian' => true
        ]));

        $this->recipeController->getRecipe(1);
    }

    public function testUpdateRecipe()
    {
        $this->recipeController->createRecipe(); // Add a recipe to update

        $_POST = [
            'name' => 'Updated Recipe',
            'prep_time' => 45,
            'difficulty' => 'Medium',
            'vegetarian' => false
        ];

        $this->expectOutputString(json_encode(['status' => 'success']));

        $this->recipeController->updateRecipe(1);
    }

    public function testDeleteRecipe()
    {
        $this->recipeController->createRecipe(); // Add a recipe to delete

        $this->expectOutputString(json_encode(['status' => 'success']));

        $this->recipeController->deleteRecipe(1);
    }

    public function testRateRecipe()
    {
        $this->recipeController->createRecipe(); // Add a recipe to rate

        $_POST = ['rating' => 5];

        $this->expectOutputString(json_encode(['status' => 'success']));

        $this->recipeController->rateRecipe(1);
    }

    protected function tearDown(): void
    {
        $this->db = null;
        $this->recipeController = null;
    }
}
?>
