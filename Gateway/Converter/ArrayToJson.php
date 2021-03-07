<?php

namespace Jnga\Authorizenet\Gateway\Converter;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Payment\Gateway\Http\ConverterInterface;

class ArrayToJson implements ConverterInterface
{
    /** @var SerializerInterface $serializer */
    private $serializer;

    /**     
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /** @inheritDoc */
    public function convert($response)
    {
        return $this->serializer->serialize($response);
    }
}
