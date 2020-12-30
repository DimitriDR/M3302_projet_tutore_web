CREATE OR REPLACE TABLE projet_tutore_web.products
(
    id_product     int AUTO_INCREMENT PRIMARY KEY,
    label          varchar(100) NOT NULL,
    type           varchar(7)   NULL,
    classification varchar(200) NULL,
    description    text         NULL,
    price          double       NULL,
    season         varchar(13)  NULL
)
    COMMENT 'Table contenant tous les produits';

CREATE OR REPLACE TABLE projet_tutore_web.`products.inventory`
(
    id_product_inventory int AUTO_INCREMENT,
    id_product           int   NOT NULL,
    quantity             int   NULL,
    discount_rate        float NULL,
    PRIMARY KEY (id_product_inventory, id_product),
    CONSTRAINT `products.inventory_products_id_product_fk`
        FOREIGN KEY (id_product) REFERENCES projet_tutore_web.products (id_product)
)
    COMMENT 'Table contenant le nombre d''articles en stock';

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

/* Les vues utilisées pour l'administration */
CREATE OR REPLACE DEFINER = root@localhost VIEW projet_tutore_web.`backoffice.products` AS
SELECT `projet_tutore_web`.`products`.`id_product`              AS `id_product`,
       `projet_tutore_web`.`products.inventory`.`quantity`      AS `quantity`,
       `projet_tutore_web`.`products.inventory`.`discount_rate` AS `discount_rate`
FROM (`projet_tutore_web`.`products`
         JOIN `projet_tutore_web`.`products.inventory`
              ON (`projet_tutore_web`.`products`.`id_product` = `projet_tutore_web`.`products.inventory`.`id_product`));

CREATE OR REPLACE DEFINER = root@localhost VIEW projet_tutore_web.backoffice_orders AS
SELECT `projet_tutore_web`.`orders`.`id_order`   AS `id_order`,
       `projet_tutore_web`.`orders`.`date`       AS `date`,
       `projet_tutore_web`.`orders`.`status`     AS `status`,
       `projet_tutore_web`.`users`.`last_name`   AS `last_name`,
       `projet_tutore_web`.`users`.`first_name`  AS `first_name`,
       `projet_tutore_web`.`users`.`street_name` AS `street_name`,
       `projet_tutore_web`.`users`.`city`        AS `city`
FROM (`projet_tutore_web`.`orders`
         JOIN `projet_tutore_web`.`users`
              ON (`projet_tutore_web`.`orders`.`id_user` = `projet_tutore_web`.`users`.`id_user`));