<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Serialize\Serializer;

use Magento\Framework\Serialize\SerializerInterface;

/**
 * Serialize data to JSON, unserialize JSON encoded data
 *
 * @api
 * @since 101.0.0
 */
class Json implements SerializerInterface
{
    /**
     * @inheritDoc
     * @since 101.0.0
     */
    public function serialize($data)
    {
        $result = json_encode($this->utf8ize($data));
        $result = json_encode($data);
        if (false === $result) {
            throw new \InvalidArgumentException("Unable to serialize value. Error: " . json_last_error_msg());
        }
        return $result;
    }
    public function utf8ize($mixed)
    {
        if (is_array($mixed))
        {
            foreach ($mixed as $key => $value)
            {
                $mixed[$key] = $this->utf8ize($value);
            }
        }
        elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        }
        return $mixed;
    }
    /**
     * @inheritDoc
     * @since 101.0.0
     */
    public function unserialize($string)
    {
        // if ($string === null) {
        //     throw new \InvalidArgumentException(
        //         'Unable to unserialize value. Error: Parameter must be a string type, null given.'
        //     );
        // }
        // $result = json_decode($string, true);

        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     throw new \InvalidArgumentException("Unable to unserialize value. Error: " . json_last_error_msg());
        // }
        // return $result;
        if($this->is_serialized($string))
        {
            $string = $this->serialize($string);
        }
        $result = json_decode($string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
             throw new \InvalidArgumentException('Unable to unserialize value.');
        }
        return $result;
    }
    function is_serialized($value, &$result = null)
{
    if (!is_string($value))
    {
        return false;
    }
    
    if ($value === 'b:0;')
    {
        $result = false;
        return true;
    }
    $length = strlen($value);
    $end    = '';
    switch ($value[0])
    {
        case 's':
            if ($value[$length - 2] !== '"')
            {
                return false;
            }
        case 'b':
        case 'i':
        case 'd':
            $end .= ';';
        case 'a':
        case 'O':
            $end .= '}';
            if ($value[1] !== ':')
            {
                return false;
            }
            switch ($value[2])
            {
                case 0:
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                    break;
                default:
                    return false;
            }
        case 'N':
            $end .= ';';
            if ($value[$length - 1] !== $end[0])
            {
                return false;
            }
            break;
        default:
            return false;
    }
    if (($result = @unserialize($value)) === false)
    {
        $result = null;
        return false;
    }
    return true;
}
}
