
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
)


CREATE TABLE moves (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
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
CREATE TABLE pokemons (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL,
    f_type_id INT NOT NULL,
    s_type_id INT,

    hp INT NOT NULL,
    attack INT NOT NULL,
    defense INT NOT NULL,
    sa INT NOT NULL,
    sd INT NOT NULL,
    speed INT NOT NULL,

    height INT NOT NULL,
    weight INT NOT NULL,

    f_abilitie_id INT NOT NULL,
    s_abilitie_id INT,
    t_abilitie_id INT
);