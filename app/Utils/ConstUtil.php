<?php

namespace App\Utils;

use Symfony\Component\Yaml\Yaml;

class ConstUtil
{
    /**
     * Get role value from YAML file based on role code.
     *
     * @param number $flg
     * @return string|null
     */
    public static function getUserFlag($flg)
    {
        // Read the content from the YAML file
        $yamlPath = file_get_contents(config_path('constants/users.yml'));
        $yamlContents = Yaml::parse($yamlPath);
        
        // Check if the role code exists in the YAML content
        if (isset($yamlContents['user_flg'][$flg])) {
            // Get the role value from YAML
            $user_flg = $yamlContents['user_flg'][$flg];
            
            return $user_flg;
        }
        
        return null; // Return null if the role code is not found
    }
}
