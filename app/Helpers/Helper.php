<?php

use App\Models\MenuModel;

function getMenus()
{
    $menus = MenuModel::get();

    return $menus;
}

if (!function_exists('set_select')) {
    function set_select($field, $value = '', $default = FALSE)
    {
        if (($input = old($field)) === NULL) {
            return ($default === TRUE) ? ' selected="selected"' : '';
        }

        $value = (string) $value;
        if (is_array($input)) {
            // Note: in_array('', array(0)) returns TRUE, do not use it
            foreach ($input as &$v) {
                if ($value === $v) {
                    return ' selected="selected"';
                }
            }

            return '';
        }
        return ($input === $value) ? ' selected="selected"' : '';
    }
}

function MoneyValue($days, $type)
{
    $money = "";
    if ($type == 0) {
        $money = $days * 100000;
    } else {
        $money = $days * 50000;
    }

    return $money;
}

function BulkMoneyValue($total_item, $price_per_item)
{
    $money = $total_item * $price_per_item;

    return $money;
}
