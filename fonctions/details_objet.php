<!--Script affichant les details des objets trouves/perdus -->



<?php
        
        if(isset($_GET['details'])){
            //Recuperer la valeur de l'identifiant de l'objet
            $idobjet=$_GET['details'];
            //Inclure le fichier de connexion
            include_once("../includes/connexion.php");
            //Connexion a la base de donnees
            connecte(HOST,USER,PASSWORD);
            //Selectionner la base de donnees
            use_db(DB);
            //Declarationd des variables
            $idObjet='';
            $libelle='';
            $statut='';
            $lieuRamassage='';
            $dateDeclaration='';
            $idAutres = '';
            $idPiece = '';
            $idRamasseur='';
            $idProprietaire  = '';
            $lieuPerte='';
            $datePerte='';
            //Variable pour acceuillir les donnees de celui qui a ramasse ou declare la perte
            $nom='';
            $prenom='';
            $telephone='';
            $email='';
            //Variables pour acceuillir les informations de la piece/autres objet
            $numeroPiece='';
            $nomTitulaire='';
            $nomTitulaire='';
            $marque='';
            $modele='';
            $couleur='';
            $photo='';
            //Pour afficher la balise <img>
            $affichePhoto='';
            //Variable contenant les details
            $details='';
            
            //Execution de la requete dans la base de donnees
            $query= $bdd->query("SELECT *
			FROM objet, personne
			WHERE objet.idObjet='$idobjet' AND 
                              (objet.idRamasseur=personne.idPersonne OR 
                              objet.idProprietaire=personne.idPersonne)");
            //Recuperation du resultat  
            $donnees = $query->fetch();
            $idObjet=$donnees['idObjet'];
            $libelle=$donnees['libelle'];
            $statut=$donnees['statut'];
            $lieuRamassage=$donnees['lieuRamassage'];
            $dateDeclaration=$donnees['dateDeclaration'];
            $idAutres = $donnees['idAutres'];
            $idPiece = $donnees['idPiece'];
            $idRamasseur=$donnees['idRamasseur'];
            $idProprietaire  = $donnees['idProprietaire'];
            $lieuPerte=$donnees['lieuPerte'];
            $datePerte=$donnees['datePerte'];
            
                //OBJETS TROUVES
                if(isset($idRamasseur)){
                        //Details ramasseurs
                        $query4= $bdd->query("SELECT *
                                    FROM personne
                                    WHERE personne.idPersonne='$idRamasseur' ");
                        //Recuperation des details du ramasseur
                        $donnees4=$query4->fetch();
                        $nom=$donnees4['nom'];
                        $prenom=$donnees4['prenom'];
                        $telephone=$donnees4['telephone'];
                        $email=$donnees4['email'];

                        //si une piece
                        if(isset($idPiece)){
                            //Dans ce cas on a une piece
                            $query2= $bdd->query("SELECT *
                                    FROM piece
                                    WHERE piece.idPiece='$idPiece' ");

                            //Recuperation du resultat
                            $donnes2=$query2->fetch();
                            $numeroPiece=$donnees2['numeroPiece'];
                            $nomTitulaire=$donnees2['nomTitulaire'];
                            $prenomTitulaire=$donnees2['prenomTitulaire'];
                            //Construction des details
                            $details .="                     
                                    <tr>
                                        <td>Libelle</td>
                                        <td>{$libelle}</td>
                                    </tr>
                                    <tr>
                                        <td>Numero piece</td>
                                        <td>{$numeroPiece}</td>
                                    </tr>
                                    <tr>
                                        <td>Nom titulaire</td>
                                        <td>{$nomTitulaire}</td>
                                    </tr>
                                    <tr>
                                        <td>Prenom titulaire</td>
                                        <td>{$prenomTitulaire}</td>
                                    </tr>
                                    <tr>
                                        <td>Statut</td>
                                        <td>{$statut}</td>
                                    </tr>
                                     <tr>
                                        <td>Lieu de ramassage</td>
                                        <td>{$lieuRamassage}</td>
                                    </tr>
                                    <tr>
                                        <td>Date de ramassage</td>
                                        <td>{$dateDeclaration}</td>
                                    </tr>
                            ";
                        }
                        else{
                            //Dans le cas ou on a un autre objet
                            $query3= $bdd->query("SELECT *
                                    FROM autres
                                    WHERE autres.idAutres='$idAutres' ");
                            //Recuperation du resultat
                            $donnees3=$query3.fetch();
                            $marque=$donnees3['marque'];
                            $modele=$donnees3['modele'];
                            $couleur=$donnees3['couleur'];
                            $photo=$donnees3['photo'];
                            //Construction des details
                            $affichePhoto .= "<img src='<?php echo $photo; ?>' />";
                            //Construction de l'affichage html pour un objet
                            $details .="
                                    <tr>
                                        <td>Libelle</td>
                                        <td>{$libelle}</td>
                                    </tr>
                                    <tr>
                                        <td>Marque</td>
                                        <td>{$marque}</td>
                                    </tr>
                                    <tr>
                                        <td>Nom titulaire</td>
                                        <td>{$modele}</td>
                                    </tr>
                                    <tr>
                                        <td>Prenom titulaire</td>
                                        <td>{$couleur}</td>
                                    </tr>
                                    <tr>
                                        <td>Statut</td>
                                        <td>{$statut}</td>
                                    </tr>
                                     <tr>
                                        <td>Lieu de ramassage</td>
                                        <td>{$lieuRamassage}</td>
                                    </tr>
                                    <tr>
                                        <td>Date de ramassage</td>
                                        <td>{$dateDeclaration}</td>
                                    </tr>
                            ";
                        }
                }
                //OBJETS PERDUS
                if(isset($idProprietaire)){
                        //Details du declaruer de perte
                        $query4= $bdd->query("SELECT *
                                    FROM personne
                                    WHERE personne.idPersonne='$idProprietaire' ");
                        //Recuperation des details du declareur de perte
                        $donnees4=$query4->fetch();
                        $nom=$donnees4['nom'];
                        $prenom=$donnees4['prenom'];
                        $telephone=$donnees4['telephone'];
                        $email=$donnees4['email'];
                        
                        //si une piece
                        if(isset($idPiece)){
                            //Dans ce cas on a une piece
                            $query2= $bdd->query("SELECT *
                                    FROM piece
                                    WHERE piece.idPiece='$idPiece' ");

                            //Recuperation du resultat
                            $donnes2=$query2->fetch();
                            $numeroPiece=$donnees2['numeroPiece'];
                            $nomTitulaire=$donnees2['nomTitulaire'];
                            $prenomTitulaire=$donnees2['prenomTitulaire'];

                            $details .="                     
                                    <tr>
                                        <td>Libelle</td>
                                        <td>{$libelle}</td>
                                    </tr>
                                    <tr>
                                        <td>Numero piece</td>
                                        <td>{$numeroPiece}</td>
                                    </tr>
                                    <tr>
                                        <td>Nom titulaire</td>
                                        <td>{$nomTitulaire}</td>
                                    </tr>
                                    <tr>
                                        <td>Prenom titulaire</td>
                                        <td>{$prenomTitulaire}</td>
                                    </tr>
                                    <tr>
                                        <td>Statut</td>
                                        <td>{$statut}</td>
                                    </tr>
                                     <tr>
                                        <td>Lieu de perte</td>
                                        <td>{$lieuPerte}</td>
                                    </tr>
                                    <tr>
                                        <td>Date de declaration</td>
                                        <td>{$dateDeclaration}</td>
                                    </tr>
                            ";
                        }
                        else{
                            //Dans le cas ou on a un autre objet
                            $query3= $bdd->query("SELECT *
                                    FROM autres
                                    WHERE autres.idAutres='$idAutres' ");
                            //Recuperation du resultat
                            $donnees3=$query3.fetch();
                            $marque=$donnees3['marque'];
                            $modele=$donnees3['modele'];
                            $couleur=$donnees3['couleur'];
                            $photo=$donnees3['photo'];
                            //Construction des details
                            $affichePhoto .= "<img src='<?php echo $photo; ?>' />";
                            //Construction de l'affichage html pour un objet
                            $details .="
                                    <tr>
                                        <td>Libelle</td>
                                        <td>{$libelle}</td>
                                    </tr>
                                    <tr>
                                        <td>Marque</td>
                                        <td>{$marque}</td>
                                    </tr>
                                    <tr>
                                        <td>Nom titulaire</td>
                                        <td>{$modele}</td>
                                    </tr>
                                    <tr>
                                        <td>Prenom titulaire</td>
                                        <td>{$couleur}</td>
                                    </tr>
                                    <tr>
                                        <td>Statut</td>
                                        <td>{$statut}</td>
                                    </tr>
                                     <tr>
                                        <td>Lieu de perte</td>
                                        <td>{$lieuPerte}</td>
                                    </tr>
                                    <tr>
                                        <td>Date de perte</td>
                                        <td>{$dateDeclaration}</td>
                                    </tr>
                            ";
                        }
                    
                }
        }
 ?>




<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta/>
    </head>
    <body>
        <div>
                <!--Affichage photo-->
                <?php echo($affichePhoto? $affichePhoto:''); ?>
                <h1> Details<h1>
            <table>
                 <!--Affichage details objets-->
                <?php echo ($details?$details:''); ?>
            </table>
        </div>
    </body>
    
</html>