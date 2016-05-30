<?php
#  ____  _                                    _    
# |  _ \| |_   _  __ _ _____      _____  _ __| | __
# | |_) | | | | |/ _` / __\ \ /\ / / _ \| '__| |/ /
# |  __/| | |_| | (_| \__ \\ V  V / (_) | |  |   < 
# |_|   |_|\__,_|\__, |___/ \_/\_/ \___/|_|  |_|\_\
#                |___/
# @copyright (c) 2016 All rights reserved, Plugswork
# @author    Plugswork Codx
# @website   https://plugswork.com/

namespace Plugswork\Utils;

use pocketmine\utils\Config;

class PwLang{
    
    private static $messages;
    private static $cMessages;
    
    public function __construct($plugin, $lang){
        $plugin->saveResource("lang-".$lang.".yml");
        self::$cMessages = new Config($plugin->getDataFolder()."lang-".$lang.".yml", Config::YAML);
    }
    
    public function loadUserMessages($rawMessages){
        $messages = json_decode($rawMessages, true);
        foreach($messages as $key => $message){
            $keys = explode("-", $key);
            self::$messages[$keys[0]][$keys[1]] = $message;
        }
    }
    
    public static function translate($key){
        $keys = explode(".", $key);
        if(empty($msg = self::$messages[$keys[0]][$keys[1]])){
            return $key;
        }else{
            return $msg;
        }
    }
    
    public static function cTranslate($key){
        if(empty($msg = self::$cMessages->getNested($key))){
            return $key;
        }else{
            return $msg;
        }
    }
    
    public static function translateColor($msg){
        return preg_replace_callback(
            "/(\\\&|\&)[0-9a-fk-or]/",
            function($matches){
                return str_replace("§r", "§r§f", str_replace("\\§", "&", str_replace("&", "§", $matches[0])));
            },
            $msg
        );
    }
}