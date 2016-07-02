<?php

namespace da123rrell\AdvertisingJail;

use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\Config;

class AdvertisingJail extends PluginBase implements Listener{

    private $webEndings = array(".net",".com",".co",".org",".info",".tk");

    public function onEnable(){
        $this->getLogger()->info("AdvertisingJail Starterd");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->config = new Config ($this->getDataFolder() . "config.yml" , Config::YAML, array(
        "command" =>
        ));
        $this->saveResource("config.yml");
    }

    public function onDisable(){
        $this->getLogger()->info("AdvertisingJail Stopped");
    }
    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $playername = $event->getPlayer()->getDisplayName();
        $name = $player->getName();
        //----------------------------
        $parts = explode('.', $message);
        if(sizeof($parts) >= 4)
        {
            if (preg_match('/[0-9]+/', $parts[1]))
            {
                $event->setCancelled(true);
                $this->plugin->getServer()->dispatchCommand(new ConsoleCommandSender(), $this->config->get("command"));
                echo "[AdBlock]: Punished " . $playername . " For saying: ". $message . " ========================\n";
            }
        }
        //----------------------------
        foreach ($this->webEndings as $url) {
            if (strpos($message, $url) !== FALSE)
            {
                $event->setCancelled(true);
                $this->plugin->getServer()->dispatchCommand(new ConsoleCommandSender(), $this->config->get("command"));
                echo "[AdBlock]: Punished " . $playername . " For advertising ";
            }
        }
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
                switch(strtolower($cmd->getName()){
            case "crtv":
                $sender->setGameMode(1);
                break;
            case "srvl":
                $sender->setGameMode(0);
                break;
        }
        return true;
    }
        
}
