<?php
namespace Ad5001\EasierTime;
use pocketmine\command\CommandSender;
use Ad5001\EasierTime\ReloadConfigTask;
use Ad5001\EasierTime\StaticTask;
use Ad5001\EasierTime\TimeSpeed;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\plugin\PluginBase;
use pocketmine\level\Level;

class Main extends PluginBase{
  public function onEnable(){
    $this->saveDefaultConfig();
    // $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  public function onLoad(){
    $this->saveDefaultConfig();
    $this->reloadConfig();
  }
  public function onDisable() {
	  $this->getConfig()->set("isOnline", false);
	  $this->getConfig()->set("isTimeSTatic", false);
  }
  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
    switch(strtolower($cmd->getName())){
		case "night":
		$sender->getLevel()->setTime(20000);
		$sender->sendMessage("[EasierTime] ".$this->getConfig()->get("TimeNightMSG"));
		return true;
		break;
		case "day":
		$sender->getLevel()->setTime(0);
		$sender->sendMessage("[EasierTime] " . $this->getConfig()->get("TimeDayMSG"));
		return true;
		break;
		case "etload":
	  $this->getServer()->getScheduler()->scheduleRepeatingTask(new ReloadConfigTask($this, $sender), 5);
	  $this->getServer()->getScheduler()->scheduleRepeatingTask(new TimeSpeed($this, $sender), 2);
	  $sender->sendMessage("[EasierTime] Loaded");
	  return true;
	  break;
	  case "speedtime":
	  if(empty($args)) {
		  return false;
	  } elseif(!is_numeric($args[0])) {
		  $sender->sendMessage("[EasierTime] Multiplicator must be numeric");
	  } else {
		  $this->getConfig()->set("TimeSpeed", $args[0]);
		  $this->getConfig()->save();
		  $sender->sendMessage("[EasierTime] Done! Time speed has been set to " . $this->getConfig()->get("TimeSpeed") . " Now just reload your server and do /etload to apply changes! DOn't want to reload the server, just change the config");
	  }
	  return true;
	  break;
		case "stoptime":
		    if(!isset($args[0])) {
				return false;
			} else {
				if($this->getConfig()->get("isTimeStatic") ) {
					$this->getServer()->getScheduler()->scheduleRepeatingTask(new StaticTask($this, $sender), 5);
					$this->getConfig()->set("isTimeStatic", true);
				}
				switch(strtolower($args[0])) {
					case "day":
					$this->getConfig()->set("StaticTime", "day");
					 $this->getConfig()->save();
					$sender->sendMessage("[EasierTime] StaticTime is now day!");
					return true;
		            break;
					case "night":
					$this->getConfig()->set("StaticTime", "night");
					 $this->getConfig()->save();
					$sender->sendMessage("[EasierTime] StaticTime is now night!");
					return true;
		            break;
					case "false":
					$this->getConfig()->set("StaticTime", "false");
					$this->getConfig()->set("isTimeStatic", "false");
					 $this->getConfig()->save();
					$sender->sendMessage("[EasierTime] StaticTime is now disable! reload your server to apply changes!");
					return true;
					break;
					default:
					return false;
					break;
				}
			}
			return true;
		    break;
    }
    return false;
  }
}
