<?php

namespace Belt\Core\Http\Controllers\Behaviors;

use View;

trait XMLFeed
{

    /**
     * @param $view
     * @param $data
     * @return string
     */
    public function xmlContent($view, $data = [])
    {
        # view contents
        $xml = View::make($view, $data)->render();

        # common replacements
        $xml = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xml);
        $xml = preg_replace('/[^\x9\xa\x20-\xD7FF\xE000-\xFFFD]/', '', $xml);

        # simple xml object
        $xml = simplexml_load_string($xml, 'SimpleXMLElement');

        return trim($xml->asXML());
    }

    /**
     * @param $xml
     * @return mixed
     */
    public function xmlResponse($xml)
    {
        return response($xml)->header('Content-Type', 'text/xml');
    }

}