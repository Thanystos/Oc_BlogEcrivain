<?php
    include 'Model/Report.php';
    include_once 'Model/ReportsManager.php';
    include_once 'Model/CommentsManager.php';
    include_once 'Model/UsersManager.php';
    include_once 'View/View.php';
    
    class ControllerReport {
        private $reportsManager;
        private $commentsManager;
        private $usersManager;
        
        // Méthode appelée lors d'un signalement de commentaire
        public function createReport() {
            $this->reportsManager = new ReportsManager();
            $this->usersManager = new UsersManager();
            
            $report = new Report();
            $report->setIdComment(filter_input(INPUT_GET, 'id_comment'));
            $report->setIdUser($_SESSION['id_user']);

            $this->reportsManager->create($report);

            // Incrémentation du nombre de fois qu'un utilisateur a été signalé
            $this->usersManager->updateReport(filter_input(INPUT_GET, 'pseudo'));      
            header('Location: billet_'.$_SESSION['id_ticket'].'-'.$_SESSION['page'].'.html');
        }
        
        // Méthode appelée quand on souhaite accéder à la page listant les signalements (ADMIN)
        public function reportsList() {
            $this->commentsManager = new CommentsManager();
            $this->reportsManager = new ReportsManager();
            
            $requestComments = $this->commentsManager->readReports();
            $requestReports = $this->reportsManager->readReports();
            $reportsListtView = new View('ReportsList');
            $reportsListtView->generate(array('requestComments' => $requestComments, 'requestReports' => $requestReports));
        }
    }