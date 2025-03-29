Tinymce Editor Extension for open-admin

## Installation

```bash
composer require alpha1130/open-admin-tinymce
php .\artisan vendor:publish --tag=open-admin-tinymce
```

## Usage

```php

$tinymceConfig = [
    'height' => 500,
    'language_url' => '',
    'language' => '',
    'license_key' => 'gpl',
    'plugins' => 'image link table fullscreen',
    'menubar' => 'edit view insert format tools table',
    'toolbar' => "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table | lineheight outdent indent| forecolor backcolor removeformat | code fullscreen preview | pagebreak anchor",
];

$cosConfig = [
    'secretId' => env('QCLOUD_COS_SECRET_ID', ''),
    'secretKey' => env('QCLOUD_COS_SECRET_KEY', ''),
    'bucket' => env('QCLOUD_COS_BUCKET', ''),
    'region' => env('QCLOUD_COS_REGION', 'ap-guangzhou'),
    'durationSeconds' => 6000,
    'publishDomain' => '',
    'allowPrefix' => ['*'],
    'keyPrefix' => '',
];

$form->tinymce('field-name')
    ->addVariables([
        'tinymceConfig' => $tinymceConfig,
        'cosConfig' => $cosConfig,
    ]);
```

License
------------
Licensed under [The MIT License (MIT)](LICENSE).