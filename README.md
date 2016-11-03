## Bayonet
Bayonet enables companies to feed and consult a global database about online consumers’ reputation, based on historic payments. Start making smarter business decisions today.

### Introduction
Bayonet’s API is organized around REST and exposes endpoints for HTTP requests. It is designed to have predictable, resource-oriented URLs and uses standard HTTP response codes to indicate the outcome of operations. Request and response payloads are formatted as JSON.

### About the service
Bayonet provides an Ecosystem of Trust and Protection where companies can colaborate with each other to combat online fraud together. We provide a secure platform to share and consult data to understand when a consumer is related to fraudulent activity or has a fraud-free record. Different technologies that run algorithms to link parameters seen in different transactions, fed by companies connected to the ecosystem are employed in order to build consumer profiles. By consulting Bayonet’s API, a response with data provided by companies themselves is available in real-time for your risk assesment process to analyze it and take better decisions.

### Bayonet's API details
To know more about Bayonet's API and its domain and technical details, please see the "Integration Specs V 1.0" document provided by the Bayonet team.

## Getting started
To use this SDK, please make sure:
  * You have PHP 5.4 or superior installed on your system.
  * You have an API KEY (sandbox and/or live) provided by Bayonet's team.
  * Add dependency 'bayonet-php-sdk' in your composer.json file.
  * Run composer to get the dependencies
  
    ```sh
    composer update
    ```
  * Import the Bayonet SDK.

    ```php
    <?php
    require __DIR__ . '/../vendor/autoload.php';
    use Bayonet\BayonetClient;
    ?>
    ```
  * Create config options, with parameters (api_key).

    ```php
    <?php
    $bayonet = new BayonetClient([
        'api_key' => '011RR5BdHEEF2RNSmha42SDQ6sYRL9TM',
        'version' => 1
    ]);;
    ?>
    ```
  * You can use environment vars too.

    ```sh
    export BAYONET_API_KEY=011RR5BdHEEF2RNSmha42SDQ6sYRL9TM
    ```

## Usage
Once you have Bayonet's SDK configured, you can call the three APIs with the following syntax:
  * Consulting API
  
    ```php
    <?php
    $bayonet->consulting([
        'body' => [
            'channel' => 'mpos',
            'email' => 'luisehk@gmail.com',
            'consumer_name' => 'Luis Herrada',
            'cardholder_name' => 'Luis Herrada',
            'payment_method' => 'card',
            'card_number' => 4111111111111111,
            'transaction_amount' => 320,
            'currency_code' => 'MXN',
            'transaction_time' => 1476012879,
            'coupon' => false,
            'payment_gateway' => 'stripe',
            'shipping_address' => [
                'address_line_1' => 'Calle 123',
                'address_line_2' => '456',
                'city' => 'Monterrey',
                'state' => 'Nuevo León',
                'country' => 'MX',
                'zip_code' => '64000'
            ]
        ],
        'on_success' => function($response) {
            print_r($response);
        },
        'on_failure' => function($response) {
            print_r($response);
        }
    ]);
    ?>
    ```
  * Feedback API
  
    ```php
    <?php
    $bayonet->feedback([
        'body' => [
            'transaction_status' => 'bank_decline',
            'transaction_id' => 'test_php',
            'feedback_api_trans_code' => 'xxx'
        ]
    ]);
    ?>
    ```
  * Feedback-historical API
  
    ```php
    <?php
    $bayonet->feedback_historical([
        'body' => [
            'channel' => 'mpos',
            'type' => 'transaction',
            'email' => 'david@gmail.com',
            'consumer_name' => 'David Gilmour',
            'payment_method' => 'card',
            'card_number' => 4929699022445935,
            'transaction_amount' => 500,
            'currency_code' => 'USD',
            'transaction_time' => 1423823404,
            'transaction_status' => 'bank_decline',
            'transaction_id' => 'uhffytd65rds56yt',
            'coupon' => false,
            'payment_gateway' => 'stripe',
            'device_fingerprint' => 'AF567GHGJJJ87JH',
            'bank_auth_code' => '5353888',
            'telephone' => '5566768423',
            'expedited_shipping' => false,
            'bank_decline_reason' => 'stolen_card',
            'shipping_address' => [
                'address_line_1' => '8100 Sunset Boulevard',
                'address_line_2' => 'Apt 6B',
                'city' => 'San Francisco',
                'state' => 'Sunnyvale',
                'country' => 'USA',
                'zip_code' => '03257'
            ]
        ]
    ]);
    ?>
    ```
 
## Success and error handling
Bayonet's SDK supports callbacks  for success and error handling
```php
<?php
// fixtures
$fx = json_decode(file_get_contents(__DIR__ . '/fixtures/requests.json'), true);

// make the request
$bayonet->consulting([
    'body' => $fx['consulting'],
    'on_success' => function($response) {
        print_r($response);
    },
    'on_failure' => function($response) {
        print_r($response);
    }
]);
?>
```

For a full list of error codes and their messages, please see the "Integration Specs V 1.0" document provided by the Bayonet team.

## Demo
You can run a demo application with this command:
```sh
echo Hello
```

## Testing
You can run the test suite with the following command:
```sh
echo Hello
```
