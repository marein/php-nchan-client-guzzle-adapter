# php-nchan-client-guzzle-adapter

Guzzle adapter for [marein/php-nchan-client](https://github.com/marein/php-nchan-client).

## Installation

```
composer require marein/php-nchan-client-guzzle-adapter
```

## Usage

```php
<?php

namespace {

    use GuzzleHttp\Client;
    use Marein\Nchan\Api\Model\PlainTextMessage;
    use Marein\Nchan\Nchan;
    use Marein\NchanGuzzle\GuzzleAdapter;

    include '/path/to/autoload.php';

    $client = new Client();

    $nchan = new Nchan(
        'http://my-nchan-domain',
        new GuzzleAdapter($client)
    );
    $channel = $nchan->channel('/path-to-publisher-endpoint');
    $channelInformation = $channel->publish(
        new PlainTextMessage(
            'my-message-name',
            'my message content'
        )
    );

    // Nchan returns some channel information after publishing a message.
    var_dump($channelInformation);
}
```

The complete documentation for [marein/php-nchan-client](https://github.com/marein/php-nchan-client) can be found
[here](https://github.com/marein/php-nchan-client).