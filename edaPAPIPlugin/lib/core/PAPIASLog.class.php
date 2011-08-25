<?php

class PAPIASLog
{
    public static function error($msg)
    {
        PAPIASLog::doLog($msg);
        throw new Exception($msg);      
    }

    public static function doLog($msg)
    {        
        $log = sfConfig::get('app_eda_papi_plugin_as_log_file','/dev/null');
        $asId = sfConfig::get('app_eda_papi_plugin_as_id','example_AS');
        if ($log != "/dev/null")
        {
            $emsg = date("d-M-Y H:i:s") . ", " . $asId . ": " . $msg . "\n";
            error_log($emsg, 3, $log);
        }
    }
}

