[![Latest Stable Version](https://poser.pugx.org/bayonet/bayonet-php/v/stable)](https://packagist.org/packages/bayonet/bayonet-php)
[![License](https://poser.pugx.org/bayonet/bayonet-php/license)](https://packagist.org/packages/bayonet/bayonet-php)

## Bayonet
Bayonet enables companies to feed and consult a global database about online consumers’ reputation, based on historic payments. Start making smarter business decisions today.

### Introduction
Bayonet’s API is organized around REST and exposes endpoints for HTTP requests. It is designed to have predictable, resource-oriented URLs and uses standard HTTP response codes to indicate the outcome of operations. Request and response payloads are formatted as JSON.

### About the service
Bayonet provides an Ecosystem of Trust and Protection where companies can collaborate with each other to combat online fraud together. We provide a secure platform to share and consult data to understand when a consumer is related to fraudulent activity or has a fraud-free record. Different technologies that run algorithms to link parameters seen in different transactions, fed by companies connected to the ecosystem are employed in order to build consumer profiles. By consulting Bayonet’s API, a response with data provided by companies themselves is available in real-time for your risk assesment process to analyze it and take better decisions.

### Bayonet's API details
The examples shown in this README are only for demonstration of the functionality of this SDK. For the detailed integration flow, and when to send which API call, please refer to the Bayonet [API documentation](https://bayonet.io/console/docs).

## Getting started

### Requirements
To use this SDK, please make sure:
  * You have PHP 5.4 or superior installed on your system.
  * You have an API KEY (sandbox and/or live) provided by Bayonet's team.
  
### Composer
1. Add dependency 'bayonet-php' in your composer.json file
  
    ```
    "require": {
        ...
        "bayonet/bayonet-php": "2.0.*"
        ...
    }
    ```
   Run composer to get the dependencies
  
    ```sh
    composer update
    ```
2. Load the dependencies using Composer autoload

    ```php
    require_once('vendor/autoload.php');
    ```
    
### Manual Installation
1. If you do not use Composer, download the [latest release](https://github.com/Bayonet-Client/bayonet-php/releases). Extract into your project root into a folder named `bayonet-php`. Use the `init.php` file to load the Bayonet dependencies

    ```php
    require 'bayonet-php/init.php';
    ```
2. BayonetClient uses [Guzzle](https://github.com/guzzle/guzzle) as dependency. Make sure you download and include Guzzle into your project as well

    ```php
    require 'guzzle/autoloader.php';
    ```
  If you use Composer, the above dependency will be handled automatically. If you choose manual installation, you will need to make sure the dependency is available.

## Usage
Once you have Bayonet's SDK configured, you can call the APIs with the following syntax. Follow the guidelines specific to the product you are integrating:

* [Ecommerce](#ecommerce)

* [Lending](#lending)

### Ecommerce

  * Initialize the Ecommerce client

    ```php
    $bayonet = new Bayonet\EcommerceClient([
      'api_key' => 'your_api_key',
      'version' => 2
    ]);
    ```
    You can use environment vars to load the api key too

    ```sh
    export BAYONET_API_KEY=your_api_key
    ```

  * Consult API
  
    ```php
    $bayonet->consult([
      'body' => [
        'channel' => 'ecommerce',
        'email' => 'example@bayonet.io',
        'consumer_name' => 'Example name',
        'consumer_internal_id' => '<your internal ID for this consumer>',
        'cardholder_name' => 'Example name',
        'telephone' => '1234567890',
        'card_number' => '4111111111111111',
        'transaction_amount' => 999.00,
        'currency_code' => 'MXN',
        'shipping_address' => [
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        ],
        'billing_address' => [
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        ],
        'payment_method' => 'card',
        'order_id' => '<your internal ID for this order>',
        'transaction_id' => '<your internal ID for this transaction>',
        'payment_gateway' => 'stripe',
        'coupon' => 'discount_buen_fin',
        'expedited_shipping' => true,
        'products' => [
          [
            'product_id' => '1',
            'product_name' => 'product_1',
            'product_price' => 500.00,
            'product_category' =>'example category'
          ],
          [
            'product_id' => '2',
            'product_name' => 'product_2',
            'product_price' => 499.00,
            'product_category' =>'example category'
          ]
        ],
        'bayonet_fingerprint_token' => '<token generated by Bayonet fingerprinting JS>'
      ],
      'on_success' => function($response) {
        print_r($response);
      },
      'on_failure' => function($response) {
        print_r($response);
      }
    ]);
    ```
  * Update Transaction API
  
    ```php
    $bayonet->update_transaction([
      'body' => [
        'transaction_status' => 'success',
        'transaction_id' => '<your internal ID for this transaction (as sent in the consult step)>',
        ...
      ],
      'on_success' => function($response) {
        print_r($response);
      },
      'on_failure' => function($response) {
        print_r($response);
      }
    ]);
    ```
  * Feedback-historical API
  
    ```php
    $bayonet->feedback_historical([
      'body' => [
        'channel' => 'ecommerce',
        'email' => 'example@bayonet.io',
        'consumer_name' => 'Example name',
        'consumer_internal_id' => '<your internal ID for this consumer>',
        'cardholder_name' => 'Example name',
        'telephone' => '1234567890',
        'card_number' => '4111111111111111',
        'transaction_amount' => 999.00,
        'currency_code' => 'MXN',
        'shipping_address' => [
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        ],
        'billing_address' => [
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        ],
        'payment_method' => 'card',
        'transaction_id' => '<your internal ID for this transaction>',
        'payment_gateway' => 'stripe',
        'coupon' => 'discount_buen_fin',
        'expedited_shipping' => true,
        'products' => [
          [
            'product_id' => '1',
            'product_name' => 'product_1',
            'product_price' => 500.00,
            'product_category' =>'example category'
          ],
          [
            'product_id' => '2',
            'product_name' => 'product_2',
            'product_price' => 499.00,
            'product_category' =>'example category'
          ]
        ],
        'bayonet_fingerprint_token' => '<token generated by Bayonet fingerprinting JS>',
        'transaction_time' => 1476012879,
        'transaction_status' => 'success',
      ],
      'on_success' => function($response) {
          print_r($response);
      },
      'on_failure' => function($response) {
          print_r($response);
      }
    ]);
    ```
    
### Lending

  * Initialize the Lending client
  
      ```php
      $bayonet = new Bayonet\LendingClient([
        'api_key' => 'your_api_key',
        'version' => 2
      ]);
      ```
      You can use environment vars to load the api key too
  
      ```sh
      export BAYONET_API_KEY=your_api_key
      ```

  * Report Transaction (Request for loan received)
    
    ```php
    $bayonet->report_transaction([
      'body' => [
        'email' => 'example@bayonet.io',
        'consumer_name' => 'Example name',
        'consumer_internal_id' => '<your internal ID for this consumer>',
        'telephone_fixed' => '1234567890',
        'telephone_mobile' => '1234567891',
        'telephone_reference_1' => '1234567892',
        'telephone_reference_2' => '1234567893',
        'telephone_reference_3' => '1234567894',
        'rfc' => 'Example RFC',
        'curp' => 'Example CURP',
        'clabe' => 'Example CLABE',
        'address' => [
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        ],
        'bayonet_fingerprint_token' => '<token generated by Bayonet fingerprinting JS>',
        'transaction_category' => 'p2p_lending',
        'transaction_id' => '<your internal ID for this transaction>',
        'transaction_time' => 1476012879
      ],
      'on_success' => function($response) {
        print_r($response);
      },
      'on_failure' => function($response) {
        print_r($response);
      }
    ]);
    ```

  * Report Transaction (Request for loan received) + Consult 

   This lets you report a transaction (solicitud) and consult Bayonet at the same time. The only difference from the above method (Report Transaction) is that this method will also return a consult response
   
    ```php
    $bayonet->report_transaction_and_consult([
      'body' => [
        'email' => 'example@bayonet.io',
        'consumer_name' => 'Example name',
        'consumer_internal_id' => '<your internal ID for this consumer>',
        'telephone_fixed' => '1234567890',
        'telephone_mobile' => '1234567891',
        'telephone_reference_1' => '1234567892',
        'telephone_reference_2' => '1234567893',
        'telephone_reference_3' => '1234567894',
        'rfc' => 'Example RFC',
        'curp' => 'Example CURP',
        'clabe' => 'Example CLABE',
        'address' => [
          'line_1' => 'example line 1',
          'line_2' => 'example line 2',
          'city' => 'Mexico City',
          'state' => 'Mexico DF',
          'country' => 'MEX',
          'zip_code' => '64000'
        ],
        'bayonet_fingerprint_token' => '<token generated by Bayonet fingerprinting JS>',
        'transaction_category' => 'p2p_lending',
        'transaction_id' => '<your internal ID for this transaction>',
        'transaction_time' => 1476012879
      ],
      'on_success' => function($response) {
        print_r($response);
      },
      'on_failure' => function($response) {
        print_r($response);
      }
    ]);
    ```

  * Consult (consult the persona present in the transaction)
    
    ```php
    $bayonet->consult([
      'body' => [
        'transaction_id' => '<transaction ID that you used when reporting the transaction or solicitud>'
      ],
      'on_success' => function($response) {
        print_r($response);
      },
      'on_failure' => function($response) {
        print_r($response);
      }
    ]);
    ```

  * Feedback (send feedback regarding a transaction - raise alert or block the user)
    
    ```php
    $bayonet->feedback([
      'body' => [
        'transaction_id' => '<transaction ID that you used when reporting the transaction or solicitud>',
        'actions' => [
          'alert' => true,
          'block' => true
        ]
      ],
      'on_success' => function($response) {
        print_r($response);
      },
      'on_failure' => function($response) {
        print_r($response);
      }
    ]);
    ```

  * Feedback historical (for reporting historical transactions that were not sent to Bayonet)
      
      ```php
      $bayonet->feedback_historical([
        'body' => [
          'email' => 'example@bayonet.io',
          'consumer_name' => 'Example name',
          'consumer_internal_id' => '<your internal ID for this consumer>',
          'telephone_fixed' => '1234567890',
          'telephone_mobile' => '1234567891',
          'telephone_reference_1' => '1234567892',
          'telephone_reference_2' => '1234567893',
          'telephone_reference_3' => '1234567894',
          'rfc' => 'Example RFC',
          'curp' => 'Example CURP',
          'clabe' => 'Example CLABE',
          'address' => [
            'line_1' => 'example line 1',
            'line_2' => 'example line 2',
            'city' => 'Mexico City',
            'state' => 'Mexico DF',
            'country' => 'MEX',
            'zip_code' => '64000'
          ],
          'bayonet_fingerprint_token' => '<token generated by Bayonet fingerprinting JS>',
          'transaction_category' => 'p2p_lending',
          'transaction_id' => '<your internal ID for this transaction>',
          'transaction_time' => 1476012879,
          'actions' => [
            'alert' => true,
            'block' => true
          ]
        ],
        'on_success' => function($response) {
          print_r($response);
        },
        'on_failure' => function($response) {
          print_r($response);
        }
      ]);
      ```

### Device Fingerprint

  * Initialize the Device Fingerprint client
  
      ```php
      $bayonet = new Bayonet\DeviceFingerprintClient([
        'api_key' => 'your_api_key',
        'version' => 2
      ]);
      ```
    You can use environment vars to load the api key too
      ```sh
      export BAYONET_API_KEY=your_api_key
      ```
    
  * Get-fingerprint-data API
    You can use this endpoint to get detailed information about a fingerprint generated by the Bayonet fingerprinting JS installed on your front-end
    ```php
    $bayonet->get_fingerprint_data([
        'body' => [
            'bayonet_fingerprint_token' => 'fingerprint-token-generated-by-JS-snipppet'
        ],
        'on_success' => function($response) {
            print_r($response);
        },
        'on_failure' => function($response) {
            print_r($response);
        }
    ]);
    ```
 
## Success and error handling
Bayonet's SDK supports callbacks  for success and error handling
  ```php
  // make the request
  $bayonet -> <EVENT>([
    'body' => ...,
    'on_success' => function($response) {
      print_r($response);
    },
    'on_failure' => function($response) {
      print_r($response);
    }
  ]);
  ?>
  ```
For a full list of error codes and their messages, please refer to the Bayonet [API documentation](https://bayonet.io/console/docs).

## Demo
You can run a demo application with this command:
```sh
cd demo && php -S localhost:8000
```

## Testing
You can run the test suite with the following command:
```sh
./vendor/bin/phpunit tests
```
