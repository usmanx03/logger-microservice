<?php

declare(strict_types=1);

namespace App\Helpers;

class Config
{
    /** @var array<string, array> */
    private static array $configs = [];

    /**
     * Get a config value using dot notation.
     * First part is treated as the config file name under config/.
     *
     * Example: Config::get('handlers.file.production.path');
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null)
    {
        $parts = explode('.', $key);

        if (empty($parts)) {
            return $default;
        }

        $fileKey = array_shift($parts);

        if (!isset(self::$configs[$fileKey])) {
            $filePath = CONFIG_PATH . "/$fileKey" . '.php';
            if (!file_exists($filePath)) {
                self::$configs[$fileKey] = [];
            } else {
                self::$configs[$fileKey] = require $filePath;
            }
        }

        // Now resolve the remaining parts in the cached array
        $value = self::$configs[$fileKey];
        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) {
                return $default;
            }
            $value = $value[$part];
        }

        return $value;
    }
}