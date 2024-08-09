<?php

namespace App\Exports;

use App\Models\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class LogsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Log::all();
    }

    /**
     * @param mixed $log
     *
     * @return array
     */
    public function map($log): array
    {
        // $context = json_decode($log->context, true); // Decode JSON array to PHP array
        $context = $log->context;
        return [
            $log->id,
            $log->level,
            $log->message,
            $context['role'] ?? null,
            $context['name'] ?? null,
            $context['email'] ?? null,
            $context['phone'] ?? null,
            $context['time'] ?? null,
            $context['ip'] ?? null,
            $log->created_at,
            $log->updated_at,
        ];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [
            "ID", 
            "LEVEL", 
            "MESSAGE", 
            "ROLE", 
            "NAME", 
            "EMAIL", 
            "PHONE", 
            "TIME", 
            "IP", 
            "CREATED_AT", 
            "UPDATED_AT"
        ];
    }
}
