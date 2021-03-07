<?php

namespace Jnga\Authorizenet\Gateway;

use Magento\Framework\Exception\NotFoundException;
use Magento\Payment\Gateway\Config\ValueHandlerPoolInterface;

class Config
{
    /** @var ValueHandlerPoolInterface */
    private $valueHandlerPool;


    /**     
     *
     * @param ValueHandlerPoolInterface $valueHandlerPool
     */
    public function __construct(ValueHandlerPoolInterface $valueHandlerPool)
    {
        $this->valueHandlerPool = $valueHandlerPool;
    }

    /**     
     *
     * @return string
     */
    public function getGatewayUrl()
    {
        $url = "gateway_url";
        if ($this->isSandbox()) {
            $url .= "_sandbox";
        }
        return (string) $this->getValue($url);
    }

    /**     
     *
     * @return array
     */
    public function getGatewayHeaders()
    {
        return array('Content-Type' => 'application/json');
    }

    /**
     *
     * @return void
     */
    public function getApiLoginId()
    {
        return (string) $this->getValue('api_login_id');
    }

    /**     
     *
     * @return void
     */
    public function getTransactionKey()
    {
        return (string) $this->getValue('transaction_key');
    }

    /**     
     *
     * @return boolean
     */
    private function isSandBox()
    {
        return (bool) $this->getValue('is_sandbox');
    }

    /**     
     *
     * @param string $field
     * @return array|null
     */
    private function getValue($field)
    {
        try {
            $handler = $this->valueHandlerPool->get($field);
            return $handler->handle(array('field' => $field));
        } catch (NotFoundException $e) {
            return null;
        }
    }
}
