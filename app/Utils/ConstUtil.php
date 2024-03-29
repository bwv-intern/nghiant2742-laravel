<?php

namespace App\Utils;

use Symfony\Component\Yaml\Yaml;

class ConstUtil
{
    /**
     * Get value from YAML file based on table name, field and key.
     *
     * @param string $table
     * @param string $field
     * @param string $key
     * @return string|null
     */
    public static function getContentYml($table, $field, $key)
    {
        // Read the content from the YAML file
        $yamlPath = file_get_contents(config_path('constants/'. $table .'yml'));
        $yamlContents = Yaml::parse($yamlPath);
        
        // Check if the field exists in the YAML content
        if (isset($yamlContents[$field][$key])) {
            // Get the value from YAML
            $value = $yamlContents[$field][$key];
            
            return $value;
        }
        
        return null; // Return null if the field is not found
    }
}
