<?php


namespace App\Enum;


class AccountTypeEnum
{

    const ADMIN = "ad";

    const AUTEUR = "au";

    const ROLE_ADMIN = "ROLE_ADMIN";

    const ROLE_AUTEUR = "ROLE_AUTEUR";

    public function getAdmin () {
        return self::ADMIN;
    }

    public function getAuteur () {
        return self::AUTEUR;
    }

    public function getRoleAdmin () {
        return self::ROLE_ADMIN;
    }

    public function getRoleAuteur () {
        return self::ROLE_AUTEUR;
    }
}