<?php

// on peut mettre les titres des rubriques dans la variables $title qu'on utilise dans la balise <title>
$title = "Edition d'article";

// HEAD + HEADER + NAVBAR
include_once "../view/include/header.php";

?>

<!-- HTML -->
<h1><?= $title ?></h1>


<!-- FOOTER -->
<?php

include_once "../view/include/footer.php";
