<?php
if (isset($_GET['error'])){
    echo $_GET['error'];
}
else{

    // if there is no error in url redirect to main page,
    // dont want any lone wanderer to find this page
    // without any good reason
    header("Location: Index");  //redirect to the main page
    exit();
}

?>

<a href="Index">Retourner l'accueil</a>