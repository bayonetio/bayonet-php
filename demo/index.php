<?php

// load requirements
require __DIR__ . '/../vendor/autoload.php';
use Bayonet\BayonetClient;

// fixtures
$fx = json_decode(file_get_contents(__DIR__ . '/fixtures/requests.json'), true);

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST') {
    $api_key = $_SERVER['HTTP_TOKEN'];
    $api = $_SERVER['HTTP_API'];
    $body = file_get_contents('php://input');

    // initialize bayonet sdk
    $bayonet = new BayonetClient([
        'api_key' => $api_key,
        'version' => 1
    ]);

    $respond = function($response) {
        // return the response as json
        echo json_encode($response);
        die();   
    };

    // make the request
    $bayonet->{$api}([
        'body' => json_decode($body, true),
        'on_success' => $respond,
        'on_failure' => $respond
    ]);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Bayonet PHP demo</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>    
    <div class="container-fluid">
        <div class="row form-inline">
            <h2>Bayonet PHP demo</h2>
            <select id="api" class="form-control">
                <option value="consulting">Consulting</option>
                <option value="feedback">Feedback</option>
                <option value="feedback_historical">Feedback historical</option>
                <option value="get_fingerprint_data">Get fingerprint data</option>
            </select>
            <input id="key" class="form-control" type="text" placeholder="API Key" />
            <button id="go" class="btn btn-default" type="submit">Go</button>
        </div>
        
        <div class="row form-inline">
            <div class="col-md-6">
                <h4>Request</h4>
                <textarea id="request" class="form-control" rows="30" cols="100">
                </textarea>
            </div>
            <div class="col-md-6">
                <h4>Response</h4>
                <textarea id="response" class="form-control" rows="30" cols="100">
                </textarea>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var examples = {
            consulting: '<?= json_encode($fx["consulting"]); ?>',
            feedback: '<?= json_encode($fx["feedback"]); ?>',
            feedback_historical: '<?= json_encode($fx["feedback_historical"]); ?>',
            get_fingerprint_data: '<?= json_encode($fx["get_fingerprint_data"]); ?>'
        };

        $(function() {
            $('#go').on('click', function() {
                $.ajax({
                    method: 'POST',
                    url: 'index.php',
                    data: $('#request').val(),
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    headers: {
                        token: $('#key').val(),
                        api: $('#api').val()
                    }
                }).done(function(data) {
                    $('#response').val(
                        JSON.stringify(data, null, 4)
                    );
                });
            });

            $('#api').on('change', function () {
                $('#request').val(
                    JSON.stringify(
                        JSON.parse(
                            examples[$('#api').val()]
                        ),
                        null,
                        4
                    )
                );
            });

            $('#api').change();
        });
    </script>
</body>
</html>