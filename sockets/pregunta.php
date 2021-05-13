<?php       
    class Pregunta
    {
		public $pregunta;
		public $respostes = array();
		private $correcte;
		private $dificultat;
		private $categoria;

		function __construct() 
        {
            $this->dificultat = "medium";
        }

        public function getPregunta($categoria)
        {
        	$catNumber = 0;
        	switch ($categoria) 
        	{
        		case 'Entreteniment':
        			$catNumber = rand(11,14);
        			break;
    			case 'Ciencia':
	    			$catNumber = rand(17,19);
	    			break;
    			case 'Esports':
	    			$catNumber = 21;
	    			break;
    			case 'Geografia':
	    			$catNumber = 22;
	    			break;
    			case 'Historia':
	    			$catNumber = 23;
	    			break;
    			case 'Art':
	    			$catNumber = 25;
	    			break;
        	}
        	$json = file_get_contents("https://opentdb.com/api.php?amount=1&category=" .$catNumber. "&difficulty=" .$this->dificultat. "&type=multiple");
        	$obj = json_decode($json);
        	if ($obj->{'response_code'}==0) 
        	{
	        	$this->pregunta = $obj->results[0]->question;
				$this->correcte = $obj->results[0]->correct_answer;
				$this->respostes = $obj->results[0]->incorrect_answers;
				$this->respostes[] = $this->correcte;
				shuffle($this->respostes);
				var_dump($this->correcte);
				return $this;
			}        	
        	return -1;
        }

        public function PreguntaCorrecte($resposta)
        {
        	if ($resposta==$this->correcte) 
        	{
        		return true;
        	}
        	else
        	{
        		return false;
        	}
        }
    }    
?>