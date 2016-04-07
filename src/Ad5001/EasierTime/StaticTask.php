<?php


namespace Ad5001\EasierTime;

use pocketmine\server;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\utils\TextFormat as C;
use pocketmine\plugin\PluginBase;

class StaticTask extends PluginTask  {
    private $player;
    private $plugin;
    public function __construct($plugin, $player){
        parent::__construct($plugin);
        $this->player = $player;
        $this->plugin = $plugin;
    }
     public function onRun($tick){
     	switch($this->plugin->getConfig()->get("StaticTime")) {
			case "day":
			$this->player->getLevel()->setTime(0);
			return true;
			break;
			case "night":
			$this->player->getLevel()->setTime(20000);
			return true;
			break;
			case "false":
			$this->plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
			return true;
			break;
		}
     }
}