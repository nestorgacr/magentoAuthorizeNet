<?php

namespace Jnga\Authorizenet\Gateway\Response;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Sales\Model\Order\Payment;

class TransactionAdditionalInfoHandler implements HandlerInterface
{

    /** @var  array */
    private $transactionAdditionalInfo = array(
        ResponseFields::RESPONSE_CODE => 'response_code',
        ResponseFields::AUTH_CODE => 'auth_code',
        ResponseFields::AVS_RESULT_CODE => 'avs_result_code',
        ResponseFields::CVV_RESULT_CODE => 'cvv_result_code',
        ResponseFields::CAVV_RESULT_CODE => 'cavv_result_code',
        ResponseFields::TRANSACCTION_ID => 'transaction_id',
        ResponseFields::REF_TRANSACCTION_ID => 'ref_transaction_id',
        ResponseFields::ACCOUNT_NUMBER => 'account_number',
        ResponseFields::ACCOUNT_TYPE => 'account_type',
        ResponseFields::TEST_REQUEST => 'test_request',
        ResponseFields::TRANSACCTION_HASH => 'transaction_hash'
    );

    /** @inheritDoc */
    public function handle(array $handlingSubject, array $response)
    {
        /** @var PaymentDataObjectInterface */
        $paymentDataObject = $handlingSubject['payment'];

        /** @var Payment */
        $payment = $paymentDataObject->getPayment();

        $transactionResponse = $response[ResponseFields::TRANSACCTION_RESPONSE];
        $transactionId = $transactionResponse[ResponseFields::TRANSACCTION_ID];
        $payment->setCcTransId($transactionId);
        $payment->setLastTransId($transactionId);
        $payment->setTransactionId($transactionId);




        $rawDetails = array();

        if (isset($response[ResponseFields::REFERENCE_ID])) {
            $rawDetails[ResponseFields::REFERENCE_ID] = $response[ResponseFields::REFERENCE_ID];
        }

        foreach ($this->transactionAdditionalInfo as $key => $transactionKey) {
            if (isset($transactionResponse[$key])) {
                $payment->setTransactionAdditionalInfo($transactionKey, $transactionResponse[$key]);
                $rawDetails[$key] = $transactionResponse[$key];
            }
        }

        if (isset($transactionResponse[ResponseFields::MESSAGES])) {
            foreach ($transactionResponse[ResponseFields::MESSAGES] as $key => $message) {
                $payment->setTransactionAdditionalInfo(
                    'message_code_' . $key,
                    $message[ResponseFields::MESSAGE_CODE]
                );
                $payment->setTransactionAdditionalInfo(
                    'message_description_' . $key,
                    $message[ResponseFields::MESSAGE_DESCRIPTION]
                );
            }
        }

        $payment->setTransactionAdditionalInfo('raw_details_info', $rawDetails);
    }
}
