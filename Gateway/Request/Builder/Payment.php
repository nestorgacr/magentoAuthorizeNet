<?php

namespace Jnga\Authorizenet\Gateway\Request\Builder;

use Jnga\Authorizenet\Observer\DataAssignObserver;
use Magento\Payment\Gateway\Data\PaymentDataObject;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Model\InfoInterface;
use Magento\Sales\Model\Order\Payment as OrderPayment;

class Payment implements BuilderInterface
{
    public function build(array $buildSubject)
    {
        /**
         * @var PaymentDataObject $paymentDataObject
         */
        $paymentDataObject = $buildSubject['payment'];

        /**
         * @var InfoInterface|OrderPayment $payment
         */
        $payment = $paymentDataObject->getPayment();

        return [
            'payment' => [
                'creditCard' => [
                    'cardNumber' => $payment->getData('cc_number'),
                    'expirationDate' => $this->getCardExpirationDate($payment),
                    'cardCode' => $payment->getData('cc_cid'),
                ]
            ]
        ];

        //return [
        //    'payment' => [
        //        'creditCart' => [
        //            'cardNumber' => $payment->getData(DataAssignObserver::CC_NUMBER),
        //            'expirationDate' => $this->getCardExpirationDate($payment),
        //            'cardCode' => $payment->getData(DataAssignObserver::CC_CID),
        //        ]
        //    ]
        //];
    }

    /**     
     *
     * @param InfoInterface|OrderPayment $payment
     * @return string
     */
    private function getCardExpirationDate(InfoInterface $payment)
    {
        return sprintf(
            '%s-%s',
            $payment->getData(DataAssignObserver::CC_EXP_YEAR),
            $payment->getData(DataAssignObserver::CC_EXP_MONTH)
        );
    }
}
