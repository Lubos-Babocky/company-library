<?php

namespace Lb\CompanyLibrary\Utility;

/**
 * Description of GeneralUtility
 * Contains useful functions, e.g static method <b>GetMultiArrayValue</b> which searches for value in multidimensional array
 *
 * @author Lubos Babocky <babocky@gmail.com>
 */
class GeneralUtility {

    /**
     * Searches for value in multidimensional array
     * @param mixed $inputArray multidimensional array
     * @param string $path comma separated list of inherited array keys, example: 'user.address.zip' is equivalent of $array['user']['address']['zip']
     * @param mixed $defaultValue returned when specified array path in $keys doesn't exist or is empty
     * @return mixed
     * @todo add support for iterable arrays or search in arrays, something similar to xpath for XML
     */
    public static function GetMultiArrayValue(mixed $inputArray, string $path = '', mixed $defaultValue = ''): mixed {
        if (!is_array($inputArray)) {
            return $defaultValue;
        }
        $separatedKeys = explode('.', $path);
        $currentKey = array_shift($separatedKeys);
        if (empty($separatedKeys) && array_key_exists($currentKey, $inputArray)) {
            return $inputArray[$currentKey];
        } elseif (!empty($separatedKeys) && array_key_exists($currentKey, $inputArray)) {
            return self::GetMultiArrayValue($inputArray[$currentKey], implode('.', $separatedKeys));
        } else {
            return $defaultValue;
        }
    }
}
