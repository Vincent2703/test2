<?php
/**
 * Classe d'accès aux données
 * Gère la table contact
 */
class pdoContact {
    /**
     * Fonction qui permet d'insérer un contact dans la base de données.
     * @param integer $id  Numéro du contact
     * @param string $nom    Nom du contact
     * @param string $prenom  Prénom du contact
     * @param string $mail    Mail du contact
     * @param string $telF   Téléphone fixe du contact 
     * @param string $telP Téléphone portable du contact
     * @param integer $priv Privilege ou non du contact
	 * @param integer $idDistri id du distributeur associé
     * @return boolean  True si l'ajout a été effectué, False si l'ajout a échoué. 
     */
    public static function insertContact($id, $nom, $prenom, $mail, $telF, $telP, $priv, $idDistri) {
        try {
            $objPdo = PdoConnexion::getPdoConnexion();

            $nom = addslashes($nom);
            $prenom= addslashes($prenom);

            $req = "INSERT INTO contact (id, nom, prenom, mail, tel_fixe, tel_portable, privilegie, id_distributeur) "
                    . "VALUES ($id, '$nom', '$prenom', '$mail', '$telF', '$telP', $priv, $idDistri)";

            $objPdo->exec($req);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

	/**
	* 
	*/
	public static function retirerPriv($id) {
        try {
            $objPdo = PdoConnexion::getPdoConnexion();

            $req = "UPDATE contact SET privilegie = 0 WHERE id=$id";

            $objPdo->exec($req);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
	
    /**
     * Fonction qui met à jour un contact dans la base de données
     * @param integer $id  Numéro du contact
     * @param string $mail    Mail du contact
     * @param string $telF   Téléphone fixe du contact 
     * @param string $telP Téléphone portable du contact
     * @param integer $priv Privilege ou non du contact
	 * @param integer $idDistri id du distributeur associé
     * @return boolean  True si la modification a été effectuée, false si la modification a échoué.
     */
	public static function updateContact($id, $mail, $telF, $telP, $privilegie) {
        try {
            $objPdo = PdoConnexion::getPdoConnexion();

            if ($privilegie == 1) {
                $infoContact = pdoContact::getUnContact($id);
                $idDist = $infoContact['id_distributeur'];
                $req = "UPDATE contact                                
                    SET privilegie = 0 
                    WHERE id_distributeur = $idDist ";
                $objPdo->exec($req);
            }
            $req = "UPDATE contact "
                    . "SET mail = '$mail', "
                    . "tel_fixe = '$telF', "
                    . "tel_portable = '$telP', "
                    . "privilegie = '$privilegie' "
                    . "WHERE id = $id";
            $objPdo->exec($req);


            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Fonction supprimant un contact de la base de données
     * @param $id l'id du contact à supprimer de la base de données
     * @return boolean  True si le contact a été supprimé, false si la suppression a échouée. 
     */
    public static function deleteContact($id) {

        try {
            $objPdo = PdoConnexion::getPdoConnexion();
            $req = "DELETE FROM contact WHERE id = $id";

            $objPdo->exec($req);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Fonction permettant d'obtenir les contacts associés à un distributeur donné
     * @return Array $lesContacts   Un tableau des contacts  
     */
    public static function getLesContacts($idDistri) {
        $objPdo = PdoConnexion::getPdoConnexion();
        $req = "SELECT contact.id as idCon, nom, prenom, mail, tel_fixe, tel_portable, id_distributeur "
                . "FROM contact "
				. "WHERE id_distributeur = $idDistri " 
                . "ORDER BY idCon";

        $res = $objPdo->query($req);
        $lesContacts = $res->fetchAll();

        $res->closeCursor();

        return $lesContacts;
    }

    /**
     * Fonction permettant de récupérer un contact.
     * @param $id  L'identifiant d'un contact.
     * @return Array $leContact  Un contact | boolean  false si la récupération a échoué
     */
    public static function getUnContact($id) {
        try {
            $objPdo = PdoConnexion::getPdoConnexion();
            $req = "SELECT id, nom, prenom, mail, tel_fixe, tel_portable, privilegie, id_distributeur "
                    . "FROM contact "
                    . "WHERE id = $id ";

            $res = $objPdo->query($req);
            $leContact = $res->fetch();

            $res->closeCursor();

            return $leContact;
        } catch (Exception $ex) {
            return false;
        }
    }
	

	
}
