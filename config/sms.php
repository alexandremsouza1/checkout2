<?php

return [
    'service_name' => 'zenvia',
    'service_link' => 'https://www.zenvia.com',
    'service_documentation' => 'https://desenvolvedores.zenvia.com/sms/primeiros-passos/',
    'api' => [
        'url' => 'https://api-rest.zenvia.com/services/send-sms',
        'authorization' => 'bW9iaXVwLnNtc29ubGluZTp5b3ZFWlpVVEUz', // echo -n mobiup.smsonline:yovEZZUTE3 | base64
        'conta' => 'mobiup.smsonline',
        'senha' => 'yovEZZUTE3'
    ],
    'from' => 'Sorocaba Refrescos',
    'sendSmsRequest' => [
        'from' => 'Remetente',
        'to' => '5541984054350',
        'schedule' => '2014-08-22T14:55:00',
        'msg' => 'Mensagem de teste',
        'callbackOption' => 'NONE',
        'id' => '002',
        'aggregateId' => '1111',
        'flashSms' => false
    ],
    'sendSmsResponse' => [
        'statusCode' => '00',
        'statusDescription' => 'Ok',
        'detailCode' => '000',
        'detailDescription' => 'Message Sent'
    ]
];