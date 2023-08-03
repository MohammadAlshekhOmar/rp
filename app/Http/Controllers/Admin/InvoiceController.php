<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(InvoiceService $invoiceService)
    {
        $invoices = $invoiceService->all();
        $title = __('locale.invoices');
        $model = 'Invoice';
        $deleteRoute = route('admin.invoices.delete');

        return view('Admin.SubViews.Invoice.index', [
            'invoices' => $invoices,
            'title' => $title,
            'model' => $model,
            'deleteRoute' => $deleteRoute,
        ]);
    }

    public function show(Request $request, InvoiceService $invoiceService)
    {
        $page = 'معلومات الفاتورة';
        $menu = __('locale.invoices');
        $menu_link = route('admin.invoices.index');

        $invoice = $invoiceService->find($request->id);
        return view('Admin.SubViews.Invoice.show', [
            'invoice' => $invoice,
            'page' => $page,
            'menu' => $menu,
            'menu_link' => $menu_link
        ]);
    }
}
