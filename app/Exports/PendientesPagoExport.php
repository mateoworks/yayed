<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendientesPagoExport implements FromQuery, WithMapping
{
    use Exportable;
    protected $query;
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        $results = collect(DB::select($this->query));
        return $results->map(function ($item) {
            return (array) $item;
        });
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->ultimo_pago,
            $data->capital_pagado,
            $data->full_name,
            $data->phone,
            $data->amount,
            $data->number,
        ];
    }
}
