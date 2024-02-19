<?php

namespace App;

class Helper
{
    public static function getCommandList($commands)
    {
        $list = [];

        foreach ($commands as $key => $category) {
            if (is_array($category)) {
                foreach ($category as $command => $description) {
                    $list[$command] = $description;
                }
            } else {
                $list[$key] = $category;
            }
        }

        return $list;
    }
}