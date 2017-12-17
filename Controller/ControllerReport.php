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
        
        public function __construct() {
            $this->reportsManager = new ReportsManager();
            $this->commentsManager = new CommentsManager();
            $this->usersManager = new UsersManager();
        }
        
        // Méthode appelée lors d'un signalement de commentaire
        function createReport() {
            $report = new Report();
            $report->setIdComment(filter_input(INPUT_GET, 'id_comment'));
            $report->setIdUser($_SESSION['id_user']);

            $this->reportsManager->create($report);

            // Incrémentation du nombre de fois qu'un utilisateur a été signalé
            $this->usersManager->updateReport(filter_input(INPUT_GET, 'pseudo'));      
            header('Location: billet_'.$_SESSION['id_ticket'].'-'.$_SESSION['page'].'.html');
        }
        
        // Méthode appelée quand on souhaite accéder à la page listant les signalements (ADMIN)
        function reportsList() {
            $requestComments = $this->commentsManager->readReports();
            $requestReports = $this->reportsManager->readReports();
            $reportsListtView = new View('ReportsList');
            $reportsListtView->generate(array('requestComments' => $requestComments, 'requestReports' => $requestReports));
        }
    }