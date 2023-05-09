<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\Framework\Serialize\Serializer;

use Magento\Framework\Serialize\SerializerInterface;

/**
 * Serialize data to JSON with the JSON_HEX_TAG option enabled
 * (All < and > are converted to \u003C and \u003E),
 * unserialize JSON encoded data
 *
 * @api
 * @since 102.0.1
 */
class JsonHexTag extends Json implements SerializerInterface
{
    /**
     * @inheritDoc
     * @since 102.0.1
     */
    public function serialize($data): string
    {
        $data = $this->utf8convert($data);
        $result = json_encode($data, JSON_HEX_TAG);
        if (false === $result) {
            throw new \InvalidArgumentException('Unable to serialize value.');
        }
        return $result;
    }
    public function utf8convert($mixed, $key = null)
    {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = $this->utf8convert($value, $key);
        }
    } elseif (is_string($mixed)) {
        $fixed = mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        return $fixed;
    }
    return $mixed;
}
}
