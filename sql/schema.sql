CREATE TABLE game(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    game_name TEXT,
    game_description TEXT,
    game_url TEXT
);

CREATE TABLE scoreboard(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    game_id INT(11) NOT NULL,
    player_id TEXT,
    player_name TEXT,
    score INT(11),
    FOREIGN KEY (game_id) REFERENCES game(id)
);

