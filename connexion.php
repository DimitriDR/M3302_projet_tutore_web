<?php
const HOST = "localhost";
const DB_NAME = "projet_tutore_web";
const USER = "root";
const PASSWORD = "root";

// Création d'une connexion à la base de données
try {
    $PDO = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME . ";charset=UTF8", USER, PASSWORD);
} catch (PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la base de données <br />" . $e->getMessage());
}