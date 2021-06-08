<?php       
    require_once('TornManager.php');
    require_once('pregunta.php');
    require_once('../html/model/model.php');

    class Partida
    {
        private $partidaUsers = array();
        private $id;
        private $maxPlayers;
        private $maxRondas = 2;
        private $state = "";
        private $difficulty;
        private $privada;
        public $tornManager;
        public $preguntes;
        public $code = "";

        function __construct($user, $maxPlayers, $difficulty) 
        {
            $this->maxPlayers = $maxPlayers;
            $this->difficulty = $difficulty;
            $this->state = "created";//hi habia 1 bgada un tornmanager k tukaba molt els collons i un dia bach agafat una butlla de vichi ktalan i li bach rebemntart el cairo_pattern_create_radial(x0, y0, r0, x1, y1, r1)
            $this->preguntes = array();
            $res = createGame($this->maxPlayers, $this->difficulty);
            $this->code = $res[0];
            $this->id = $res[1];
            $this->tornManager = new TornManager($this->id, $this->maxRondas);
            $this->addUser($user);
            $this->privada = false;
            //$this->addUserPartidaBD($user->getId(), $this->id);
        }

        public function addUser($user)
        {
            $this->partidaUsers[$user->getId()] = $user;  
            $this->addUserPartidaBD($user->getId(), $this->id);         
        }

        public function hasFreeSlot()
        {
            //MODEL -> PARTIDA_hasFreeSlot()
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
            //MODEL -> PARTIDA_getUsers()
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
            $this->setStateBD($state);
        }

        public function StartPartida()
        {
            $this->setState("active");
        }

        public function TerminatePartida()
        {
            $this->setState("finished");
        }

        public function setPrivada()
        {
            $this->privada = true;
        }

        public function isPrivada()
        {
            return $this->privada;
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
                $this->partidaUsers[$user]->addPoints($this->id);
            }
            return $correcte;
        }
        
        public function nextTorn()
        {
            $nextPlayer = $this->tornManager->Next();
            return $nextPlayer;
        }

        private function updatePartidaBDstatus($idPartida, $status)
        {
            //TODO
            //update partida into BD
        }

        private function addUserPartidaBD($idUser, $idPartida)
        {
            //TODO
            insertUserGame($idUser, $idPartida);
            //insert user partida into BD
        }    

        private function setStateBD($state)
        {
            updateGameStatus($this->id, $state);
        }   
    }    
?>