/* Le mot de passe est toujours défini comme : Azerty12 (respecter la casse) */
INSERT INTO projet_tutore_web.users (last_name, first_name, password, street_name, zip_code, district, city, mobile_number, email_address) VALUES ('FRAPPIER', 'Mayhew', '$argon2id$v=19$m=65536,t=4,p=1$VkNXRHNRTW8wMVNFZC5HVQ$dkVFak6nwknIbxSDEoGt5qsH4GkhToSWAn+mAzD7jUU', '71, Rue De La Pompe', 91100, 'Fond Mondétour', 'ORSAY', 433603785, 'mayhewfrappier@teleworm.us');
INSERT INTO projet_tutore_web.users (last_name, first_name, password, street_name, zip_code, district, city, mobile_number, email_address) VALUES ('ESPERANZA', 'Brunelle', '$argon2id$v=19$m=65536,t=4,p=1$OS5CU1VMYm9hUi8yb3Y4aQ$6LmJrnkhGc+ms9Np4EerK1buqagdgkGmdHo2B5aVp18', '37, Rue Gontier-Patin', 91110, 'Fond Mondétour', 'ORSAY', 484713132, 'esperanzabrunelle@armyspy.com');
INSERT INTO projet_tutore_web.users (last_name, first_name, password, street_name, zip_code, district, city, mobile_number, email_address) VALUES ('BLONDLOT', 'Ormazd', '$argon2id$v=19$m=65536,t=4,p=1$UkxreVdxQmJGcDYzVlpFTQ$p6Y3FFKrcvWu16bTo5Gh6uERn7RfQfBKKIl7n7R/zUM', '97, Avenue Du Marechal Juin', 91110, 'Haut Mondétour', 'ORSAY', 214749174, 'ormazdblondlot@teleworm.us');
INSERT INTO projet_tutore_web.users (last_name, first_name, password, street_name, zip_code, district, city, mobile_number, email_address) VALUES ('LALONDE', 'Thomas', '$argon2id$v=19$m=65536,t=4,p=1$aTQ1TjgvMHEwMk5uM0x2Tg$Fr84Z5yF/ElszgSLem4oT7DxfH6gNpbZd7Mk9m7Ch/s', '69, Rue Des Dunes', 91110, 'Haut Mondétour', 'ORSAY', 557683233, 'thomaslalonde@armyspy.com');
INSERT INTO projet_tutore_web.users (last_name, first_name, password, street_name, zip_code, district, city, mobile_number, email_address) VALUES ('OLIVIER', 'Pomerleau', '$argon2id$v=19$m=65536,t=4,p=1$Zi9CYi5US0RIUXkvenEyaQ$P5Yr1jXucGsP+zIQTxoWK9D+fCcGjUvxCirOyAG0mng', '58, Boulevard De Prague', 91110, 'Haut Guichet Centre Ouest', 'ORSAY', 415671189, 'olivierpomerleau@rhyta.com');

/* Des commandes */
INSERT INTO projet_tutore_web.orders (id_user, date, status) VALUES (2, '2020-12-31 15:33:14', 3);
INSERT INTO projet_tutore_web.orders (id_user, date, status) VALUES (2, '2020-12-31 15:35:21', 2);
INSERT INTO projet_tutore_web.orders (id_user, date, status) VALUES (3, '2020-12-31 15:37:49', 1);
INSERT INTO projet_tutore_web.orders (id_user, date, status) VALUES (4, '2020-12-31 15:39:15', 0);
INSERT INTO projet_tutore_web.orders (id_user, date, status) VALUES (2, '2020-12-31 15:42:25', 0);
INSERT INTO projet_tutore_web.orders (id_user, date, status) VALUES (3, '2020-12-31 16:05:02', 0);

/* Informations de paiement */
INSERT INTO projet_tutore_web.`users.payment` (id_user, name, number, cvv, expiration_date) VALUES (1, null, null, null, null);
INSERT INTO projet_tutore_web.`users.payment` (id_user, name, number, cvv, expiration_date) VALUES (2, null, null, null, null);
INSERT INTO projet_tutore_web.`users.payment` (id_user, name, number, cvv, expiration_date) VALUES (3, null, null, null, null);
INSERT INTO projet_tutore_web.`users.payment` (id_user, name, number, cvv, expiration_date) VALUES (4, null, null, null, null);
INSERT INTO projet_tutore_web.`users.payment` (id_user, name, number, cvv, expiration_date) VALUES (5, null, null, null, null);