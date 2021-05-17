<?php       
    require_once('TornManager.php');
    require_once('pregunta.php');

    class Partida
    {
        private $partidaUsers = array();
        private $id;
        private $maxPlayers = 3;
        private $state = "";
        public $tornManager;
        public $preguntes;

        function __construct($user, $idPartida) 
        {
            $this->id = $idPartida;
            $this->addUser($user);
            $this->state = "Created";  
            $this->tornManager = new TornManager();
            $this->preguntes = array();
        }

        public function addUser($user)
        {
            $this->partidaUsers[$user->getId()] = $user;           
        }

        public function hasFreeSlot()
        {
            if (count($this->partidaUsers)<$this->maxPlayers)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getUsers()
        {
            return $this->partidaUsers;
        }

        public function getUsersSockets()
        {
            $res = array();
            foreach ($this->partidaUsers as $u) 
            {
                $res[] = $u->getSocketId();
            }
            return $res;
        }

        public function getUsersAndPoints()
        {
            $res = array();
            foreach ($this->partidaUsers as $u) 
            {
                $res[$u->getId()] = $u->getPoints();
            }
            return $res;
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

        public function corregirPregunta($resposta, $user)
        {
            $pregunta = array_pop($this->preguntes);
            $correcte = $pregunta->PreguntaCorrecte($resposta);
            if ($correcte) 
            {
                $this->partidaUsers[$user]->addPoints();
            }
            return $correcte;
        }
        
        public function nextTorn()
        {
            $nextPlayer = $this->tornManager->Next();
            return $nextPlayer;
        }
    }    
?>