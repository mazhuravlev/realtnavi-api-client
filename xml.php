<?php

/**
 * Скрипт получает данные по нескольким категориям за последние сутки
 * и выводит их в виде XML непосредственно в браузер
 */

use Velbis\Realtnavi\API;
use Velbis\Realtnavi\Helpers;
use Velbis\Realtnavi\Offer;

require_once "config/autoload.php";
require_once "config/config.php";

$api = API::connect(API_USERNAME, API_PASSWORD, API_URL);
$xml = $api->getXML(
    array(
        API::PARAM_AREA => 'Симферополь',
        API::PARAM_TIME => time() - 86400,
        API::PARAM_CATEGORIES => Helpers::prepareArray(
            [
                Offer::CAT_FLAT_SALE,
                Offer::CAT_ROOM_SALE,
                Offer::CAT_HOUSE_SALE
            ]
        )
    )
);
header('Content-Type: application/xml');
echo $xml;