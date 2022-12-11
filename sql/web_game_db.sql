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

INSERT INTO game VALUES
(4,'Balloon Pop','game about popping balloon','/games/balloon-pop/'),
(5,'Gold fish','game gold fish collecting gold coin','/games/gold-fish/'),
(6,'Tank tab','game about tank tab and shooting','/games/tank-tab/');

INSERT INTO scoreboard VALUES
(11,4,'admin001','admin',105),
(12,5,'admin001','admin',30),
(17,6,'random_621.603341','Guest',9),
(18,6,'admin001','admin',5);
