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

namespace HiroTeam\Backup\task;

use HiroTeam\Backup\BackupMain;
use pocketmine\scheduler\Task;

class BackupTimerTask extends Task{

    private $main;

    public function __construct(BackupMain $main)
    {
        $this->main = $main;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick)
    {
        $this->main->backupTimer();
        if(!isset($this->main->launchBackup)){
            $this->getHandler()->cancel();
        }
    }
}