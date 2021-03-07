<?php

namespace Jnga\Authorizenet\Gateway\Response;

interface ResponseFields
{
    const TRANSACCTION_RESPONSE = 'transactionResponse';
    const RESPONSE_CODE = 'responseCode';
    const AUTH_CODE = 'authCode';
    const AVS_RESULT_CODE = 'avsResultCode';
    const CVV_RESULT_CODE = 'cvvResultCode';
    const CAVV_RESULT_CODE = 'cavvResultCode';
    const TRANSACCTION_ID = 'transId';
    const REF_TRANSACCTION_ID = 'refTransID';
    const TRANSACCTION_HASH = 'transHash';
    const TEST_REQUEST = 'testRequest';
    const ACCOUNT_NUMBER = 'accountNumber';
    const ACCOUNT_TYPE = 'accountType';
    const MESSAGES = 'messages';
    const MESSAGE_CODE = 'code';
    const MESSAGE_DESCRIPTION = 'description';
    const TRANSACCTION_HASH_SHA2 = 'transHashSha2';
    const REFERENCE_ID = 'refId';
}
