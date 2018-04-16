<?php

namespace Belt\Core\Http\Controllers\Behaviors;

use Excel;

trait SpreadSheet
{

    /**
     * @param $xml
     * @return mixed
     */
    public function spreadsheet($items, $params = [])
    {
        $filename = array_get($params, 'filename', 'data');
        $format = array_get($params, 'format', 'xlsx');

        Excel::create($filename, function ($excel) use ($items, $params) {

            $excel->sheet('sheet', function ($sheet) use ($items, $params) {

                if ($headers = array_get($params, 'headers')) {
                    if (is_array($headers)) {
                        $sheet->appendRow($headers);
                    }
                    if ($headers === true && isset($items[0])) {
                        $sheet->appendRow(array_keys($items[0]));
                    }
                }

                foreach ($items as $n => $item) {
                    $sheet->appendRow($item);
                }

            });
        })->download($format);
    }

}