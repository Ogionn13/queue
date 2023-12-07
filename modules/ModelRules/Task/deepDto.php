<?php

return [
    'id' => [],
    'result' => [
        'pipe' => ['boolval']
    ],
    "inputData" => [],
    'className' => [
        'pipe' => [
            function (?string $className) {
                return (empty ($className)) ? "" : $className;
            }
        ]
    ],
    'urlHook' => [
        'pipe' => [
            function (?string $urlHook) {
                return (empty ($urlHook)) ? "" : $urlHook;
            }
        ]
    ],
    'attempts' => [
        'pipe' => [
            function (int $attempts) {
                return ++$attempts;
            }
        ]
    ],
    'created_at' => [
        'prop' => 'timestampWait',
        'pipe' => [
            function (string $created_at) {
                return time() - strtotime($created_at);
            }
        ]
    ]


];


//    'password' => [
//        'pipe-populate' => [
//            'strtolower',
//            function(string $openPassword) use($encrypter) {
//                return $encrypter->encrypt($openPassword);
//            },
//        ],
//        'pipe-extract' => [
//            function(string $ePassword) use($encrypter) {
//                return $encrypter->decrypt($ePassword);
//            },
//            'strtolower'
//        ],
//    ]
