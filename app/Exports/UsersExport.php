<?php

namespace App\Exports;

use App\Models\User;
use App\Enums\GenderEnum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = User::with(['language'])->get();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                $user->name,
                $user->birthday,
                $user->gender == GenderEnum::Male->value ? 'ذكر' : 'أنثى',
                $user->email,
                $user->phone,
                $user->language?->name,
                $user->created_at,
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
        return ['الأسم', 'تاريخ الميلاد', 'الجنس', 'البريد الإلكتروني', 'رقم الهاتف', 'اللغة', 'تاريخ الإضافة'];
    }
}
