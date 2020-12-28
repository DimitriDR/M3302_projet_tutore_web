CREATE OR REPLACE TABLE products
(
    id_product     int AUTO_INCREMENT PRIMARY KEY,
    label          varchar(100) NOT NULL,
    season         varchar(9)   NULL,
    classification varchar(200) NULL,
    description    text         NULL,
    price          double       NULL
)
    COMMENT 'Table contenant tous les produits';

CREATE OR REPLACE TABLE users
(
    id_user       int AUTO_INCREMENT PRIMARY KEY,
    last_name     varchar(50)  NOT NULL,
    first_name    varchar(50)  NOT NULL,
    password      varchar(255) NULL,
    street_name   varchar(255) NULL,
    zip_code      int          NULL,
    district      varchar(50)  NULL,
    city          varchar(60)  NULL,
    mobile_number int          NULL,
    email_address varchar(255) NOT NULL
)
    COMMENT 'Table contenant tous les utilisateurs.';

CREATE OR REPLACE TABLE `users.rights`
(
    id_right       int AUTO_INCREMENT PRIMARY KEY,
    id_user        int          NOT NULL,
    admin_password varchar(255) NULL,
    CONSTRAINT `users.rights_id_user_uindex`
        UNIQUE (id_user),
    CONSTRAINT `users.rights_users_id_user_fk`
        FOREIGN KEY (id_user) REFERENCES projet_tutore_web.users (id_user)
)
    COMMENT 'Table contenant les droits des utilisateurs';