<?php

declare(strict_types=1);

namespace Jnga\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Model\Order;

class Totals implements BuilderInterface
{
    /** @inheritDoc */
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject  =  $buildSubject['payment'];

        $payment = $paymentDataObject->getPayment();
        $order = $paymentDataObject->getOrder();

        /** @var Order */
        $orderModel = $payment->getOrder();

        return array(
            'tax' => array(
                'amount' => $orderModel->getTaxAmount()
            ),
            'duty' => array(
                'amount' => '0'
            ),
            'shipping' => array(
                'amount' => $orderModel->getBaseShippingAmount(),
                'name' => $orderModel->getShippingMethod()
            ),
            'poNumber' => $order->getOrderIncrementId()
        );
    }
}
