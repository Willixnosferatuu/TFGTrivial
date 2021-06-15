<?php       
    require_once('TornManager.php');
    require_once('pregunta.php');
    require_once('user.php');
    require_once('../html/model/model.php');

    class Partida
    {
        private $partidaUsers = array();
        private $id;
        private $maxPlayers;
        private $maxRondas = 3;
        private $state = "";
        private $difficulty;
        private $privada;
        public $tornManager;
        public $preguntes;
        public $code = "";

        function __construct() 
        {
            
        }

        public function Create($user, $maxPlayers, $difficulty)
        {
            $this->maxPlayers = $maxPlayers;
            $this->difficulty = $difficulty;
            echo "DIFFICULTY ON CREATE GAME = " .$difficulty;
            $this->state = "created";//hi habia 1 bgada un tornmanager k tukaba molt els collons i un dia bach agafat una butlla de vichi ktalan i li bach rebemntart el cairo_pattern_create_radial(x0, y0, r0, x1, y1, r1)
            $this->preguntes = array();
            $res = createGame($this->maxPlayers, $this->difficulty, $this->maxRondas);
            $this->code = $res[0];
            $this->id = $res[1];
            $this->tornManager = new TornManager($this->id, $this->maxRondas);
            $this->addUser($user);
            $this->privada = false;
        }

        public function Retrieve($id)
        {
            $this->id = $id;
            $res = retrieveGame($id);
            $this->code = $res[0];
            $this->maxPlayers = $res[1];
            $this->difficulty = $res[2];
            $this->state = $res[3];
            $this->privada = $res[4];
            $this->maxRondas = $res[5];
            $this->tornManager = new TornManager($this->id, $this->maxRondas);
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
            if ($this->partidaUsers) 
            {
                $res = array();
                foreach ($this->partidaUsers as $u) 
                {
                    $res[$u->getUsername()] = $u->getPoints();
                }
                return $res;
            }
            else
            {
                return getUserPointsFromDB($this->id);
            }
            
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
            updateGameToPrivate($this->id);
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
                if ($this->partidaUsers[$user]!=null) 
                {
                    $this->partidaUsers[$user]->addPoints($this->id);
                }
                else
                {
                    $u = new User($user, 0);
                    $u->addPoints($this->id);
                }
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

        public function setMaxPlayers($maxPlayers)
        {
            $this->maxPlayers = $maxPlayers;
        }

        public function setMaxRondas($maxRondas)
        {
            $this->maxRondas = $maxRondas;
        }

        public function setDifficulty($difficulty)
        {
            $this->difficulty = $difficulty;
        }

        public function setTornManager()
        {
            $this->tornManager = new TornManager($this->id, $this->maxRondas);
        }  
    }    
?>