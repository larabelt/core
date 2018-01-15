<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="{{ Request::url() }}" rel="self" type="application/rss+xml"/>
        <title><![CDATA[{{ $title }}]]></title>
        @foreach($items as $item)
            <item>
                <title><![CDATA[{{ $item->name }}]]></title>
                <description><![CDATA[{{ $item->body }}]]></description>
            </item>
        @endforeach
    </channel>
</rss>