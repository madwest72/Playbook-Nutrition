create database playbook;

use playbook;

create table recette(
    id int auto_increment primary key,
    nom VARCHAR(255),
    information text,
    instrution text
);

create table ingredient(
    id int  auto_increment primary key,
    nom VARCHAR(255) NOT NULL UNIQUE,
    calorie float,
    protein float,
    lipide float,
    glucide float
);

create table recette_ingredient(
    quantite float,
    recette_id int,
    ingredient_id int,
    foreign key (recette_id) references recette(id) ON DELETE CASCADE,
    foreign key (ingredient_id) references ingredient(id) ON DELETE CASCADE,
    PRIMARY KEY (recette_id, ingredient_id)
);