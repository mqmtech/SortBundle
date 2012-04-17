<?php

namespace MQM\Bundle\SortBundle\Sort;

class WebSortHelper
{
    const ASC = 'ASC';
    const ASC_SYMBOL = '+';
    const DESC = 'DESC';
    const DESC_SYMBOL = '-';

    public static function getModeFromRequestParam($str)
    {
        if ($str == null) {
            return null;
        }
        $mode = substr($str, 0, 1);
        if ($mode == self::DESC_SYMBOL) {
            return self::DESC;
        }
        else
            return self::ASC;
    }

    public static function getIdFromRequestParam($str)
    {
        if ($str == null) {
            return null;
        }
        $mode = substr($str, 0, 1);
        if ($mode == self::DESC_SYMBOL || $mode == self::ASC_SYMBOL) {
            $length = strlen($str);
            return substr($str, 1, $length - 1);
        }
        
        return $str;
    }

    public static function generateRequestParam($mode, $id)
    {
        $modeid = '';
        if ($mode != null) {
            if ($mode == self::DESC) {
                $modeid = self::DESC_SYMBOL;
            }
        }
        if ($id != null) {
            $modeid .= $id;
        }
        
        return $modeid;
    }
}
