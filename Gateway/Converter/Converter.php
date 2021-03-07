<?php

namespace Jnga\Authorizenet\Gateway\Converter;

use Magento\Payment\Gateway\Http\ConverterInterface;

class Converter
{


    /** @var ConverterInterface $converter */
    private $converter;

    /**  
     * @param ConverterInterface $converter
     */
    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }


    /**     
     * @param array $request
     * @return array|string
     */
    public function convert(array $request)
    {
        return $this->converter->convert($request);
    }
}
