<?php
    include 'Model/Ticket.php';
    include_once 'Model/TicketsManager.php';
    include_once 'Model/CommentsManager.php';
    include_once 'Model/ReportsManager.php';
    include_once 'View/View.php';

    class ControllerTicket {
        private $ticketsManager;
        private $commentsManager;
        private $reportsManager;
        
        public function __construct() {
            $this->ticketsManager = new TicketsManager();
            $this->commentsManager = new CommentsManager();
            $this->reportsManager = new ReportsManager();   
        }
        
        // Méthode appelée lors de la demande de l'affichage de la page de création de billets
        public function addTicketView() {
            $addTicketView = new View('AddTicket');
            $addTicketView->generate();
        }
        
        // Méthode appelée lorsqu'un nouveau billet sera soumis après validation du formulaire présent sur la page de création d'un nouveau billet (ADMIN)
        public function addTicket() {
            $ticket = new Ticket();
            $ticket->setTitre(filter_input(INPUT_POST, 'titre'));
            $ticket->setText(filter_input(INPUT_POST, 'text'));
            $ticket->setIdUtilisateur($_SESSION['id_user']);

            $this->ticketsManager->create($ticket);
            header('Location: listebillets.html');
        }
        
        // Méthode appelée lorsque l'on veut accéder à la page présentant un billet précis
        public function singleTicket() {
            $requestTicket = $this->ticketsManager->read(filter_input(INPUT_GET, 'id_ticket'));
            $requestNbComments = $this->commentsManager->count(filter_input(INPUT_GET, 'id_ticket'));
            $nbComments = $requestNbComments->fetch();
            $_SESSION['nbPageComment'] = ceil($nbComments[0] / 5);
            if(filter_input(INPUT_GET, 'page')&&(filter_input(INPUT_GET, 'page') > 0)&&(filter_input(INPUT_GET, 'page') <= $_SESSION['nbPageComment'])) {
                $requestComments = $this->commentsManager->read(filter_input(INPUT_GET, 'id_ticket'), filter_input(INPUT_GET, 'page'));
                $_SESSION['page'] = filter_input(INPUT_GET, 'page');
            }
            else {
                $requestComments = $this->commentsManager->read(filter_input(INPUT_GET, 'id_ticket'), 1);
                $_SESSION['page'] = 1;
            }
            $requestReports = null;
            if(isset($_SESSION['id_user'])) {
                // Va permettre d'interdire les multiples signalements sur un même commentaire
                $requestReports = $this->reportsManager->read(filter_input(INPUT_GET, 'id_ticket'), $_SESSION['id_user']);
            }
            $viewTicketsList = new View('SingleTicket');
            $viewTicketsList->generate(array('requestTicket' => $requestTicket, 'requestComments' => $requestComments, 'requestReports' => $requestReports, 'nbComments' => $nbComments));
        }
        
        // Méthode appelée lors de la mise à jour d'un billet (ADMIN)
        public function updateTicket() {
            $this->ticketsManager->update(($_SESSION['id_ticket']), filter_input(INPUT_POST, 'text'));
            header('Location: billet_'.$_SESSION['id_ticket'].'.html');
        }
        
        // Méthode appelée lors de la suppression d'un billet (ADMIN)
        public function deleteTicket() {
            $this->ticketsManager->delete($_SESSION['id_ticket']);
            header('Location: listebillets.html');
        }  
    }