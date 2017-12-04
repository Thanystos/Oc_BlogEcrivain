<?php
session_start();
    include 'Model/User.php';
    include 'Model/UsersManager.php';
    include 'Model/Billet.php';
    include 'Model/BilletsManager.php';
    include 'Model/Commentaire.php';
    include 'Model/CommentairesManager.php';
    include 'Model/Signalement.php';
    include 'Model/SignalementsManager.php';
    
    function inscription() {
        if(isset($_FILES['image'])&&($_FILES['image']['error'] == 0)) {  // Erreur d'envoi
            // Vérifications des doublons et de l'image
            if (!UsersManager::verify(filter_input(INPUT_POST, 'pseudo'))) {  // Doublon de pseudo
                if(($_FILES['image']['size'] <= 1000000)) {  // Taille excessive
                    $infosfichier = pathinfo($_FILES['image']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                    if(in_array($extension_upload, $extensions_autorisees)) {  // Extension non autorisée
                        move_uploaded_file($_FILES['image']['tmp_name'], 'Public/Images/' . basename($_FILES['image']['name']));
                        
                        $_SESSION['pseudo'] = filter_input(INPUT_POST, 'pseudo');
                        $mdp_hache = password_hash(filter_input(INPUT_POST, 'mdp'), PASSWORD_BCRYPT);

                        $user = new User();
                        $user->setPseudo(filter_input(INPUT_POST, 'pseudo'));
                        $user->setEmail(filter_input(INPUT_POST, 'email'));
                        $user->setMdp($mdp_hache);
                        $user->setImage($_FILES['image']['name']);
                        
                        $_SESSION['pseudo'] = filter_input(INPUT_POST, 'pseudo');
                        $_SESSION['email'] = filter_input(INPUT_POST, 'email');
                        $_SESSION['image'] = $_FILES['image']['name'];
                        $_SESSION['role'] = 1;
                        $_SESSION['ban'] = 0;

                        UsersManager::create($user);
                        $requete = UsersManager::readId($_SESSION['pseudo']);
                        $id = $requete->fetch();
                        $_SESSION['id_utilisateur'] = $id['id'];
                        echo 'Inscription réussie !';
                        listBillets();
                    }
                    else {
                        echo "Format de l'image incorrect !";
                    }
                }
                else {
                    echo 'Taille de l\'image excessive !';
                }
                
            }
            else {
                echo "Pseudo déjà existant !";
            }
            
        }
        else {
            echo 'Erreur lors de l\'envoi !';
        }
    }
    
    function connexion() {
        if(filter_input(INPUT_POST, 'pseudo')&&(filter_input(INPUT_POST, 'mdp'))){
            $requete = UsersManager::read(filter_input(INPUT_POST, 'pseudo'), filter_input(INPUT_POST, 'mdp'));
            if($requete) {
                $_SESSION['id_utilisateur'] = $requete['id'];
                $_SESSION['pseudo'] = $requete['pseudo'];
                $_SESSION['email'] = $requete['email'];
                $_SESSION['image'] = $requete['image'];
                $_SESSION['role'] = $requete['role'];
                $_SESSION['ban'] = $requete['ban'];
                listBillets();
            }
            else {
                echo 'Mauvais identifiant ou mot de passe !';
            }
        }
        else {
            echo 'Tous les champs ne sont pas remplis';
        }
    }
    
    function listBillets() {
        $cache = 'View/Cache/listbillets.php';
        $expire = time() -2;

        if(file_exists($cache) && filemtime($cache) > $expire) {
            include 'View/nav.php';
            readfile($cache);
        }
        else {
            $requete = BilletsManager::readAll();
            function resume($chaine) {
                if(strlen($chaine) >= 200) {
                    $chaine = substr($chaine, 0, 200);
                    $espace = strrpos($chaine, ' ');
                    return $chaine = substr($chaine, 0, $espace)."...";
                }
                else {
                    return $chaine;
                }
            }
            include 'View/nav.php';
            ob_start();
            include 'View/ListBillets.php';
            $page = ob_get_contents();
            ob_end_clean();
            file_put_contents($cache, $page) ;
            echo $page ;
        }
    }
    
	function uniBillet() {
        $requeteBillet = BilletsManager::read(filter_input(INPUT_GET, 'id_billet'));
        $requeteNbCommentaire = CommentairesManager::count(filter_input(INPUT_GET, 'id_billet'));
        $requeteCommentaire = CommentairesManager::read(filter_input(INPUT_GET, 'id_billet'));
        $requeteSignalement = null;
        if(isset($_SESSION['id_utilisateur'])) {
            $requeteSignalement = SignalementsManager::read(filter_input(INPUT_GET, 'id_billet'), $_SESSION['id_utilisateur']);
        }
        include 'View/UniBillet.php';
    }
    
    function addCommentaire() {
        $comm = new Commentaire();
        $comm->setText(filter_input(INPUT_POST, 'comm'));
        $comm->setIdBillet($_SESSION['id_billet']);
        $comm->setIdUtilisateur($_SESSION['id_utilisateur']);
        CommentairesManager::create($comm);
        header('Location: billet_'.$_SESSION['id_billet'].'.html');
    }
    
    function modifCommentaire() {
        CommentairesManager::update(filter_input(INPUT_GET, 'id_commentaire'), filter_input(INPUT_POST, 'text'));
        header('Location: billet_'.$_SESSION['id_billet'].'.html');
    }
    
    function suppCommentaire() {
        CommentairesManager::delete(filter_input(INPUT_GET, 'id_commentaire'));
        header('Location: billet_'.$_SESSION['id_billet'].'.html');
    }
    
    function createSignalement() {
        $signalement = new Signalement();
        $signalement->setIdCommentaire(filter_input(INPUT_GET, 'id_commentaire'));
        $signalement->setIdUtilisateur($_SESSION['id_utilisateur']);
        
        SignalementsManager::create($signalement);
        UsersManager::updateSignal(filter_input(INPUT_GET, 'pseudo'));
        
        header('Location: billet_'.$_SESSION['id_billet'].'.html');
    }
	
    function addBillet() {
        $billet = new Billet();
        $billet->setTitre(filter_input(INPUT_POST, 'titre'));
        $billet->setText(filter_input(INPUT_POST, 'text'));
        $billet->setIdUtilisateur($_SESSION['id_utilisateur']);
        
        BilletsManager::create($billet);
        header('Location: listebillets.html');
    }
	
	function modifBillet() {
        BilletsManager::update(($_SESSION['id_billet']), filter_input(INPUT_POST, 'text'));
        header('Location: billet_'.$_SESSION['id_billet'].'.html');
    }
    
    function suppBillet() {
        echo $_SESSION['id_billet'];
        BilletsManager::delete($_SESSION['id_billet']);
        header('Location: listebillets.html');
    }
	
	function listUtilisateurs() {
        $requete = UsersManager::readall();
        include 'View/ListUtilisateurs.php';
    }
    
    function listSignalements() {
       $requete = CommentairesManager::readSignal();
       include 'View/ListeSignalements.php';
    }
    
    function updateStatus() {
        UsersManager::updateStatut(filter_input(INPUT_GET, 'id_utilisateur'));
        listUtilisateurs();
    }
    
    function suppUtilisateur() {
        unlink('Public/Images/'.filter_input(INPUT_GET, 'image'));
        UsersManager::delete(filter_input(INPUT_GET, 'id'));
        header('Location: listeutilisateurs.html');
    }