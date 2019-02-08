# Overview

---

- [Intro](#intro)
- [Left Hand Navigation](#sidebar)
- [Managing Data](#managers)
- [Editing Data](#editors)

<a name="intro"></a>
## Intro

The CMS tool is meant to be an easy to use interface to allow the creation and management of website content.

Users can log in here:​ {{ $url }}/login

Once logged in, the user will be presented with the main dashboard screen.

Along the top is the User Identification and User Settings area. The left pane contains the Admin's Primary CMS.

@include('belt-docs::partials.image', [
    'src' => '20/admin/core/assets/admin-dashboard.png',
    'caption' => '(Above) Main Administration Dashboard',
])

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

<a name="managers"></a>
## Managing Data

Data Managers are generally made up of the same elements to allow consistent behavior throughout the system. Within the right pane of page you have the following:

**Area Indicator​​** Area heading at top, ex. Attachment Manager

**Search Tool​​** This tool allows for quick and simple free text search for the items to manage.

**General Data Columns​​** Listing of items sortable by available columns, this differs depending on the object being managed.

**Action Columns​​** Allows you to Add, Modify, or Delete managed data.

@include('belt-docs::partials.image', [
    'src' => '20/admin/core/assets/example-manager.png',
    'caption' => '(Above) Data Manager Screen',
])

<a name="editors"></a>
## Editing Data

Data Editors are generally made up of the same elements to allow consistent behavior throughout the system. Within the right pane of page you have the following:

**Current Area Indicator​​** ex. Place Editor

**Attribute Tabs​​** This navigation allows you to manage additional attributes associated with specific data—it will change depending on the type of data being managed. A green bar indicates the current tab.

**Data Area​​** fields to which data can be entered.

**Save Button​​** commits the data to the database and is made available immediately. ​(Note: Upon
initial save, additional attribute tabs will be made available.)

@include('belt-docs::partials.image', [
    'src' => '20/admin/core/assets/example-editor.png',
    'caption' => '(Above) Data Editor Screen',
])