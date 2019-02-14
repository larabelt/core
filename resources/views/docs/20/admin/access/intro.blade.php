<a name="intro"></a>
## Intro

The Access area allows the creation of authenticated users into the {{ env('APP_NAME') }} website.

@include('belt-core::docs.partials.iframe', [
    'src' => '/docs/preview/core/2.0/admin/screen?style=sidebar&sidebar=access',
    'fixed' => true,
    'width' => 800,
    'height' => 350,
])

@include('belt-core::docs.partials.table', [
    'rows' => [
        ['Users', 'Where users are created, managed, and deleted.'],
        ['Roles​​', 'Manages attributes to be used to define "permission" within the website. ​Currently, users are automatically granted admin status.'],
        ['Teams', 'Manages attributes to be used to define "permission" within the website. ​Currently, users are automatically granted admin status.'],
    ],
])