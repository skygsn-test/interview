CREATE TABLE contacts
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    type VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    responsible VARCHAR(100) NOT NULL,
    date_created DATETIME NOT NULL,
    person_created VARCHAR(100) NOT NULL,
    date_edited DATETIME NOT NULL,
    person_edited VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    source VARCHAR(100) NOT NULL,
    subscription VARCHAR(100) NOT NULL,
    rate INT NOT NULL
);