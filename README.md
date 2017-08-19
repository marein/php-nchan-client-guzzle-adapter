# php-nchan-client-guzzle-adapter

Guzzle adapter for [marein/php-nchan-client](https://github.com/marein/php-nchan-client).

## Usage

```php
<?php

namespace {

    use GuzzleHttp\Client;
    use Marein\Nchan\Message;
    use Marein\Nchan\Nchan;
    use Marein\NchanGuzzle\GuzzleAdapter;

    include '/path/to/autoload.php';

    // Setting http_errors to false is important, because 404 are valid responses for the nchan client.
    $client = new Client([
        'http_errors' => false
    ]);

    $nchan = new Nchan('http://my-nchan-domain', new GuzzleAdapter($client));

    $channelInformation = $nchan->channel('/path-to-publisher-endpoint')->publish(new Message(
        'message-name',
        'payload'
    ));
}
```