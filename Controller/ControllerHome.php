<?php
    include_once 'Model/TicketsManager.php';
    include_once 'View/View.php';
    
    class ControllerHome {
        private $ticketsManager;
        
        public function __construct() {
            $this->ticketsManager = new TicketsManager();
        }
        
        public function home() {
            // Variables nécessaires à la pagination de la liste des billets
            $requestNbTickets = $this->ticketsManager->count();
            $nbTickets = $requestNbTickets->fetch();
            $_SESSION['nbPageTicket'] = ceil($nbTickets[0] / 5);

            // Si la page demandée est possible, on affiche son contenu
            if(filter_input(INPUT_GET, 'page')&&(filter_input(INPUT_GET, 'page') > 0)&&(filter_input(INPUT_GET, 'page') <= $_SESSION['nbPageTicket'])) {
                $request = $this->ticketsManager->readAll(filter_input(INPUT_GET, 'page'));
            }
            else {
                // Sinon on affiche le contenu de la première
                $request = $this->ticketsManager->readAll(1);
            }

            // Méthode permettant de n'avoir qu'un résumé des billets
            function resume($string) {
                if(strlen($string) >= 200) {
                    $string = substr($string, 0, 200);
                    $space = strrpos($string, ' ');
                    return $string = substr($string, 0, $space)."...";
                }
                else {
                    return $string;
                }
            }
            $viewTicketsList = new View('TicketsList');
            $viewTicketsList->generate(array('request' => $request));
        }
    }