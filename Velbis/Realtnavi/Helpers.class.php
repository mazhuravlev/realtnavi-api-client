<?php

namespace Velbis\Realtnavi;

class Helpers
{

    /**
     * �������������� ������ ��� �������� � �������� ���������
     * @param array $array
     * @return string
     */
    public static function prepareArray(array $array)
    {
        return implode(',', $array);
    }

}