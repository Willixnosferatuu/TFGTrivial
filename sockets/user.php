<?php

class User 
{
  private $id;
  private $socketId;
  private $position;
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

  public function addPoints()
  {
    $this->points = $this->points + 10;
    var_dump($this->points);
    return $this->points;
  }

  public function getPoints()
  {
    return $this->points;
  }
}
?>