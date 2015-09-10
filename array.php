<?php

/**
 * Скрипт получает данные в виде массива:
 *  доступные регионы
 *  количество предлоджени
 *  информацию по предложениям
 */

use Velbis\Realtnavi\API;
use Velbis\Realtnavi\Helpers;
use Velbis\Realtnavi\Offer;

require_once "config/autoload.php";
require_once "config/config.php";

$api = API::connect(API_USERNAME, API_PASSWORD, API_URL);
$params = array(
    API::PARAM_AREA => 'Севастополь',
    API::PARAM_TIME => time() - 86400,
    API::PARAM_CATEGORIES => Helpers::prepareArray(
        [
            Offer::CAT_FLAT_SALE,
            Offer::CAT_ROOM_SALE,
            Offer::CAT_HOUSE_SALE
        ]
    )
);
$areas = implode(', ', $api->getInfo(API::INFO_AREAS));
$count = $api->getCount($params);
$array = $api->getArray($params);
echo "<p>Количество: $count</p><p>Доступные регионы: $areas</p><p>Данные предложений: </p><pre>";
var_dump($array);
