CREATE TABLE IF NOT EXISTS movies(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    release_year INT          NOT NULL,
    format       VARCHAR(20)  NOT NULL,
    stars       VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS users (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    login varchar(30) not null UNIQUE,
    password varchar(100) not null
)