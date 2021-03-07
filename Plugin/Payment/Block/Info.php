<?php

namespace Jnga\Authorizenet\Plugin\Payment\Block;

use Magento\Payment\Block\Info as BlockInfo;

class Info
{

    const RESPONSE_CODE = 'response_code';
    const AUTH_CODE = 'auth_code';
    const AVS_RESULT_CODE = 'avs_result_code';
    const CVV_RESULT_CODE = 'cvv_result_code';
    const CAVV_RESULT_CODE = 'cavv_result_code';
    const TRANSACCTION_ID = 'transaction_id';
    const REF_TRANSACCTION_ID = 'ref_transaction_id';
    const ACCOUNT_NUMBER = 'account_number';
    const ACCOUNT_TYPE = 'account_type';
    const TEST_REQUEST = 'test_request';
    const TRANSACCTION_HASH = 'transaction_hash';

    /** @var array */
    private $labels = array(
        self::AUTH_CODE => 'Auth Code',
        self::RESPONSE_CODE => 'Response Code',
        self::AVS_RESULT_CODE => 'Address Verification service (AVS) Result Code',
        self::CVV_RESULT_CODE => 'Card Code Verifcation (CVV)',
        self::CAVV_RESULT_CODE => 'Card Holder Verification Authentication (CAVV)',
        self::TRANSACCTION_ID => 'Transaction ID',
        self::REF_TRANSACCTION_ID => 'REF Transaction ID',
        self::ACCOUNT_NUMBER => 'Card Number',
        self::ACCOUNT_TYPE => 'Card Type',
        self::TEST_REQUEST => 'Test Request',
        self::TRANSACCTION_HASH => 'Transaction HASH'
    );


    /** @var array */
    private $values = array(
        self::AVS_RESULT_CODE => array(
            'P' => 'Not Applicable (P)'
        )
    );

    /**     
     *
     * @param BlockInfo $subject
     * @param array $result
     * @return array
     */
    public function afterGetSpecificInformation(
        BlockInfo $subject,
        $result
    ) {
        if ('jnga_authorizenet' === $subject->getData('methodCode')) {
            foreach ($this->labels as $key => $label) {
                if (array_key_exists($key, $result)) {
                    $value = $result[$key];
                    if (isset($this->values[$key][$value])) {
                        $value = $this->values[$key][$value];
                    }
                    $result[$label] = $value;
                    unset($result[$key]);
                }
            }
        }
        return $result;
    }
}
