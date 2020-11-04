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

class MessageManager{

    /**
     * @param string $message
     * @param int $startTime
     * @param int $endTime
     * @return string
     */
    public static function getEndBackUpMessage(string $message, int $startTime, int $endTime): string{
        $time = new Time($endTime - $startTime);
        $time = $time->convertSecondMinute();
        $message = str_replace("{minute}", $time[1], $message);
        $message = str_replace("{second}", $time[0], $message);
        return $message;

    }

    /**
     * @param string $message
     * @param int $second
     * @return string|string[]
     */
    public static function getTimerMessage(string $message,int $second){
        $message = str_replace("{second}", $second, $message);
        return $message;
    }
}