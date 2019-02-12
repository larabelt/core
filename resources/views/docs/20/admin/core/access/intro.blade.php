<a name="intro"></a>
## Intro

The Access area allows the creation of authenticated users into the {todo}.

@include('belt-docs::partials.image', ['src' => '20/admin/core/assets/access-dropdown.png'])

@include('belt-docs::partials.table', [
    'rows' => [
        ['Users', 'Where users are created, managed, and deleted.'],
        ['Roles​​', 'Manages attributes to be used to define "permission" within the website. ​Currently, users are automatically granted admin status.'],
    ],
])