<?php

namespace Jnga\Authorizenet\Gateway\Converter;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Payment\Gateway\Http\ConverterInterface;

class JsonToArray implements ConverterInterface
{
    /** @var SerializerInterface $serializer*/
    private $serializer;

    /**
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /** @inheritDoc */
    public function convert($response)
    {
        // Necesary this fix for Authorizet.NET response issue.
        $response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response);
        return $this->serializer->unserialize($response);
    }
}
