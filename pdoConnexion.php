<?php

/**
 * Classe d'accès aux donnèes. 

 * Utilise les services de la classe PDO

 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $objPdo de type PDO 
 * $objPdoConnexion qui contiendra l'unique instance de la classe
 * @author 
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */
class PdoConnexion {

    private static $strServeur = 'mysql:host=localhost';
    private static $strBdd = 'dbname=morphee';
    private static $strUser = 'root';
    private static $strMdp = '';
    private static $objPdo;
    private static $objPdoConnexion = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
        try {
            PdoConnexion::$objPdo = new PDO(PdoConnexion::$strServeur . ';' . PdoConnexion::$strBdd, PdoConnexion::$strUser, PdoConnexion::$strMdp);
            PdoConnexion::$objPdo->query("SET CHARACTER SET utf8");
            PdoConnexion::$objPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo 'Echec lors de la connexion ! ' . $e->getMessage();
            die();
        }
    }

    /**
     * destructeur de la classe
     * 
     */
    public function __destruct() {
        PdoConnexion::$objPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * @return l'objet objPdo de la classe PdoConnexion
     */
    public static function getPdoConnexion() {
        if (PdoConnexion::$objPdoConnexion == null) {
            PdoConnexion::$objPdoConnexion = new PdoConnexion();
        }
        return PdoConnexion::$objPdo;
    }

}
