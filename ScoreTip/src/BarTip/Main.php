<?php

namespace ScoreTip;

use ScoreTip\Tasks\PanelTask;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

 	
 
 	public function onEnable() {
 		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
	$this->EconomyAPI = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");

	$this->FactionsPro = $this->getServer()->getPluginManager()->getPlugin('FactionsPro');
			
   $this->PurePerms = $this->getServer()->getPluginManager()->getPlugin('PurePerms');
   
   $this->KillChat = $this->getServer()->getPluginManager()->getPlugin('KillChat');

      $this->getServer()->getScheduler()->scheduleRepeatingTask(new PanelTask($this), 10);
		$this->getLogger()->info("§aScoreTip by PluginBOXone - switched on");
      @mkdir($this->getDataFolder());
      $this->config = new Config ($this->getDataFolder() . "config.yml" , Config::YAML, array("name" => "§aPluginBOXone§r"));
       $this->saveResource("config.yml");
 	}
 	
 
 
 
	public function onPanel() {		
		$load = $this->getServer()->getTickUsage();
		$tps = $this->getServer()->getTicksPerSecond();
		$plon = count($this->getServer()->getOnlinePlayers());
		$mxon = $this->getServer()->getMaxPlayers();
	   $a = 0;
		foreach($this->getServer()->getOnlinePlayers() as $p) {
		
		$name = $p->getName();
	  
      if ($this->PurePerms)
					$ppg = $a = $this->PurePerms->getUserDataMgr()->getData($p)['group'];
    	 	else
					$ppg = '§cNo Plugin';
				
	   if ($this->FactionsPro) {
					$fact = $this->FactionsPro->getPlayerFaction($name);
					
	 	} else $fact = '§cNo Plugin';
				
      if ($this->KillChat) {
					$kll = $this->KillChat->getKills($name);
					$dth = $this->KillChat->getDeaths($name);
				} else {
					$kll = $dth =  '§cNo Plugin';
				}

	   if ($this->EconomyAPI)
		           $cash = $this->EconomyAPI->myMoney($name);
		  else
					  $cash = '§cNo Plugin';
				
				



				$t = str_repeat(" ", 85);
           $p->sendTip($t. "§l§8[".$this->config->get("name")."§8]§r\n" .$t. "§l§a»§eHello, §c".$name."§r\n" .$t. "§l§a»§ePrivilege§b: §b".$ppg."§r\n" .$t. "§l§a»§eOnline§b: §a". $plon."§8/§c".$mxon."§r\n" .$t. "§l§a»§eCoins§b: §6".$cash."$ §r\n" .$t. "§l§a»§eClan§b: §f". $fact ."§r\n".$t."§l§a»§eKills§b: §c".$kll."§r\n".$t."§l§a»§eDeaths§b: §c".$dth."§r".str_repeat("\n", 20));
			
				
				
			}
		}
 
 
 
	
       
			  

	/*public function onDisable() {
		$this->getLogger()->info("§4ScoreTip by PluginBOXone - switched off"
);
	}*/
}
