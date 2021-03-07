<?php

namespace Jnga\Authorizenet\Gateway\Http;

use Jnga\Authorizenet\Gateway\Converter\Converter;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Jnga\Authorizenet\Gateway\Config;

class TransferFactory implements TransferFactoryInterface
{

    /**@var TransferBuilder */
    private $transferBuilder;

    /**@var Config */
    private $config;

    /**
     * @var Converter
     */
    private $converter;

    public function __construct(TransferBuilder $transferBuilder, Converter $converter, Config $config)
    {
        $this->transferBuilder = $transferBuilder;
        $this->converter = $converter;
        $this->config = $config;
    }

    /**
     * @param array $request
     * @return TransferInterface
     */
    public function create(array $request)
    {
        return $this->transferBuilder->setUri($this->config->getGatewayUrl())
            ->setMethod('POST')
            ->setBody($this->converter->convert($request))
            ->setHeaders($this->config->getGatewayHeaders())
            ->build();
    }
}
