<?php

namespace Omnipay\PlatBox\Exception;

use Omnipay\Common\Exception\InvalidRequestException;

class PlatBoxException extends InvalidRequestException
{
    const CODE_INVALID_MESSAGE_FORMAT = 400;
    const CODE_INCORRECT_SIGNATURE_REQUEST = 401;
    const CODE_INVALID_DATA_REQUEST = 406;
    const CODE_FIELDS_VALUES_NOT_MATCHED = 409;
    const CODE_GENERAL_CLERICAL_ERROR = 1000;
    const CODE_USER_ACCOUNT_NOT_FOUND_OR_DISABLED = 1001;
    const CODE_INVALID_PAYMENT_CURRENCY = 1002;
    const CODE_INVALID_PAYMENT_AMOUNT = 1003;
    const CODE_ORDER_NOT_FOUND_OR_BAD_DATA = 1005;
    const CODE_PAYMENT_ALREADY_RESERVED = 2000;
    const CODE_PAYMENT_ALREADY_COMPLETED = 2001;
    const CODE_PAYMENT_ALREADY_CANCELED = 2002;
    const CODE_TRANSACTION_OUTDATED = 3000;

    protected static function getExceptionMessages()
    {
        return [
            self::CODE_INVALID_MESSAGE_FORMAT => 'Неверный формат сообщения',
            self::CODE_INCORRECT_SIGNATURE_REQUEST => 'Некорректная подпись запроса',
            self::CODE_INVALID_DATA_REQUEST => 'Неверные данные запроса',
            self::CODE_FIELDS_VALUES_NOT_MATCHED => 'Значения полей запроса не соответствуют данным в системе мерчанта',
            self::CODE_GENERAL_CLERICAL_ERROR => 'Общая техническая ошибка',
            self::CODE_USER_ACCOUNT_NOT_FOUND_OR_DISABLED => 'Учётная запись пользователя не найдена или заблокирована',
            self::CODE_INVALID_PAYMENT_CURRENCY => 'Неверная валюта платежа',
            self::CODE_INVALID_PAYMENT_AMOUNT => 'Неверная сумма платежа',
            self::CODE_ORDER_NOT_FOUND_OR_BAD_DATA => 'Запрашиваемые товары или услуги недоступны/выбранный продукт не найден/неверные данные заказа пользователя',
            self::CODE_PAYMENT_ALREADY_RESERVED => 'Платёж с указанным идентификатором уже зарезервирован',
            self::CODE_PAYMENT_ALREADY_COMPLETED => 'Платёж с указанным идентификатором уже проведен',
            self::CODE_PAYMENT_ALREADY_CANCELED => 'Платёж с указанным идентификатором уже отменён',
            self::CODE_TRANSACTION_OUTDATED => 'Зарезервированная ранее транзакция устарела',
        ];
    }

    public static function throwException($code, $comment = '')
    {
        $messages = self::getExceptionMessages();
        if (array_key_exists($code, $messages)) {
            $comment = $messages[$code] . ". $comment";
        }
        throw new static($comment, $code);
    }
}
