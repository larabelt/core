<a name="managers"></a>
## Managing Data

Data Managers are generally made up of the same elements to allow consistent behavior throughout the system. Within the right pane of page you have the following:

@include('belt-core::docs.partials.table', [
    'rows' => [
        ['Area Indicator​​', 'Area heading at top, ex. Attachment Manager.'],
        ['Search Tool', 'This tool allows for quick and simple free text search for the items to manage.'],
        ['General Data Columns', 'Listing of items sortable by available columns, this differs depending on the object being managed.'],
        ['Action Columns​​', 'Allows you to Add, Modify, or Delete managed data.'],
    ],
])

@include('belt-core::docs.partials.image', [
    'src' => '20/admin/core/assets/example-manager.png',
    'caption' => '(Above) Data Manager Screen',
])