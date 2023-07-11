<?php

// appelle des use mapping :
use model\mappingClass\MappingAgenda;
use model\mappingClass\MappingArticle;
use model\mappingClass\MappingCategoryRessource;
use model\mappingClass\MappingHomepage;
use model\mappingClass\MappingInfo;
use model\mappingClass\MappingLivreDor;
use model\mappingClass\MappingPatient;
use model\mappingClass\MappingPicture;
use model\mappingClass\MappingRessource;
use model\mappingClass\MappingSection;
use model\mappingClass\MappingSubCategoryRessource;
use model\mappingClass\MappingUser;

// appelle des use manager :
use model\managerClass\ManagerAgenda;
use model\managerClass\ManagerArticle;
use model\managerClass\ManagerHomepage;
use model\managerClass\ManagerInfo;
use model\managerClass\ManagerLivreDor;
use model\managerClass\ManagerPatient;
use model\managerClass\ManagerPicture;
use model\managerClass\ManagerRessource;
use model\managerClass\ManagerSection;
use model\managerClass\ManagerUser;


### RECUP LES SECTIONS POUR LA NAVBAR : 

// on stock l'object dans la variable
$sectionManager = new ManagerSection($db); 
// applique la méthode qui contient la requete SQL qui récupére toutes les section
$allSection = $sectionManager -> getAll();
#####


### OUI ###

### on récup les variables pour l'accueil ici parce qu'on va en avoir besoin en plusieur endroit :
// on stocke le manager dans la variable:

### HOMEPAGE : on récup les variables pour l'accueil ici parce qu'on va en avoir besoin en plusieur endroit :
// on stock le manager dans la variable:

$homeManager = new ManagerHomepage($db);
$allHome = $homeManager -> getAll();
##### 

### instanciation de ManagerUser pour se connecter ou pas :
$userManager = new ManagerUser($db);

// deconnection de l'admin
if(isset($_GET['deconnect'])){
    $userManager->disconnect();         
    header("Location: ./");
}
    
// connection à l'admin
if(isset($_POST['login'],$_POST['pwd'])){
    $userMapping = new MappingUser([
        "mwLoginUser" => $_POST['login'],
        "mwPwdUser" => $_POST['pwd']
    ]);
    $connectUser = $userManager->connect($userMapping);
    var_dump($connectUser);

    if($connectUser){
        include_once '../view/privateView/admin.php';
    }else{
        $erreur = "Nom d'utilisateur ou mot de passe incorrect ! "; 
    }
}  
#####


else if(isset($_GET['p'])){

    // navigation publique :
    if($_GET['p'] === "home"){
        // on a créé les variables en haut parce qu"on en a besoin à 3 endroits différents
        include_once "../view/publicView/homepage.php";
    }

    else if($_GET['p'] === "contact"){
        // on va afficher les infos dans la page contact alors on les appelle ici :
        $infoManager = new ManagerInfo($db);
        $allInfo = $infoManager -> getAll();

        include_once "../view/publicView/contactView.php";
    }

    else if($_GET['p'] === "ressources"){
        $ressourceManager = new ManagerRessource($db);

        // on recupère toutes les catégories:
        $getAllCateg = $ressourceManager -> getAllCateg();

        // on récupère toutes les sous catégories :
        $getAllSub = $ressourceManager -> getAllSubCateg();
        include_once "../view/publicView/ressourcesView.php";
    }

    else if($_GET['p'] === "livreDor"){
        
        $livreManager = new ManagerLivreDor($db);
        // appel de la méthode pour récup les messages du livre d'or avec visible=1 :
        $allLivreDor = $livreManager -> getAllVisible();

        // insertion nouveau message dans le livre d'or :
        if(isset($_POST['nameLO'], $_POST['mailLO'], $_POST['messageLO'])){
            // insertion dans le livre d'or
            $newMessageLO = new MappingLivreDor([
                "mwNameLivreDor" => $_POST['nameLO'],
                "mwMailLivreDor" => $_POST['mailLO'],
                "mwMessageLivreDor" => $_POST['messageLO'],
                "mwDateLivreDor" => $_POST['dateLO']
            ]);
        }
        
        // appel de la vue:
        include_once "../view/publicView/livreDorView.php";
    }

    else if($_GET['p']==="connect"){
        include_once "../view/publicView/connectView.php";
    }

    // Suite du $_get si l'admin est connecté :
    else if(isset($_SESSION['idSession']) && $_SESSION['idSession']==session_id()){
        if($_GET['p']==="admin"){
            include_once '../view/privateView/admin.php';
        }
        else if($_GET['p']==="agenda"){
            include_once '../view/privateView/agendaCrud.php';
        }

        // les inserts
        if(isset($_POST['insertArticle'])){
            if( false /* verification des champs du formulaire ajout de sous section */){
                // $insertSS = insertSS($db);

            }
        }    

        if(isset($_POST['updateArticle'])){
            if( false /* verification des champs du formulaire mise a jour de sous section */ ){
                // $insertSS = insertSS($db);
            }
        } 

        if(isset($_POST['insertRessource'])){
            if( false /* verification des champs du formulaire ajout de ressource */ ){
                // $insertSS = insertSS($db);
            }
        } 

        if(isset($_POST['updateRessource'])){
            if( false /* verification des champs du formulaire mise a jour des ressources */ ){
                // $insertSS = insertSS($db);
            }
        } 

        if(isset($_POST['updatePwd'])){
            if( false /* verification des champs du formulaire mise a jour du mot de passe */ ){
                // $insertSS = insertSS($db);
            }
        } 

        // les updates
        if(isset($_GET['idRessource']) && ctype_digit($_GET['idRessource']) ){
            include_once "../view/privateView/ressourcesEditView.php";
        }

        if(isset($_GET['idArticle']) && ctype_digit($_GET['idArticle'])){
            include_once "../view/privateView/articleEditView.php";
        }

        if(isset($_GET['deleteRessources']) && ctype_digit(($_GET['deleteRessources']))){
            // header("Location: ./?m=L'article dont l'id est $idRessource a été supprimé");
        }

        if(isset($_GET['deleteArticle']) && ctype_digit(($_GET['deleteArticle']))){
            // header("Location: ./?m=L'article dont l'id est $idArticle a été supprimé");
        }

        if(isset($_GET['visibleLO']) && ctype_digit($_GET['visibleLO'])){
            header("location: ./");
        }

        if(isset($_GET['deleteLO']) && ctype_digit($_GET['deleteLO'])){
            header("location: ./");
        }

        if(isset($_GET['banLO']) && ctype_digit($_GET['benLO'])){
            header("location: ./");          
        }
        
        // les deletes :

    }

    else{

        include_once "../view/404.php";
        
    }
    
}

// affichage des sections :
else if(isset($_GET['sectionId']) && ctype_digit($_GET['sectionId'])){
    // on stock l'id de la section
    $idSect = (int) $_GET['sectionId'];

    // on récup la section avec l'id pour afficher le titre
    $sectionById = $sectionManager -> getOneById($idSect);
    
    // on fait le manager des articles
    $articleManager =  new ManagerArticle($db);
    $articleBySection = $articleManager -> getAllArticlesWithPictures($idSect);

    include_once "../view/publicView/sectionView.php";
}

// formulaire de contact :
else if(isset($_POST['nameContact'], $_POST['mailContact'], $_POST['messageContact'])){
    // envois message / mailer
}

else {
    include_once "../view/publicView/homepage.php";
}

