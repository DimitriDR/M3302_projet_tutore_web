CREATE OR REPLACE TABLE projet_tutore_web.products
(
    id_product     int AUTO_INCREMENT PRIMARY KEY,
    label          varchar(100) NOT NULL,
    season         varchar(9)   NULL,
    classification varchar(200) NULL,
    description    text         NULL,
    price          double       NULL,
    category       varchar(7)   NULL
)
    COMMENT 'Table contenant tous les produits';

CREATE OR REPLACE TABLE projet_tutore_web.users
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

CREATE OR REPLACE TABLE projet_tutore_web.orders
(
    id_order int AUTO_INCREMENT PRIMARY KEY,
    id_user  int      NOT NULL,
    date     datetime NULL,
    status   int      NULL,
    CONSTRAINT orders_users_id_user_fk
        FOREIGN KEY (id_user) REFERENCES projet_tutore_web.users (id_user)
)
    COMMENT 'Table contenant toutes les commandes';

CREATE OR REPLACE TABLE projet_tutore_web.products_orders
(
    id_product int NOT NULL,
    id_order   int NOT NULL,
    quantity   int NOT NULL,
    PRIMARY KEY (id_product, id_order),
    CONSTRAINT products_orders_orders_id_order_fk
        FOREIGN KEY (id_order) REFERENCES projet_tutore_web.orders (id_order),
    CONSTRAINT products_orders_products_id_product_fk
        FOREIGN KEY (id_product) REFERENCES projet_tutore_web.products (id_product)
)
    COMMENT 'Table contenant les produits en fonction des commandes';

CREATE OR REPLACE TABLE projet_tutore_web.`users.payment`
(
    id_payment      int AUTO_INCREMENT PRIMARY KEY,
    id_user         int          NULL,
    name            varchar(255) NULL,
    number          char(19)     NULL,
    ccv             int(3)       NULL,
    expiration_date char(7)      NULL,
    CONSTRAINT `users.payment_users_id_user_fk`
        FOREIGN KEY (id_user) REFERENCES projet_tutore_web.users (id_user)
);

CREATE OR REPLACE TABLE projet_tutore_web.`users.rights`
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