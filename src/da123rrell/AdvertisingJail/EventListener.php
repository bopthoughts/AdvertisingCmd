<?php
namespace da123rrell\AdvertisingJail;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\ConsoleCommandSender;

class EventListener implements Listener{
    
    private $plugin;

    public function __construct(AdvertisingJail $plugin){
            $this->plugin = $plugin;
    }
    
    private $webEndings = array(".net",".com",".co",".org",".info",".tk"); 
        
    /**
    * @param PlayerChatEvent $event
    *
    * @priority       NORMAL
    * @ignoreCanceled false
    */
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
				$this->plugin->getServer()->dispatchCommand(new ConsoleCommandSender(), "jail $name 1 10 Advertising"); 
                echo "[AdBlock]: Jailed " . $playername . " For saying: ". $message . " ========================\n";
            }
        }
        //----------------------------
        foreach ($this->webEndings as $url) {
            if (strpos($message, $url) !== FALSE) 
            {
                $event->setCancelled(true);
				$this->plugin->getServer()->dispatchCommand(new ConsoleCommandSender(), "jail $name 1 10 Advertising");
                echo "[AdBlock]: Jailed " . $playername . " For advertising ";
            }
        }
        //----------------------------
        
    }
}