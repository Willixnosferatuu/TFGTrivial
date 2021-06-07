<?php
require_once('../html/model/model.php');

class User 
{
  private $id;
  private $socketId;
  private $points;

  function __construct($id, $socketId) 
  {
    $this->id = $id;
    $this->socketId = $socketId;
    $this->points = 0;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getSocketId()
  {
    return $this->socketId;
  }

  public function addPoints($idGame)
  {
    $this->points = $this->points + 100;
    addPointsUserBD($idGame, $this->id, 100);
    return $this->points;
  }

  public function getPoints()
  {
    return $this->points;
  }
}
?>