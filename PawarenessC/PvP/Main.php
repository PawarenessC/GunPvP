<?php

namespace PawarenessC\PvP;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

use pocketmine\math\Vector3;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockPlaceEvent;

use pocketmine\event\server\DataPacketReceiveEvent;

use pocketmine\level\particle\PortalParticle;

use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;

use metowa1227\moneysystem\api\core\API;

class Main extends pluginBase implements Listener{
	
	public $ct = [],$guns = [];
	
	const CANT_SHOT = 0;
	const SHOT_GUN = 1;
	
	public function onEnable(){
		$this->getLogger()->info("PvPを読み込みました");
		$this->getLogger()->info("v{$this->getDescription()->getVersion()}");
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$name = $event->getPlayer()->getName();
	}
	
	public function useItem(PlayerInteractEvent $event){
		$player = $event->getPlayer();
		$name = $player->getName();
		$item = $event->getItem();
		$id = $item->getId();
		$cname = $item->getCustomName();
		
		switch($cname){
			case "Pistol":
				if($this->canShot($player,"Pistol")){
					$this->guns[$name]["Pistol"]["Ammo"]--;
					$this->shot($player,"Pistol");
				}else{
					$this->sound($player,self::CANT_SHOT);
					return;
				}
			break;
			
			case "Rifle":
				if($this->canShot($player,"Rifle")){
					$this->guns[$name]["Rifle"]["Ammo"]--;
					$this->shot($player,"Rifle");
				}else{
					$this->sound($player,self::CANT_SHOT);
					return;
				}
			break;
				
			case "ShotGun":
				if($this->canShot($player,"ShotGun")){
					$this->guns[$name]["ShotGun"]["Ammo"]--;
					$this->shot($player,"ShotGun");
				}else{
					$this->sound($player,self::CANT_SHOT);
					return;
				}
			break;
				
			case "Sniper":
				if($this->canShot($player,"Sniper")){
					$this->guns[$name]["Sniper"]["Ammo"]--;
					$this->shot($player,"Sniper");
				}else{
					$this->sound($player,self::CANT_SHOT);
					return;
				}
			break;
				
			case "Ice":
				if($this->canShot($player,"Ice")){
					$this->shot($player,"Ice");
					$this->guns[$name]["Ice"]["bool"] = false;
				}else{
					$this->sound($player,self::CANT_SHOT);
				}
			break;
				
			case "Fire":
				if($this->canShot($player,"Fire")){
					$this->shot($player,"Fire");
					$this->guns[$name]["Fire"]["bool"] = false;
				}else{
					$this->sound($player,self::CANT_SHOT);
				}
			break;
		}
	}
