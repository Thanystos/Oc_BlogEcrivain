<?php
    include 'ControllerInOut.php';
    include 'ControllerHome.php';
    include 'ControllerTicket.php';
    include 'ControllerComment.php';
    include 'ControllerUser.php';
    include 'ControllerReport.php';
    include 'ControllerProfile.php';
    include_once 'View/View.php';
    
    class Router {
        private $ctrlInOut;
        private $ctrlHome;
        private $ctrlTicket;
        private $ctrlComment;
        private $ctrlUser;
        private $ctrlReport;
        private $ctrlProfile;
        
        public function __construct() {
            $this->ctrlInOut = new ControllerInOut();
            $this->ctrlHome = new ControllerHome();
            $this->ctrlTicket = new ControllerTicket();
            $this->ctrlComment = new ControllerComment();
            $this->ctrlUser = new ControllerUser();
            $this->ctrlReport = new ControllerReport();
            $this->ctrlProfile = new ControllerProfile();
        }
        
        public function authorized() {
            if($_SESSION['role']!= 2) {
                header('Location: listebillets.html');
                return false;
            }
            return true;
        }
        
        public function routerRequest() {
            switch(filter_input(INPUT_GET, 'action')) {
                case 'signUpView':
                    $this->ctrlInOut->signUpView();
                    break;
                case 'signInView':
                    $this->ctrlInOut->signInView();
                    break;
                case 'signUp':
                    $this->ctrlInOut->signUp();
                    break;
                case 'signIn':
                    $this->ctrlInOut->signIn();
                    break;
                case 'signOut':
                    $this->ctrlInOut->signOut();
                    break;
                case 'ticketsList':
                    $this->ctrlHome->home();
                    break;
                case 'addTicketView':
                    if($this->authorized()) {
                        $this->ctrlTicket->addTicketView();
                    }
                    break;
                case 'addTicket':
                    $this->ctrlTicket->addTicket();
                    break;
                case 'singleTicket':
                    $this->ctrlTicket->singleTicket();
                    break;
                case 'updateTicket':
                    $this->ctrlTicket->updateTicket();
                    break;
                case 'deleteTicket':
                    if($this->authorized()) {
                        $this->ctrlTicket->deleteTicket();
                    }
                    break;
                case 'addComment':
                    $this->ctrlComment->addComment();
                    break;
                case 'updateComment':
                    $this->ctrlComment->updateComment();
                    break;
                case 'deleteComment':
                    $this->ctrlComment->deleteComment();
                    break;
                case 'usersList':
                    if($this->authorized()) {
                        $this->ctrlUser->usersList();
                    }
                    break;
                case 'updatePassword':
                    $this->ctrlUser->updatePassword();
                    break;
                case 'updateEmail':
                    $this->ctrlUser->updateEmail();
                    break;
                case 'updateImage':
                    $this->ctrlUser->updateImage();
                    break;
                case 'updateStatus':
                    if($this->authorized()) {
                        $this->ctrlUser->updateStatus();
                    }
                    break;
                case 'deleteUser':
                    if($this->authorized()) {
                        $this->ctrlUser->deleteUser();
                    }
                    break;
                case 'report':
                    $this->ctrlReport->createReport();
                    break;
                case 'reportsList':
                    if($this->authorized()) {
                        $this->ctrlReport->reportsList();
                    }
                    break;
                case 'profilePage':
                    $this->ctrlProfile->profilePage();
                    break;
                default:
                    $this->ctrlHome->home();
            }
        }
    }