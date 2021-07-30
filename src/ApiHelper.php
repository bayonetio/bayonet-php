<?php

namespace Bayonet;

class ApiHelper
{
    public static function request($api, $endpoint, array $params = [], array $config = [])
    {
        if (!isset($params['body'])) {
            $params['body'] = [];
        }

        $base_uri = $config['base_uri'];
        $params['body']['auth']['api_key'] = $config['api_key'];
        $base_uri = $base_uri . 'sigma/';
      
        $headers = [
            'Accept: application/json',
            'Content-Type: applicaction/json'
        ];
        
        $ch = curl_init($base_uri . $endpoint);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params['body']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        
        $resp = curl_exec($ch);

        if ($resp === FALSE) {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (intval($httpCode === 404)) {
                if (isset($params['on_failure'])) {
                    $params['on_failure'](
                        'An error ocurred while performing the request: Not found'
                    );
                }
            } elseif (curl_errno($ch)) {
                if (isset($params['on_failure'])) {
                    $params['on_failure'](
                        'An error ocurred while performing the request: ' . curl_error($ch)
                    );
                }
            }
        } elseif (curl_errno($ch)) {
            if (isset($params['on_failure'])) {
                $params['on_failure'](
                    'An error ocurred while performing the request: ' . curl_error($ch)
                );
            } 
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (intval($httpCode === 404)) {
                if (isset($params['on_failure'])) {
                    $params['on_failure'](
                        'An error ocurred while performing the request: Not found'
                    );
                }
            } else {
                $decoded = json_decode($resp);
                
                if (isset($decoded->reason_code)) {
                    if (intval($decoded->reason_code) !== 0) {
                        if (isset($params['on_failure'])) {
                            $params['on_failure'](
                                $decoded
                            );
                        }
                    } else {
                        if (isset($params['on_success'])) {
                            $params['on_success'](
                                $decoded
                            );
                        }
                    }
                }
            }
        }

        curl_close($ch);
    }
}
