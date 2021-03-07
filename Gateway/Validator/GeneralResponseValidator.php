<?php

declare(strict_types=1);

namespace Jnga\Authorizenet\Gateway\Validator;

use Magento\Payment\Gateway\Validator\AbstractValidator;

class GeneralResponseValidator extends AbstractValidator
{


    /** @inheritDoc */
    public function validate(array $validationSubject)
    {
        $response = $validationSubject['response'];

        $isValid = true;

        $errorMessages = array();

        foreach ($this->getResponseValidators() as $validator) {
            $validationResult = $validator($response);
            if (!$validationResult[0]) {
                $isValid = $validationResult[0];
                $errorMessages = array_merge($errorMessages, $validationResult[1]);
            }
        }

        return $this->createResult($isValid, $errorMessages);
    }

    /** @return array */
    private function getResponseValidators()
    {
        return array(
            function ($response) {
                return array(
                    isset($response['transactionResponse']) && is_array($response['transactionResponse']),
                    array(__('Authorize.NET error response'))
                );
            },
            function ($response) {
                return array(
                    isset($response['messages']['resultCode']) && 'Ok' === $response['messages']['resultCode'],
                    array($response['messages']['message'][0]['text'] ?: __('Authorize.NET error response'))
                );
            },
            function ($response) {
                return array(
                    empty($response['transactionResponse']['errors']),
                    array(isset($response['transactionResponse']['errors'][0]['errorText']) ? $response['transactionResponse']['errors'][0]['errorText'] : __('Authorize.NET error response'))
                );
            }
        );
    }
}
