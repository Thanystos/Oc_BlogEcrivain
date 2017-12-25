<?php
    include_once 'View/View.php';
    
    class Router {
        private $ctrlInOut;
        private $ctrlHome;
        private $ctrlTicket;
        private $ctrlComment;
        private $ctrlUser;
        private $ctrlReport;
        private $ctrlProfile;
        
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
                    include 'ControllerInOut.php';
                    $this->ctrlInOut = new ControllerInOut();
                    $this->ctrlInOut->signUpView();
                    break;
                case 'signInView':
                    include 'ControllerInOut.php';
                    $this->ctrlInOut = new ControllerInOut();
                    $this->ctrlInOut->signInView();
                    break;
                case 'signUp':
                    include 'ControllerInOut.php';
                    $this->ctrlInOut = new ControllerInOut();
                    $this->ctrlInOut->signUp();
                    break;
                case 'signIn':
                    include 'ControllerInOut.php';
                    $this->ctrlInOut = new ControllerInOut();
                    $this->ctrlInOut->signIn();
                    break;
                case 'signOut':
                    include 'ControllerInOut.php';
                    $this->ctrlInOut = new ControllerInOut();
                    $this->ctrlInOut->signOut();
                    break;
                case 'ticketsList':
                    include 'ControllerHome.php';
                    $this->ctrlHome = new ControllerHome();
                    $this->ctrlHome->home();
                    break;
                case 'addTicketView':
                    if($this->authorized()) {
                        include 'ControllerTicket.php';
                        $this->ctrlTicket = new ControllerTicket();
                        $this->ctrlTicket->addTicketView();
                    }
                    break;
                case 'addTicket':
                    include 'ControllerTicket.php';
                    $this->ctrlTicket = new ControllerTicket();
                    $this->ctrlTicket->addTicket();
                    break;
                case 'singleTicket':
                    include 'ControllerTicket.php';
                    $this->ctrlTicket = new ControllerTicket();
                    $this->ctrlTicket->singleTicket();
                    break;
                case 'updateTicket':
                    include 'ControllerTicket.php';
                    $this->ctrlTicket = new ControllerTicket();
                    $this->ctrlTicket->updateTicket();
                    break;
                case 'deleteTicket':
                    if($this->authorized()) {
                        include 'ControllerTicket.php';
                        $this->ctrlTicket = new ControllerTicket();
                        $this->ctrlTicket->deleteTicket();
                    }
                    break;
                case 'addComment':
                    include 'ControllerComment.php';
                    $this->ctrlComment = new ControllerComment();
                    $this->ctrlComment->addComment();
                    break;
                case 'updateComment':
                    include 'ControllerComment.php';
                    $this->ctrlComment = new ControllerComment();
                    $this->ctrlComment->updateComment();
                    break;
                case 'deleteComment':
                    include 'ControllerComment.php';
                    $this->ctrlComment = new ControllerComment();
                    $this->ctrlComment->deleteComment();
                    break;
                case 'usersList':
                    if($this->authorized()) {
                        include 'ControllerUser.php';
                        $this->ctrlUser = new ControllerUser();
                        $this->ctrlUser->usersList();
                    }
                    break;
                case 'updatePassword':
                    include 'ControllerUser.php';
                    $this->ctrlUser = new ControllerUser();
                    $this->ctrlUser->updatePassword();
                    break;
                case 'updateEmail':
                    include 'ControllerUser.php';
                    $this->ctrlUser = new ControllerUser();
                    $this->ctrlUser->updateEmail();
                    break;
                case 'updateImage':
                    include 'ControllerUser.php';
                    $this->ctrlUser = new ControllerUser();
                    $this->ctrlUser->updateImage();
                    break;
                case 'updateStatus':
                    if($this->authorized()) {
                        include 'ControllerUser.php';
                        $this->ctrlUser = new ControllerUser();
                        $this->ctrlUser->updateStatus();
                    }
                    break;
                case 'deleteUser':
                    if($this->authorized()) {
                        include 'ControllerUser.php';
                        $this->ctrlUser = new ControllerUser();
                        $this->ctrlUser->deleteUser();
                    }
                    break;
                case 'report':
                    include 'ControllerReport.php';
                    $this->ctrlReport = new ControllerReport();
                    $this->ctrlReport->createReport();
                    break;
                case 'reportsList':
                    if($this->authorized()) {
                        include 'ControllerReport.php';
                        $this->ctrlReport = new ControllerReport();
                        $this->ctrlReport->reportsList();
                    }
                    break;
                case 'profilePage':
                    include 'ControllerProfile.php';
                    $this->ctrlProfile = new ControllerProfile();
                    $this->ctrlProfile->profilePage();
                    break;
                default:
                    include 'ControllerHome.php';
                    $this->ctrlHome = new ControllerHome();
                    $this->ctrlHome->home();
            }
        }
    }