<?php
require_once "databaselink.php";

/**
 * Classe User
 * Représente un utilisateur
 */
class User {
    /** @var int Identifiant unique de l'utilisateur */
    private int $id_user;

    /** @var string Nom de l'utilisateur */
    private string $last_name;

    /** @var string Prénom de l'utilisateur */
    private string $first_name;

    /** @var string Numéro et nom de la rue */
    private string $street_name;

    /** @var int Code postal de la ville */
    private int $zip_code;

    /** @var string Le quartier / arrondissement */
    private string $district;

    /** @var string Nom de la ville où l'utilisateur réside */
    private string $city;

    /** @var int Numéro de téléphone (portable ou fixe) */
    private int $mobile_number;

    /** @var string Adresse e-mail de l'utilisateur */
    private string $email_address;

    /** @var string Token anti-CSRF */
    private string $token;

    /** @var string|null Nom figurant sur la carte bancaire */
    private ?string $credit_card_name;

    /** @var string|null Numéro de la carte bancaire */
    private ?string $credit_card_number;

    /** @var string|null CVV de la carte bancaire */
    private ?string $credit_card_security_number;

    /** @var string|null Date d'expiration de la carte */
    private ?string $credit_card_expiration_date;

    /**
     * Retourne l'ID de l'utilisateur
     * @return int
     */
    public function get_id_user(): int {
        return $this->id_user;
    }

