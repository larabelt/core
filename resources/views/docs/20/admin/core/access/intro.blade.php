<a name="intro"></a>
## Intro

The Access area allows the creation of authenticated users into the {todo}.

{{--@include('belt-docs::partials.iframe', ['src' => '/docs/preview/core/2.0/admin/managers.default'])--}}

@include('belt-docs::partials.iframe', ['src' => '/docs/preview/core/2.0/admin/managers.sidebar?menu=access-expanded'])

{{--@include('belt-docs::partials.image', ['src' => '20/admin/core/assets/access-dropdown.png'])--}}

@include('belt-docs::partials.table', [
    'rows' => [
        ['Users', 'Where users are created, managed, and deleted.'],
        ['Roles​​', 'Manages attributes to be used to define "permission" within the website. ​Currently, users are automatically granted admin status.'],
        ['Teams', 'Manages attributes to be used to define "permission" within the website. ​Currently, users are automatically granted admin status.'],
    ],
])