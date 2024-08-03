
CREATE TABLE recipes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    prep_time INT NOT NULL,
    difficulty INT NOT NULL CHECK (difficulty BETWEEN 1 AND 3),
    vegetarian BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ratings (
    id SERIAL PRIMARY KEY,
    recipe_id INT,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
);

-- Insert some sample data into the recipes table
INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES
('Spaghetti Carbonara', 30, 2, FALSE),
('Vegetarian Chili', 45, 2, TRUE),
('Chicken Curry', 60, 3, FALSE);

-- Insert some sample data into the ratings table
INSERT INTO ratings (recipe_id, rating) VALUES
(1, 5),
(1, 4),
(2, 5),
(3, 3);