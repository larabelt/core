<a name="sidebar"></a>
## Left Hand Navigation

Here the user will find the main functional areas and pieces to construct, manage, and maintain the content within the website.

@include('belt-docs::partials.image', [
    'src' => '20/admin/core/assets/sidebar.png',
    'caption' => '(Above) Top Level Admin Navigation',
])

### Dashboard

Returns user to CMS home view

### Access

Users and roles are managed here. Currently, set all users to "super." Admin and Editor are currently not in use for Dominica.

### Content

Where the items needed to create pages are managed, including:
* Attachments: upload images to be used in pages and POIs
* Blocks: create and manage parts or sections of pages
* Handles: create and manage url handles for pages
* Lists: create and manage lists including adventures and itineraries
* Pages: create and update site pages
* Posts: not used at this time
* Terms: Used in the following situations:
* Cruise: Items that are using the term Cruise, appear on the {{ $url }}/cruise-guests​ page
* Landmark: Unique feature if a POI is a place like a waterfall. You want to reference the Term – Landmark – Waterfall under the POI terms section. This applies to waterfalls, beaches, hiking trails, must see, dive sites, gorge

### POIs

Where Points of Interests are managed, including:
* Amenities: allows users to assign amenities to Places
* Deals: not used at this time
* Events: create and manage events
* Places: create and manage places, which includes Accommodation, Landmark, Must See

### Alerts

Dominica, Restaurant, and Tour Operator
Where Alerts are managed. Alerts allow admin to add important information to the bottom of the site on all pages

### Menu

Where navigation menus are created, including the header, footer, and social media menu