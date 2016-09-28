<?php

namespace AppBundle\Util;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class Util
{
    /**
     * @param $params
     * @param $type
     * @param string $default
     * @return string
     */
    public static function getInfo($params, $type, $default = '')
    {
        if (!empty($params['info'])) {
            foreach ($params['info'] as $data) {
                if ($data['type'] == $type) {
                    return $data['value'];
                }
            }
        }
        return $default;
    }

    /**
     * @param int $codeLength
     * @return string
     */
    static public function alphaNumCodeGenerator($codeLength = 5)
    {
        $characters = 'ABCDEFGHIJKLLMNOPQRSTUVWXYZ0123456789';
        $length = strlen($characters) - 1;
        $uniqueId = '';
        for ($i = 0; $i < $codeLength; $i++) {
            $uniqueId .= $characters[rand(0, $length)];
        }
        return $uniqueId;
    }

    /**
     * @param $input
     * @return array
     */
    public static function arrayFilterRecursive($input)
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = self::arrayFilterRecursive($value);
            }
        }

        return array_filter($input, function($v) {
            return !is_null($v);
        });
    }

}
