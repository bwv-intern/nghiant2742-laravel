<?php

namespace App\Utils;

use Symfony\Component\Yaml\Yaml;

class MessageUtil
{
    /**
     * Get message from YAML file based on error code.
     *
     * @param string $errorCode
     * @return string|null
     */
    public static function getMessage($errorCode, $params = [])
    {
        // Đọc nội dung từ file YAML
        $yamlPath = file_get_contents(config_path('constants/messages.yml'));
        $yamlContents = Yaml::parse($yamlPath);
        
        // Kiểm tra xem mã lỗi có tồn tại trong nội dung YAML không
        if (isset($yamlContents['errors'][$errorCode])) {
            // Lấy thông báo từ YAML
            $message = $yamlContents['errors'][$errorCode];
            
            // Thay thế các tham số trong thông báo
            foreach ($params as $index => $param) {
                $message = str_replace("{{$index}}", $param, $message);
            }
            
            return $message;
        }
        
        return null; // Trả về null nếu mã lỗi không được tìm thấy
    }
}
