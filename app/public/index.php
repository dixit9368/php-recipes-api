<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    // Process the input and add the recipe to your database
    $name = $input['name'] ?? null;
    $prep_time = $input['prep_time'] ?? null;
    $difficulty = $input['difficulty'] ?? null;
    $vegetarian = $input['vegetarian'] ?? null;

    // Validate input
    if (!$name || !$prep_time || !$difficulty) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Assuming you have a function to add a recipe to your database
    $result = add_recipe($name, $prep_time, $difficulty, $vegetarian);

    if ($result) {
        http_response_code(201);
        echo json_encode(['message' => 'Recipe added successfully!']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to add recipe']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed']);
}

function add_recipe($name, $prep_time, $difficulty, $vegetarian) {
    // Your code to add the recipe to the database
    // Log the operation
    error_log("Adding recipe: $name, $prep_time, $difficulty, $vegetarian");
    
    // Return true if successful, false otherwise
    // Here, you should include actual database interaction code
    return true;
}
