<?php

class AttributePrune
{
    public static function execute($attributes, $configuration)
    {        
        $atts = $configuration['attributes_to_prune'];
       
        foreach ($attributes as $ka => $va)
        {
            foreach ($atts as $vm)
            {
                if($ka == $vm)
                {                                        
                    unset($attributes[$ka]);
                }
            }
        } 
        return $attributes;

    }
}
