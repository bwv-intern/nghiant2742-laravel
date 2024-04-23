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
     * @return array|string|null
     */
    public static function getContentYml($table, $field, $key = null)
    {
        // Read the content from the YAML file
        $yamlPath = file_get_contents(config_path('constants/'. $table .'.yml'));
        $yamlContents = Yaml::parse($yamlPath);
        
        // Check if the field exists in the YAML content
        if (isset($yamlContents[$field])) {
            // If $key is null, return the entire field
            if ($key === null) {
                return $yamlContents[$field];
            }
            // Get the value from YAML
            return $yamlContents[$field][$key];
        }
        
        return null; // Return null if the field is not found
    }

    /**
     * Get value from YAML file based on table name, field and key.
     *
     * @param string $table
     * @param string $field
     * @return number|null
     */
    public static function getLengthOfContentYml($table, $field)
    {
        // Read the content from the YAML file
        $yamlPath = file_get_contents(config_path('constants/'. $table .'.yml'));
        $yamlContents = Yaml::parse($yamlPath);
        
        // Check if the field exists in the YAML content
        if (isset($yamlContents[$field])) {
            // Get the value from YAML
            $value = count($yamlContents[$field]);
            return $value;
        }
        
        return null; // Return 0 if the field is not found
    }
}
