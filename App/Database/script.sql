CREATE DATABASE gestion_biblio;

CREATE TABLE user(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(255),
    phone VARCHAR(15)
);

CREATE TABLE role(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(50)
);

CREATE TABLE user_Role(
    user_Id INT,
    role_Id INT,
    FOREIGN KEY (user_Id) REFERENCES user(id),
    FOREIGN KEY (role_Id) REFERENCES role(id)
);

CREATE TABLE book(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(50),
    author VARCHAR(50),
    genre VARCHAR(50),
    description VARCHAR(255),
    photo VARCHAR(255),
    publication_year date,
    total_copie INT,
    available_copies INT
);

CREATE TABLE reservation(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    description VARCHAR(255),
    reservation_date date,
    return_date date,
    is_returned INT,
    book_id INT,
    user_id INT,
    FOREIGN KEY (book_id) REFERENCES book(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);