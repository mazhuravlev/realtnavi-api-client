<?php

namespace Velbis\Realtnavi;

class Helpers
{

    /**
     * Подготавливает массив для отправки в качестве параметра
     * @param array $array
     * @return string
     */
    public static function prepareArray(array $array)
    {
        return implode(',', $array);
    }

}