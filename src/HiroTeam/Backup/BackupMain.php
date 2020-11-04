<?php

#Backup plugin by HiroTeam | Plugin Backup par la HiroTeam
#██╗░░██╗██╗██████╗░░█████╗░████████╗███████╗░█████╗░███╗░░░███╗
#██║░░██║██║██╔══██╗██╔══██╗╚══██╔══╝██╔════╝██╔══██╗████╗░████║
#███████║██║██████╔╝██║░░██║░░░██║░░░█████╗░░███████║██╔████╔██║
#██╔══██║██║██╔══██╗██║░░██║░░░██║░░░██╔══╝░░██╔══██║██║╚██╔╝██║
#██║░░██║██║██║░░██║╚█████╔╝░░░██║░░░███████╗██║░░██║██║░╚═╝░██║
#╚═╝░░╚═╝╚═╝╚═╝░░╚═╝░╚════╝░░░░╚═╝░░░╚══════╝╚═╝░░╚═╝╚═╝░░░░░╚═╝
#description:
#ENG: This plugin allows to make a backup in plugin_data / Backup-HiroTeam by compressing it in tar.gz
#FRA: Plugin qui permet de compresser en tar.gz son serveur en entier dans plugin_data/Backup-HiroTeam

namespace HiroTeam\Backup;

use HiroTeam\Backup\task\BackupTimerTask;
use HiroTeam\Backup\utils\MessageManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;


class BackupMain extends PluginBase{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var int | null
     */
    public $launchBackup;

    public function onEnable()
    {
        $this->createConfig();
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        $commandName = strtolower($command->getName());
        switch ($commandName){
            case "backup":
                $this->launchBackup = 10;
                $this->getScheduler()->scheduleRepeatingTask(new BackupTimerTask($this), 20);
                break;
        }
        return true;
    }

    public function backupTimer(): void{
        if(isset($this->launchBackup)){
            if($this->launchBackup <= 0){
                Server::getInstance()->broadcastMessage($this->config->get("startBackup"));
                $time = time();
                exec("cd " . $this->getDataFolder() . "; tar -czf " . $this->getFileName() . " --exclude \"*.gz\" " . $this->getServerDirectory());
                Server::getInstance()->broadcastMessage(MessageManager::getEndBackUpMessage($this->config->get("endBackup"), $time, time()));
                unset($this->launchBackup);
                return;
            }
            if(in_array($this->launchBackup, [10, 5, 3, 2, 1])){
                Server::getInstance()->broadcastMessage(MessageManager::getTimerMessage($this->config->get("timerBackup"), $this->launchBackup));
            }
            $this->launchBackup = $this->launchBackup - 1;
        }
    }
    /**
     * @return string
     */
    private function getServerDirectory(): string{
        $file = $this->getDataFolder();
        $file = explode("/", $file);
        $directory = count($file) - 4;
        $allfile = [];
        for($i = 0; $i <= $directory; $i++){
            array_push($allfile, $file[$i]);
        }
        return implode("/", $allfile);
    }

    /**
     * @return string
     */
    private function getFileName(): string{
        $name = date("d-m-Y") . ".tar.gz";
        if(!file_exists($this->getDataFolder() . $name)){
            return $name;
        } else{
            $i = 1;
            $name = date("d-m-Y") . "_" . $i . ".tar.gz";
            while($i !== -1){
                if(!file_exists($this->getDataFolder() . $name)){
                    return $name;
                }
                $i = $i +1;
            }
        }
        return "ERROR";
    }

    private function createConfig(): void{
        if (!file_exists($this->getDataFolder() . "config.yml")) {
            $this->saveResource("config.yml");
        }
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }
}