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

class ReloadConfigTask extends PluginTask  {
    private $player;
    private $plugin;
    public function __construct($plugin, $player){
        parent::__construct($plugin);
        $this->player = $player;
        $this->plugin = $plugin;
    }
     public function onRun($tick){
     	$this->plugin->reloadConfig();
     }
}
