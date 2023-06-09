<?php

use model\mappingClass\MappingArticle;
use model\managerClass\ManagerArticle;


// require de la config:
require_once "../config.php";


// require_once "../vendor/autoload.php"; -> Appel des dépendances qui gèrent les mails


// Autoload des classes (/model/) :
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require '../' . $class . '.php';
});

echo "<pre>";
//var_dump($test1,$test2);
echo "</pre>";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new PDO(DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET,DB_LOGIN,DB_PWD);
    $manager = new \model\managerClass\ManagerArticle($db);
    $article = new MappingArticle([
        "mwTitleArt" => $_POST['mw_title_art'],
        "mwContentArt" => $_POST['mw_content_art'],
        "mwVisibleArt" => $_POST['mw_visible_art'],
        "mwSectionMwIdSection" => $_POST['mw_section_mw_id_section'],
    ]);

    $insertedArticle = $manager->insert($article);
    // Maintenant, vous pouvez utiliser $insertedArticle...
}
echo "<pre>";
//var_dump($insertedArticle);
echo "</pre>";
?>

    <html>
    <head>
        <title>Insert Article</title>
    </head>
    <body>
    <h1>Insert Article</h1>
    <form action="" method="post">
        <label for="mw_title_art">Title:</label><br>
        <input type="text" id="mw_title_art" name="mw_title_art"><br>

        <label for="mw_content_art">Content:</label><br>
        <textarea id="mw_content_art" name="mw_content_art" rows="4" cols="50"></textarea><br>

        <label for="mw_visible_art">Visible:</label><br>
        <select id="mw_visible_art" name="mw_visible_art">
            <option value="1">Visible</option>
            <option value="0">Not Visible</option>
        </select><br>

        <label for="mw_section_mw_id_section">Section ID:</label><br>
        <input type="number" id="mw_section_mw_id_section" name="mw_section_mw_id_section"><br>

        <input type="submit" value="Submit">
    </form>
<?php
//var_dump($_POST);
echo "<pre>";
//var_dump($article);
echo "</pre>";
?>
    </body>
    </html>
