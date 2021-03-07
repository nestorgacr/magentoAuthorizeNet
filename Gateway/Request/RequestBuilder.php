<?php

namespace Jnga\Authorizenet\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Jnga\Authorizenet\Gateway\Config;

class RequestBuilder implements BuilderInterface
{

    private $builderComposite;

    /** @var Config */
    private $config;

    /**
     * BuilderInterface  Constructor
     * @param BuilderInterface $builder
     */
    public function __construct(BuilderInterface $builder, Config $config)
    {
        $this->builderComposite = $builder;
        $this->config = $config;
    }

    /**
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject)
    {
        return [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name' => $this->config->getApiLoginId(),
                    'transactionKey' => $this->config->getTransactionKey()
                ],
                'transactionRequest' => $this->builderComposite->build($buildSubject)
            ]
        ];
    }
}
