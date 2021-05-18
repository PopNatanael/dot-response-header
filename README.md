# dot-response-header

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-response-header)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-response-header)](https://github.com/dotkernel/response-header/LICENSE.md)

Middleware for setting and overwriting custom response headers.


### Requirements
- PHP >= 7.4

### Installation

Run the following command in your project root directory

```
$ composer require dotkernel/dot-response-header
``` 

Next, register the package's `ConfigProvider` to your application config.

``Dot\ResponseHeader\ConfigProvider::class,``

Note : Make sure to register the package under the `// DK packages` section.

After registering the package, add it to the middleware stack in ``config/pipeline.php`` after `$app->pipe(RouteMiddleware::class);`

```
$app->pipe(RouteMiddleware::class);
$app->pipe(\Dot\ResponseHeader\Middleware\ResponseHeaderMiddleware::class);
```

Create a new file ``response-header.global.php`` in ``config/autoload`` with the below configuration array :

```
<?php
return [
    'dot_response_headers' => [
        '*' => [
            'CustomHeader1' => [
                'value' => 'CustomHeader1-Value',
                'overwrite' => true,
            ],
            'CustomHeader2' => [
                'value' => 'CustomHeader2-Value',
                'overwrite' => false,
            ],
        ],
        'home' => [
            'CustomHeader' => [
                'value' => 'header3',
            ]
        ],
        'login' => [
            'LoginHeader' => [
                'value' => 'LoginHeader-Value',
                'overwrite' => false
            ]
        ],
    ]
]; 
```

Because headers are matched with route names, we can have custom response headers for every request, by defining new headers under the ``*`` key.

All headers under ``*`` will be set for every response.

To add response headers for a specific set of routes, define a new array using the route name as the array key.

Example : 
```
'dot_response_headers' => [
    'user' => [
        'UserCustomHeader' => [
            'value' => 'UserCustomHeader-Value',
            'overwrite' => false
        ]
    ],
]

// This will set a new header named UserCustomHeader with the UserCustomHeader-Value value for any route name matching 'user'
```

To overwrite an existing header use ``overwrite => true``.
