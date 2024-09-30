CREATE TABLE types (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(10) NOT NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL
);

CREATE TABLE moves_damage_class (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(10) NOT NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL
);

CREATE TABLE moves (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(35) NOT NULL,
    accuracy INT,
    power INT,
    pp INT,
    description VARCHAR(250),
    type_id INT,
    damage_class_id INT,
    FOREIGN KEY (type_id) REFERENCES types (id),
    FOREIGN KEY (damage_class_id) REFERENCES moves_damage_class (id),
    created datetime NOT NULL,
    modified datetime DEFAULT NULL
);

CREATE TABLE natures (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(10) NOT NULL,
    increased_stat VARCHAR(20),
    decreased_stat VARCHAR(20),
    created datetime NOT NULL,
    modified datetime DEFAULT NULL
);

CREATE TABLE abilities (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    description VARCHAR(255) NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL
);

CREATE TABLE pokemons (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(40) NOT NULL,
    hp INT NOT NULL,
    attack INT NOT NULL,
    defense INT NOT NULL,
    special_attack INT NOT NULL,
    special_defense INT NOT NULL,
    speed INT NOT NULL,
    height INT NOT NULL,
    weight INT NOT NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL
);

CREATE TABLE pokemons_types_link (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pokemon_id INT NOT NULL,
    type_id INT NOT NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemons (id),
    FOREIGN KEY (type_id) REFERENCES types (id)
);

CREATE TABLE pokemons_abilities_link (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pokemon_id INT NOT NULL,
    abilities_id INT NOT NULL,
    is_hidden BOOLEAN NOT NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemons (id),
    FOREIGN KEY (abilities_id) REFERENCES abilities (id)
);

CREATE TABLE pokemons_imgs (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pokemon_id INT NOT NULL,
    front_default VARCHAR(200) NOT NULL,
    front_shiny VARCHAR(200) NOT NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemons (id)
);

CREATE TABLE pokemons_gifs (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pokemon_id INT NOT NULL,
    front_default VARCHAR(200) NOT NULL,
    front_shiny VARCHAR(200) NOT NULL,
    back_default VARCHAR(200) NOT NULL,
    back_shiny VARCHAR(200) NOT NULL,
    created datetime NOT NULL,
    modified datetime DEFAULT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemons (id)
);

CREATE TABLE pokemons_species (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    pokemon_id INT NOT NULL,
    is_baby BOOLEAN NOT NULL,
    is_legendary BOOLEAN NOT NULL,
    is_mythical BOOLEAN NOT NULL,

    base_happiness INT NOT NULL,
    capture_rate INT NOT NULL,
    gender_rate INT NOT NULL,   
    hatch_counter INT NOT NULL,

    created datetime NOT NULL,
    modified datetime DEFAULT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemons (id)
);