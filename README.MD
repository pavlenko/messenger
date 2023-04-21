## Requirements

The following versions of PHP are supported.

* PHP 7.4+

## Installation

To install, use composer:

```
php composer.phar require pe/component-messenger
```

## Usage

This package allow you to send templated messages via various
channels and services. There are predefined channels to send a chat, mail, sms and push messages.
All you need - create integration (described below).

```php
namespace PE\Component\Messenger;

use PE\Component\Messenger\Channel\ChatChannel;
use PE\Component\Messenger\Template\ChatTemplate;

// Example chat (other types has same api)

/* @var $transport TransportInterface */
$transport = '...';// Telegram, Viber, WhatsApp, etc

$channel   = new ChatChannel($transport);
$template  = new ChatTemplate('Hello {{name}}', []);
$recipient = new Recipient('internalID', ['name' => 'John']);

// Send messages and get event collection with results
$events = $channel->send($template, $recipient/*, <other recipients>*/);

// That's all!
```

## Create integration

For create integration you need implement:

- Factory that implement ```PE\Component\Messenger\FactoryInterface```
  to create instances from DSN
- Transport that implement ```PE\Component\Messenger\TransportInterface```
  to send via specific API
- (Optionally) Collector that implement ```PE\Component\Messenger\CollectorInterface```
  to handle webhook calls
- (Optionally) Validator that implement ```PE\Component\Messenger\ValidatorInterface```
  to check integration successfully configured on remote side

Now you can use transport directly or integrate to integrations list.
For that you need add your factory to ```PE\Component\Messenger\FactoryMap```,
maybe via some DI container/framework.