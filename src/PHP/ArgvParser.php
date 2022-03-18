<?php

namespace phlnx\PHP;

class ArgvParser
{
    const MAX_ARGV = 1000;

    /**
     * Parse arguments
     * 
     * @param array|string [$message] input arguments
     * @return array Configs Key/Value
     */
    public function parse($message = null)
    {
        if (is_string($message)) {
            $argv = explode(' ', $message);
        } else if (is_array($message)) {
            $argv = $message;
        } else {
            global $argv;
            if (isset($argv) && count($argv) > 1) {
                array_shift($argv);
            }
        }

        $switch = array();
        $param = array();
        $argCounter = 0;
        foreach ($argv as $arg) {
            if (++$argCounter > self::MAX_ARGV) {
                break;
            }
            if (substr($arg, 0, 2) == '--') {
                $eqPos = strpos($arg, '=');
                if ($eqPos === false) {
                    $key = substr($arg, 2);
                    $switch["$key"] = isset ($switch["$key"]) ? $switch["$key"] : true;
                } else {
                    $key = substr($arg, 2, $eqPos - 2);
                    $switch["$key"] = substr($arg, $eqPos + 1);
                }
            } else {
                if (substr($arg, 0, 1) == '-') {
                    if (substr($arg, 2, 1) == '=') {
                        $key = substr($arg, 1, 1);
                        $switch["$key"] = substr($arg, 3);
                    } else {
                        $chars = str_split(substr($arg, 1));
                        foreach ($chars as $char) {
                            $key = $char;
                            $switch["$key"] = isset ($switch["$key"]) ? $switch["$key"] : true;
                        }
                    }
                } else {
                    $param[] = "$arg";
                }
            }
        }
        return array('switch' => $switch, 'param' => $param);
    }
}
