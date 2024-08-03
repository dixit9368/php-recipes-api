<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
        }
        input, textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            color: #d9534f;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a New Recipe</h1>
        <form id="recipe-form">
            <label for="name">Recipe Name</label>
            <input type="text" id="name" name="name" required>

            <label for="prep_time">Preparation Time (minutes)</label>
            <input type="number" id="prep_time" name="prep_time" required>

            <label for="difficulty">Difficulty (1-3)</label>
            <input type="number" id="difficulty" name="difficulty" min="1" max="3" required>

            <label for="vegetarian">Vegetarian</label>
            <input type="checkbox" id="vegetarian" name="vegetarian">

            <button type="submit">Add Recipe</button>
            <div id="response-message" class="message"></div>
        </form>
    </div>

    <script>
        document.getElementById('recipe-form').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                prep_time: formData.get('prep_time'),
                difficulty: formData.get('difficulty'),
                vegetarian: formData.get('vegetarian') === 'on' // Convert checkbox value
            };

            fetch('http://localhost:8080/recipes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text) });
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('response-message').textContent = 'Recipe added successfully!';
                document.getElementById('recipe-form').reset();
            })
            .catch(error => {
                document.getElementById('response-message').textContent = 'Error adding recipe: ' + error.message;
            });
        });
    </script>
</body>
</html>