    /**
     * @return string
     */
    public function get_last_name(): string {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function get_first_name(): string {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function get_street_name(): string {
        return $this->street_name;
    }

    /**
     * @return int
     */
    public function get_zip_code(): int {
        return $this->zip_code;
    }

    /**
     * @return string
     */
    public function get_district(): string {
        return $this->district;
    }

    /**
     * @return string
     */
    public function get_city(): string {
        return $this->city;
    }

    /**
     * @return int
     */
    public function get_mobile_number(): int {
        return $this->mobile_number;
    }

    /**
     * @return string
     */
    public function get_email_address(): string {
        return $this->email_address;
    }

    /**
     * @return string|null
     */
    public function get_credit_card_name(): ?string {
        return $this->credit_card_name;
    }

    /**
     * @return string|null
     */
    public function get_credit_card_number(): ?string {
        return $this->credit_card_number;
    }

    /**
     * @return string|null
     */
    public function get_credit_card_security_number(): ?string {
        return $this->credit_card_security_number;
    }

    /**
     * @return string|null
     */
    public function get_credit_card_expiration_date(): ?string {
        return $this->credit_card_expiration_date;
    }

    /**
     * Retourne le token de l'utilisateur
     * @return string
     */
    public function get_token(): string {
        return $this->token;
    }

    /**
     * Méthode permettant de vérifier si au moins un attribut est nul.
     * @return bool Vrai si un attribut est vide, faux sinon.
     */
    public function are_attributes_empty(): bool {
        foreach (get_object_vars($this) as $attribute) {
            if (is_null($attribute)) {
                return true;
            }
        }

        return false;
    }

    public function register(string $last_name, string $first_name, string $password, string $street_name, int $zip_code, string $district, string $city, int $mobile_number, string $email_address): bool {
        // Connexion à la base de données
        $database_link = new DatabaseLink();

        // Création d'un mot de passe chiffré avec l'algorithme ARGON2ID
        $secure_password = password_hash($password, PASSWORD_ARGON2ID);

        // Une requête préparée car on doit insérer des informations données par l'utilisateur
        $register = $database_link->make_query("INSERT INTO `users` (last_name, first_name, password, street_name, zip_code, district, city, mobile_number, email_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $last_name,
            $first_name,
            $secure_password,
            $street_name,
            $zip_code,
            $district,
            $city,
            $mobile_number,
            $email_address
        ]);

        $user_id = $database_link->get_last_id();

        // On fait une requête pour créer une ligne dans les informations de paiement
        $database_link->make_query("INSERT INTO `users.payment` (id_user, name, number, cvv, expiration_date) VALUES (?, NULL, NULL, NULL, NULL)", [$user_id]);

        // Si on n'a pas un retour égal à false, la requête s'est bien passée
        if ($register) {
            return true;
        } else {
            return false;
        }
    }

    public function check_credentials(string $email, string $password): bool {
        $databaselink = new DatabaseLink();
        $get_user_password = $databaselink->make_query("SELECT `password` FROM users WHERE `email_address` = ?", [$email]);

        if ($databaselink->number_of_returned_rows($get_user_password)) {
            if (password_verify($password, $get_user_password->fetchColumn())) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Méthode pour générer un token anti-CSRF
     * @return string Le token
     */
    public function create_token(): string {
        try {
            return bin2hex(random_bytes(32));
        } catch (Exception $e) {
            die("Une erreur s'est produite lors de la génération du token :<br />" . $e->getMessage());
        }
    }

    /**
     * Méthode permettant de connecter l'utilisateur en créant une session contenant ses informations.
     * @param string $email L'adresse e-mail de l'utilisateur à connecter
     */
    public function login(string $email): void {
        $databaselink = new DatabaseLink();

        $user_information_query = $databaselink->make_query("SELECT * FROM `view.users` WHERE `email_address` = ?", [$email]);
        $user_information_fetch = $user_information_query->fetch();

        if ($databaselink->number_of_returned_rows($user_information_query) == 1) {
            $this->id_user = $user_information_fetch->id_user;
            $this->last_name = $user_information_fetch->last_name;
            $this->first_name = $user_information_fetch->first_name;
            $this->street_name = $user_information_fetch->street_name;
            $this->zip_code = $user_information_fetch->zip_code;
            $this->district = $user_information_fetch->district;
            $this->city = $user_information_fetch->city;
            $this->mobile_number = $user_information_fetch->mobile_number;
            $this->email_address = $user_information_fetch->email_address;
            $this->token = $this->create_token();
            $this->credit_card_name = $user_information_fetch->name;
            $this->credit_card_number = $user_information_fetch->number;
            $this->credit_card_security_number = $user_information_fetch->cvv;
            $this->credit_card_expiration_date = $user_information_fetch->expiration_date;
        }
    }

    /**
     * Méthode pour mettre à jour les informations de l'utilisateur
     * @param int $user_id
     * @param string $last_name
     * @param string $first_name
     * @param string $street_name
     * @param string $zip_code
     * @param string $district
     * @param string $city
     * @param string $mobile_number
     * @param string $email_address
     */
    public function update(int $user_id, string $last_name, string $first_name, string $street_name, string $zip_code, string $district, string $city, string $mobile_number, string $email_address): void {
        $databaselink = new DatabaseLink();
        $databaselink->make_query("UPDATE `users` SET `last_name` = ?, `first_name` = ?, `street_name` = ?, `zip_code` = ?, `district` = ?, `city` = ?, `mobile_number` = ?, `email_address` = ? WHERE `id_user` = ?", [$last_name, $first_name, $street_name, $zip_code, $district, $city, $mobile_number, $email_address, $user_id]);
    }

    /**
     * Méthode pour mettre à jour les données de paiment
     * @param int $user_id L'ID de l'utilisateur auquel on doit racheter les informations de la carte
     * @param string $credit_card_name Le nom sur la carte de crédit
     * @param string $credit_card_number Le numéro de la carte de crédit
     * @param string $credit_card_security_number Le CCV de la carte
     * @param string $credit_card_expiration_date La date d'expiration de la carte
     */
    public function update_banking_information(int $user_id, string $credit_card_name, string $credit_card_number, string $credit_card_security_number, string $credit_card_expiration_date): void {
        $databaselink = new DatabaseLink();
        $databaselink->make_query("UPDATE `users.payment` SET `name` = ?, `number` = ?, `cvv` = ?, `expiration_date` = ? WHERE `id_user` = ?", [$credit_card_name, $credit_card_number, $credit_card_security_number, $credit_card_expiration_date, $user_id]);
    }
}