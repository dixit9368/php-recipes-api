<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    protected $recipe;

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    public function index()
    {
        $recipes = $this->recipe->all();
        return response()->json($recipes);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $recipe = $this->recipe->create($data);
        return response()->json(['id' => $recipe->id], 201);
    }

    public function show($id)
    {
        $recipe = $this->recipe->find($id);
        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }
        return response()->json($recipe);
    }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->all();
    //     $recipe = $this->recipe->find($id);
    //     if (!$recipe) {
    //         return response()->json(['message' => 'Recipe not found'], 404);
    //     }
    //     $recipe->update($data);
    //     return response()->json(['status' => 'success']);
    // }
    public function update(Request $request, $id) {
        $recipe = Recipe::find($id);
    
        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }
    
        $recipe->update($request->all());
        return response()->json(['message' => 'Recipe updated successfully']);
    }
    

    // public function destroy($id)
    // {
    //     $recipe = $this->recipe->find($id);
    //     if (!$recipe) {
    //         return response()->json(['message' => 'Recipe not found'], 404);
    //     }
    //     $recipe->delete();
    //     return response()->json(['status' => 'success']);
    // }
    public function destroy($id) {
        $recipe = Recipe::find($id);
    
        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }
    
        $recipe->delete();
        return response()->json(['message' => 'Recipe deleted successfully']);
    }
    
    public function rate(Request $request, $id)
    {
        $recipe = $this->recipe->find($id);
        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }
        $recipe->rating = $request->input('rating');
        $recipe->save();
        return response()->json(['status' => 'success']);
    }
}

?>
