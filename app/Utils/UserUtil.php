<?php

namespace App\Utils;

use Symfony\Component\Yaml\Yaml;

class UserUtil
{
    /**
     * Get message from YAML file based on error code.
     *
     * @param string $errorCode
     * @return string|null
     */
    public static function getUserFlag($flg)
    {
        // Read the content from the YAML file
        $yamlPath = file_get_contents(config_path('constants/users.yml'));
        $yamlContents = Yaml::parse($yamlPath);
        
        // Check if the error code exists in the YAML content
        if (isset($yamlContents['user_flg'][$flg])) {
            // Get the message from YAML
            $user_flg = $yamlContents['user_flg'][$flg];
            
            return $user_flg;
        }
        
        return null; // Return null if the error code is not found
    }
}
