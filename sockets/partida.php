<?php       
    require_once('TornManager.php');
    require_once('pregunta.php');

    class Partida
    {
        private $partidaUsers = array();
        private $id;
        private $maxPlayers = 2;
        private $state = "";
        public $tornManager;
        public $preguntes;

        function __construct($user, $idPartida) 
        {
            $this->id = $idPartida;
            $this->partidaUsers[] = $user;
            $this->state = "Created";  
            $this->tornManager = new TornManager();
            $this->preguntes = array();
        }

        public function addUser($user)
        {
            /*if (count($partidaUsers)<$maxPlayers) 
            {
                $this->partidaUsers[] = $user;
            }*/
            $this->partidaUsers[] = $user;
            if (empty($this->partidaUsers)) 
            {
                echo "USERS VACIO \n";
            }
            else
            {
                echo "Qty users: " .count($this->partidaUsers). "\n";
            }            
        }

        public function getUsers()
        {
            return $this->partidaUsers;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getMaxPlayers()
        {
            return $this->maxPlayers;
        }

        public function getState()
        {
            return $this->state;
        }

        private function setState($state)
        {
            $this->state = $state;
        }

        public function StartPartida()
        {
            $this->setState("Active");
        }

        public function TerminatePartida()
        {
            $this->setState("Finished");
        }

        public function addPregunta($cat)
        {
            $pregunta = new Pregunta();
            $res = $pregunta->getPregunta($cat);
            $this->preguntes[] = $pregunta;
            return $res;
        }

        public function corregirPregunta($resposta)
        {
            $pregunta = array_pop($this->preguntes);
            return $pregunta->PreguntaCorrecte($resposta);
        }
        
        public function nextTorn()
        {
            $nextPlayer = $this->tornManager->Next();
            return $nextPlayer;
        }
    }    
?>