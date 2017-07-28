# Omnipay: PlatBox
[PlatBox](https://platbox.com) payment processing driver for the Omnipay PHP payment processing library.

[![Latest Stable Version](https://poser.pugx.org/webtoucher/omnipay-platbox/v/stable)](https://packagist.org/packages/webtoucher/omnipay-platbox)
[![Total Downloads](https://poser.pugx.org/webtoucher/omnipay-platbox/downloads)](https://packagist.org/packages/webtoucher/omnipay-platbox)
[![Daily Downloads](https://poser.pugx.org/webtoucher/omnipay-platbox/d/daily)](https://packagist.org/packages/webtoucher/omnipay-platbox)
[![Latest Unstable Version](https://poser.pugx.org/webtoucher/omnipay-platbox/v/unstable)](https://packagist.org/packages/webtoucher/omnipay-platbox)
[![License](https://poser.pugx.org/webtoucher/omnipay-platbox/license)](https://packagist.org/packages/webtoucher/omnipay-platbox)

## Installation

The preferred way to install this library is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require webtoucher/omnipay-platbox "*"
```

or add

```
"webtoucher/omnipay-platbox": "*"
```

to the ```require``` section of your `composer.json` file.

## Usage

The following gateways are provided by this package:

* PlatBox API (https://platbox.com/new/docs/paybox_api_1.pdf)

```php
    $gateway = \Omnipay\Omnipay::create('PlatBox');
    $gateway->setMerchantId('[MERCHANT_ID]');
    $gateway->setSecretKey('[SECRET_KEY]');
    $gateway->setProject('[PROJECT]');
    // $gateway->setTestMode(true);
```

The first step is preparing data and sending to PlatBox.

```php
    $request = $gateway->purchase([
        'order_id' => $orderId,
        'amount' => $amount,
        'currency' => 'RUB',
        'account_id' => $userId,
        'phone_number' => $phone,
    ]);
    $response = $request->send();
    $result = $response->isSuccessful();
```

There is the callback request handler.

```php
    try {
        $data = json_decode(file_get_contents('php://input'), true);
    } catch (\Exception $e) {
        $data = [];
    }
    $action = isset($data['action']) ? $data['action'] : null;
    switch ($action) {
        case 'check':
            $request = $gateway->check($data);
            handleCallback($request, $failCallback);
            break;
        case 'pay':
            $request = $gateway->completePurchase($data);
            handleCallback($request, $failCallback, $successCallback);
            break;
        case 'cancel':
            $request = $gateway->completePurchase($data);
            handleCallback($request, $failCallback, $cancelCallback);
            break;
        default:
            // wrong request handler
    }
```

There is the callback request 'check' handler.

```php
    function handleCallback($request, $failCallback = null, $completeCallback = null) {
        try {
            $orderId = $request->getOrderId();
            $order = [...]; // find order model by order ID.
            if (!$order) {
                PlatBoxException::throwException(PlatBoxException::CODE_ORDER_NOT_FOUND_OR_BAD_DATA);
            }
            // Check order status
            if ($order->status = [...]) { // already paid
                PlatBoxException::throwException(PlatBoxException::CODE_PAYMENT_ALREADY_COMPLETED);
            }
            if ($order->status = [...]) { // already cancelled
                PlatBoxException::throwException(PlatBoxException::CODE_PAYMENT_ALREADY_CANCELED);
            }
    
            $request->setMerchantOrderId($order->id);
            $request->setMerchantAmount($order->amount);
            $request->setMerchantCurrency($order->currency);
    
            $responseData = $response->getData();
            $response->confirm();
            if (is_callable($successCallback)) {
                call_user_func($successCallback, $response);
            }
        } catch (PlatBoxException $e) {
            if (is_callable($failCallback)) {
                call_user_func($failCallback, $response);
            }
            $request->error($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            if (is_callable($failCallback)) {
                call_user_func($failCallback, $response);
            }
            $request->error();
        }
    }
```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/webtoucher/omnipay-platbox/issues).