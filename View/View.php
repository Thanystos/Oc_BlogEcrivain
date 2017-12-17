<?php
    class View {
        private $file;
        private $title;
        
        public function __construct($action) {
            $this->file = 'View/'.$action.'.php';
        }
        
        public function generate($data = null) {
            $content = $this->generateFile($this->file, $data);
            $view = $this->generateFile('View/Layout.php', array('titre' => $this->title, 'content' => $content));
            echo $view;
        }
        
        public function generateFile($file, $data = null) {
            if(file_exists($file)) {
                if($data) {
                    extract($data);
                }
                ob_start();
                include $file;
                return ob_get_clean();
            }
            else {
                throw new Exception("Fichier '$file' introuvable");
            }
        }
    }