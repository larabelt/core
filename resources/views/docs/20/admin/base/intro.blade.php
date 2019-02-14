<a name="intro"></a>
## Intro

The CMS tool is meant to be an easy to use interface to allow the creation and management of website content.

Users can log in here:​ {{ $url }}/login

Once logged in, the user will be presented with the main dashboard screen.

Along the top is the User Identification and User Settings area. The left pane contains the Admin's Primary CMS.

{{--@include('belt-core::docs.partials.image', [--}}
    {{--'src' => '20/admin/core/assets/admin-dashboard.png',--}}
    {{--'caption' => '(Above) Main Administration Dashboard',--}}
{{--])--}}

@include('belt-core::docs.partials.iframe', [
    'src' => '/docs/preview/core/2.0/admin/screen',
    'fixed' => true,
    'width' => 800,
    'height' => 500,
])

**(Above) Main Administration Dashboard**