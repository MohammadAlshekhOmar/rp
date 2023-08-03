<?php

namespace App\Exports;

use App\Models\Provider;
use App\Enums\GenderEnum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProvidersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $providers = Provider::with(['language', 'regions'])->get();
        $data = [];
        foreach ($providers as $provider) {
            $data[] = [
                $provider->name,
                $provider->email,
                $provider->phone,
                $provider->language?->name,
                $provider->created_at,
            ];
        }

        if (empty($data)) {
            return collect([]);
        } else {
            return collect($data);
        }
    }

    public function headings(): array
    {
        return ['الأسم', 'البريد الإلكتروني', 'رقم الهاتف', 'اللغة', 'تاريخ الإضافة'];
    }
}
