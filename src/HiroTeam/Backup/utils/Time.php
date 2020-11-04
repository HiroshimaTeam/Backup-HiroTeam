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

namespace HiroTeam\Backup\utils;

class Time{
    /**
     * @var int
     */
    private $time;

    /**
     * Time constructor.
     * @param int $time
     */
    public function __construct(int $time)
    {
        $this->time = $time;
    }

    /**
     * @return array
     */
    public function convertSecondMinute(): array{
        $second = $this->time % 60;
        $minute = ($this->time - $second) / 60;
        return [$second, $minute];
    }
}