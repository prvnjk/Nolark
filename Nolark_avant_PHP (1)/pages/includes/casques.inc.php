<?php
$cnx = new PDO('mysql:host=127.0.0.1;port=3307;dbname=base-kamel-nolark', 'root', '');
$pageActive = basename($_SERVER['PHP_SELF'], '.php');

$req = "SELECT casque.*, marque.nom AS marque_nom, type.libelle AS type_nom 
        FROM casque 
        INNER JOIN type ON casque.type = type.id 
        INNER JOIN marque ON casque.marque = marque.id 
        WHERE type.libelle = '$pageActive'";

$res = $cnx->query($req);

while ($ligne = $res->fetch(PDO::FETCH_OBJ)) {
    echo '<article>';
    
    // On force le nom du dossier et de l'image en minuscules pour correspondre aux fichiers Windows
    $dossier = strtolower($ligne->type_nom);
    $nomImage = strtolower($ligne->image);
    
    echo '  <img src="../images/casques/' . $dossier . '/' . $nomImage . '" alt="' . $ligne->modele . '">';
    
    if ($ligne->stock > 0) {
        echo '  <p class="stockok"><abbr data-tip="' . $ligne->stock . ' casques en stock">stock</abbr></p>';
    } else {
        echo '  <p class="stockko"><abbr data-tip="Sur commande uniquement">stock</abbr></p>';
    }
    
    echo '  <p class="prix">' . $ligne->prix . '€</p>';
    echo '  <p class="marque">' . $ligne->marque_nom . '</p>';
    echo '  <p class="modele">' . $ligne->modele . '</p>';
    echo '  <img class="classement classement' . $ligne->classement . '" src="../images/casques/etoiles.gif" alt="Note">';
    echo '</article>';
}
?>