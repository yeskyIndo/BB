<?php

namespace yesky\BounceBlock;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\Position;

class Main extends PluginBase implements Listener{
  public function onEnable(){
    @mkdir($this->getServer()->getDataPath() . "/plugins/BounceBlock/");
    $this->bounceBlock = (new Config($this->getDataFolder()."config.yml", Config::YAML, array(
      "bounceblock" => 165,
      "nbounceblock" => 173,
      "ubounceblock" => 152,
      "sbounceblock" => 133,
      "wbounceblock" => 22,
      "ebounceblock" => 41
    )));
    $this->getLogger()->info("§aBounceBlock by is loaded.");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
	
  public function onDisable() 
	
  {		
		$this->getServer()->getLogger()->info("§cBounceBlock Desactivate");
  }
 	
  public function onPlayerMove(PlayerMoveEvent $event){
    $player = $event->getPlayer();
    $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
    $from = $event->getFrom();
    $to = $event->getTo();
    $x=$player->x;
    $y=$player->y;
    $z=$player->z;
    $bounceblock = $this->bounceBlock->get("bounceblock");
    $nbounceblock = $this->bounceBlock->get("nbounceblock");
    $ubounceblock = $this->bounceBlock->get("ubounceblock");
    $sbounceblock = $this->bounceBlock->get("sbounceblock");
    $wbounceblock = $this->bounceBlock->get("wbounceblock");
    $ebounceblock = $this->bounceBlock->get("ebounceblock");
    if($block->getId() === $bounceblock){
      if($player->getDirection() == 0){
        $player->knockBack($player, 0, 1, 0, 1);
      }
      elseif($player->getDirection() == 1){
        $player->knockBack($player, 0, 0, 1, 1);
      }
      elseif($player->getDirection() == 2){
        $player->knockBack($player, 0, -1, 0, 1);
      }
      elseif($player->getDirection() == 3){
        $player->knockBack($player, 0, 0, -1, 1);
      }    
    }
    elseif($block->getId() === $nbounceblock){
      $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($x, $y , $z)));
      $player->knockBack($player, 0, -1, 0, 1);       
    }
    elseif($block->getId() === $sbounceblock){
      $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($x, $y , $z)));
      $player->knockBack($player, 0, 1, 0, 1);
    }
    elseif($block->getId() === $wbounceblock){
      $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($x, $y , $z)));
      $player->knockBack($player, 0, 0, 1, 1);      
    }
    elseif($block->getId() === $ebouceblock){
      $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($x, $y , $z)));
      $player->knockBack($player, 0, 0, -1, 1);     
    }
    elseif($from->getLevel()->getBlockIdAt($from->x, $from->y - 1, $from->z) === $ubounceblock){
		$player->setMotion((new Vector3($to->x - $from->x, $to->y - $from->y, $to->z - $from->z))->multiply(5)); /* 5 is the power */
		$player->sendTip("§l§a << Turbooo >>");
		$player->getLevel()->addParticle(new ExplodeParticle(new Vector3($x, $y , $z)));
    } 	
  }
}
