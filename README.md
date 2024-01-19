## Installation

Install package using composer
```bash
composer require aytacmalkoc/tracker
```

Run artisan's migrate command
```bash
php artisan migrate
```

Publish assets
```bash
php artisan vendor:publish --tag=tracker::assets
```

If you need the customization package, export config file
```bash
php artisan vendor:publish --tag=tracker::config
```

Add @trackerScript directive and csrf token to top of head tag
```html
<head>
    @trackerScript
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
```

## License

MIT License. Please check [license](LICENSE.md) file.
