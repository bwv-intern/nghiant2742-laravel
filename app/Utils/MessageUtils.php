<?php

namespace App\Utils;

use Symfony\Component\Yaml\Yaml;

class MessageUtils
{
    /**
     * Get message from YAML file based on error code.
     *
     * @param string $errorCode
     * @return string|null
     */
    public static function getMessage($errorCode)
    {
        $yamlPath = file_get_contents(config_path('constants/messages.yml'));
        $yamlContents = Yaml::parse($yamlPath);
        
        // Check if the error code exists in YAML contents
        if (isset($yamlContents['errors'][$errorCode])) {
            return $yamlContents['errors'][$errorCode];
        }
        
        return null; // Return null if error code not found
    }
}
