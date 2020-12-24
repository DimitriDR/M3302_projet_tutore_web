CREATE OR REPLACE TABLE projet_tutore_web.produits
(
    id_produit     int AUTO_INCREMENT PRIMARY KEY,
    label          varchar(100) NOT NULL,
    season         varchar(9)   NULL,
    classification varchar(200) NULL,
    description    tinytext     NULL,
    price          double       NULL
);

CREATE OR REPLACE TABLE projet_tutore_web.users
(
    id_user       int AUTO_INCREMENT PRIMARY KEY,
    last_name     varchar(50)  NOT NULL,
    first_name    varchar(50)  NOT NULL,
    password      varchar(255) NULL,
    street_name   varchar(255) NULL,
    street_number int          NULL,
    zip_code      int          NULL,
    district      varchar(50)  NULL,
    city          varchar(60)  NULL,
    mobile_number int          NULL,
    email_address varchar(255) NOT NULL
)
    COMMENT 'Table contenant tous les utilisateurs.';

