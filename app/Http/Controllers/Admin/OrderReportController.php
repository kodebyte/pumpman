<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\OrderRepositoryInterface;
use App\Exports\OrderExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderReportController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepo
    ) {}

    public function index(
        Request $request
    )
    {
        $orders = collect();
        
        if ($request->has('start_date')) {
            $orders = $this->orderRepo->getReportData($request->all());
        }

        return view('admin.pages.report.order.wizard', compact('orders'));
    }

    public function export(
        Request $request
    )
    {
        $orders = $this->orderRepo->getReportData($request->all());
        $fileName = 'order-report-' . $request->start_date . '-to-' . $request->end_date . '.xlsx';

        return Excel::download(new OrderExport($orders), $fileName);
    }
}