<?php
namespace Ohio\Base\Domain;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    public function carbon($datetime)
    {
        $timestamp = strtotime($datetime);

        return [
            'timestamp' => (integer) $timestamp,
            'raw' => (string) date('Y-m-d H:i:s', $timestamp),
            'date' => (string) date('Y-m-d', $timestamp),
            'time' => (string) date('H:i:s', $timestamp),
        ];
    }

}