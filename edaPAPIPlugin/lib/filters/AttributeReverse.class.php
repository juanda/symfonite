<?php

class AttributeReverse
{

    public static function execute($attributes, $configuration)
    {

        foreach ($attributes as $ka => $va)
        {
            if (is_array($va))
            {
                foreach ($va as $k => $v)
                {
                    $attributes[$ka][$k] = strrev($attributes[$ka][$k]);
                }
            } else
            {
                $attributes[$ka] = strrev($attributes[$ka]);
            }
        }
        return $attributes;
    }

}
