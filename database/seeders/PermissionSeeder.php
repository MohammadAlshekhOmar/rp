<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADS
        Permission::create([
            'name' => 'VIEW_ADS',
            'name_ar' => 'عرض الإعلانات',
            'group' => 'الإعلانات',
        ]);
        Permission::create([
            'name' => 'CREATE_ADS',
            'name_ar' => 'إضافة إعلان',
            'group' => 'الإعلانات',
        ]);
        Permission::create([
            'name' => 'UPDATE_ADS',
            'name_ar' => 'تعديل إعلان',
            'group' => 'الإعلانات',
        ]);
        Permission::create([
            'name' => 'ACCEPT_ADS',
            'name_ar' => 'قبول إعلان',
            'group' => 'الإعلانات',
        ]);
        Permission::create([
            'name' => 'REJECT_ADS',
            'name_ar' => 'رفض إعلان',
            'group' => 'الإعلانات',
        ]);
        Permission::create([
            'name' => 'DELETE_ADS',
            'name_ar' => 'حذف إعلان',
            'group' => 'الإعلانات',
        ]);

        // USERS
        Permission::create([
            'name' => 'VIEW_USERS',
            'name_ar' => 'عرض المستخدمين',
            'group' => 'المستخدمين',
        ]);
        Permission::create([
            'name' => 'SHOW_USERS',
            'name_ar' => 'عرض معلومات المستخدم',
            'group' => 'المستخدمين',
        ]);
        Permission::create([
            'name' => 'CREATE_USERS',
            'name_ar' => 'إضافة مستخدم',
            'group' => 'المستخدمين',
        ]);
        Permission::create([
            'name' => 'UPDATE_USERS',
            'name_ar' => 'تعديل مستخدم',
            'group' => 'المستخدمين',
        ]);
        Permission::create([
            'name' => 'DELETE_USERS',
            'name_ar' => 'حذف مستخدم',
            'group' => 'المستخدمين',
        ]);

        // PROVIDERS
        Permission::create([
            'name' => 'VIEW_PROVIDERS',
            'name_ar' => 'عرض مزودين الخدمة',
            'group' => 'مزودين الخدمة',
        ]);
        Permission::create([
            'name' => 'SHOW_PROVIDERS',
            'name_ar' => 'عرض معلومات مزود الخدمة',
            'group' => 'مزودين الخدمة',
        ]);
        Permission::create([
            'name' => 'CREATE_PROVIDERS',
            'name_ar' => 'إضافة مزود خدمة',
            'group' => 'مزودين الخدمة',
        ]);
        Permission::create([
            'name' => 'UPDATE_PROVIDERS',
            'name_ar' => 'تعديل مزود خدمة',
            'group' => 'مزودين الخدمة',
        ]);
        Permission::create([
            'name' => 'DELETE_PROVIDERS',
            'name_ar' => 'حذف مزود خدمة',
            'group' => 'مزودين الخدمة',
        ]);

        // PROVIDERSRATES
        Permission::create([
            'name' => 'VIEW_PROVIDERSRATES',
            'name_ar' => 'عرض تقييمات مزودين الخدمة',
            'group' => 'تقييمات مزودين الخدمة',
        ]);
        Permission::create([
            'name' => 'DELETE_PROVIDERSRATES',
            'name_ar' => 'حذف تقييم مزود خدمة',
            'group' => 'تقييمات مزودين الخدمة',
        ]);

        // ROLES
        Permission::create([
            'name' => 'VIEW_ROLES',
            'name_ar' => 'عرض الأدوار',
            'group' => 'الأدوار',
        ]);
        Permission::create([
            'name' => 'CREATE_ROLES',
            'name_ar' => 'إضافة دور',
            'group' => 'الأدوار',
        ]);
        Permission::create([
            'name' => 'UPDATE_ROLES',
            'name_ar' => 'تعديل دور',
            'group' => 'الأدوار',
        ]);
        Permission::create([
            'name' => 'DELETE_ROLES',
            'name_ar' => 'حذف دور',
            'group' => 'الأدوار',
        ]);

        // ADMINS
        Permission::create([
            'name' => 'VIEW_ADMINS',
            'name_ar' => 'عرض المدراء',
            'group' => 'المدراء',
        ]);
        Permission::create([
            'name' => 'CREATE_ADMINS',
            'name_ar' => 'إضافة مدير',
            'group' => 'المدراء',
        ]);
        Permission::create([
            'name' => 'UPDATE_ADMINS',
            'name_ar' => 'تعديل مدير',
            'group' => 'المدراء',
        ]);
        Permission::create([
            'name' => 'DELETE_ADMINS',
            'name_ar' => 'حذف مدير',
            'group' => 'المدراء',
        ]);

        // SERVICES
        Permission::create([
            'name' => 'VIEW_SERVICES',
            'name_ar' => 'عرض الخدمات',
            'group' => 'الخدمات',
        ]);
        Permission::create([
            'name' => 'SHOW_SERVICES',
            'name_ar' => 'عرض تفاصيل الخدمة',
            'group' => 'الخدمات',
        ]);
        Permission::create([
            'name' => 'CREATE_SERVICES',
            'name_ar' => 'إضافة خدمة',
            'group' => 'الخدمات',
        ]);
        Permission::create([
            'name' => 'UPDATE_SERVICES',
            'name_ar' => 'تعديل خدمة',
            'group' => 'الخدمات',
        ]);
        Permission::create([
            'name' => 'DELETE_SERVICES',
            'name_ar' => 'حذف خدمة',
            'group' => 'الخدمات',
        ]);

        // SERVICESRATES
        Permission::create([
            'name' => 'VIEW_SERVICESRATES',
            'name_ar' => 'عرض تقييمات الخدمات',
            'group' => 'تقييمات الخدمات',
        ]);
        Permission::create([
            'name' => 'DELETE_SERVICESRATES',
            'name_ar' => 'حذف تقييم خدمة',
            'group' => 'تقييمات الخدمات',
        ]);

        // ORDERS
        Permission::create([
            'name' => 'VIEW_ORDERS',
            'name_ar' => 'عرض الطلبات',
            'group' => 'الطلبات',
        ]);
        Permission::create([
            'name' => 'DELETE_ORDERS',
            'name_ar' => 'حذف طلب',
            'group' => 'الطلبات',
        ]);

        // INVOICES
        Permission::create([
            'name' => 'VIEW_INVOICES',
            'name_ar' => 'عرض الفواتير',
            'group' => 'الفواتير',
        ]);
        Permission::create([
            'name' => 'DELETE_INVOICES',
            'name_ar' => 'حذف فاتورة',
            'group' => 'الفواتير',
        ]);

        // WARRANTIES
        Permission::create([
            'name' => 'VIEW_WARRANTIES',
            'name_ar' => 'عرض الضمانات',
            'group' => 'الضمانات',
        ]);
        Permission::create([
            'name' => 'DELETE_WARRANTIES',
            'name_ar' => 'حذف ضمان',
            'group' => 'الضمانات',
        ]);

        // NOTIFICATIONS
        Permission::create([
            'name' => 'VIEW_NOTIFICATIONS',
            'name_ar' => 'عرض الإشعارات',
            'group' => 'الإشعارات',
        ]);
        Permission::create([
            'name' => 'SHOW_NOTIFICATIONS',
            'name_ar' => 'عرض معلومات الإشعار',
            'group' => 'الإشعارات',
        ]);
        Permission::create([
            'name' => 'CREATE_NOTIFICATIONS',
            'name_ar' => 'إضافة إشعار',
            'group' => 'الإشعارات',
        ]);
        Permission::create([
            'name' => 'DELETE_NOTIFICATIONS',
            'name_ar' => 'حذف إشعار',
            'group' => 'الإشعارات',
        ]);

        // PAYMENTMETHODS
        Permission::create([
            'name' => 'VIEW_PAYMENTMETHODS',
            'name_ar' => 'عرض طرق الدفع',
            'group' => 'طرق الدفع',
        ]);
        Permission::create([
            'name' => 'CREATE_PAYMENTMETHODS',
            'name_ar' => 'إضافة طريقة دفع',
            'group' => 'طرق الدفع',
        ]);
        Permission::create([
            'name' => 'UPDATE_PAYMENTMETHODS',
            'name_ar' => 'تعديل طريقة دفع',
            'group' => 'طرق الدفع',
        ]);
        Permission::create([
            'name' => 'DELETE_PAYMENTMETHODS',
            'name_ar' => 'حذف طريقة دفع',
            'group' => 'طرق الدفع',
        ]);

        // CATEGORIES
        Permission::create([
            'name' => 'VIEW_CATEGORIES',
            'name_ar' => 'عرض التصنيفات',
            'group' => 'التصنيفات',
        ]);
        Permission::create([
            'name' => 'CREATE_CATEGORIES',
            'name_ar' => 'إضافة تصنيف',
            'group' => 'التصنيفات',
        ]);
        Permission::create([
            'name' => 'UPDATE_CATEGORIES',
            'name_ar' => 'تعديل تصنيف',
            'group' => 'التصنيفات',
        ]);
        Permission::create([
            'name' => 'DELETE_CATEGORIES',
            'name_ar' => 'حذف تصنيف',
            'group' => 'التصنيفات',
        ]);

        // REGIONS
        Permission::create([
            'name' => 'VIEW_REGIONS',
            'name_ar' => 'عرض المناطق',
            'group' => 'المناطق',
        ]);
        Permission::create([
            'name' => 'CREATE_REGIONS',
            'name_ar' => 'إضافة منطقة',
            'group' => 'المناطق',
        ]);
        Permission::create([
            'name' => 'UPDATE_REGIONS',
            'name_ar' => 'تعديل منطقة',
            'group' => 'المناطق',
        ]);
        Permission::create([
            'name' => 'DELETE_REGIONS',
            'name_ar' => 'حذف منطقة',
            'group' => 'المناطق',
        ]);

        // INFOS
        Permission::create([
            'name' => 'VIEW_INFOS',
            'name_ar' => 'عرض معلومات التواصل',
            'group' => 'معلومات التواصل',
        ]);
        Permission::create([
            'name' => 'UPDATE_INFOS',
            'name_ar' => 'تعديل معلومات التواصل',
            'group' => 'معلومات التواصل',
        ]);

        // SETTINGS
        Permission::create([
            'name' => 'VIEW_SETTINGS',
            'name_ar' => 'عرض الإعدادات',
            'group' => 'الإعدادات',
        ]);
        Permission::create([
            'name' => 'UPDATE_SETTINGS',
            'name_ar' => 'تعديل الإعدادات',
            'group' => 'الإعدادات',
        ]);
    }
}
