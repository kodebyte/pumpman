<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateOrderStatusRequest;
use App\Mail\OrderShipped;
use App\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index(): View
    {
        $params = request()->only([
            'search', 
            'sort', 
            'direction', 
            'status', 
            'payment_status'
        ]);
        
        $perPage = request('limit', 10);
        $orders = $this->orderService->getAll($params, $perPage);
        
        return view('admin.pages.order.index', compact(
            'orders', 
            'perPage'
        ));
    }

    public function show(
        Order $order
    ): View
    {
        $order = $this->orderService->findById($order->id);
        
        return view('admin.pages.order.show', compact('order'));
    }

    public function destroy(
        Order $order
    ): RedirectResponse
    {
        try {
            $this->orderService->delete(
                $order->id
            );
        } catch (\Exception $e) {
            \Log::error('Error delete order: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to delete order.');
        }
        
        return to_route('admin.orders.index')
                ->with('success', 'Order deleted successfully');
    }

    public function updateStatus(
        UpdateOrderStatusRequest $request, 
        Order $order
    ): RedirectResponse
    {
        try {
            $originalStatus = $order->status;

            // Siapkan data update
            $updateData = [
                'status' => $request->status,
                'tracking_number' => $request->tracking_number ?? $order->tracking_number,
            ];

            if ($request->has('courier_id')) {
                $updateData['courier_id'] = $request->courier_id;
            }
            
            // Update Order
            $order->update($updateData);

            // Catat ke History
            $order->histories()->create([
                'employee_id' => auth('employee')->id(),
                'status' => $request->status,
                'notes' => $request->notes ?? "Status changed to " . ucfirst($request->status)
            ]);
        } catch (\Exception $e) {
            \Log::error('Error when update status. ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to update status.');
        }

        try {
            if ($request->status === 'completed' 
                && $originalStatus !== 'completed' 
                && !empty($order->tracking_number)) {
                
                // Pastikan load relasi courier agar tidak error di view email
                $order->load('courier'); 
                
                // Kirim ke Queue
                Mail::to($order->email)->send(new OrderShipped($order));
            }
        } catch (\Exception $th) {
            \Log::error('Error when send order shipped mail');
        }

        return back()
                ->with('success', 'Order status updated successfully');
    }

    public function printInvoice(
        Order $order
    )
    {
        // Kita REUSE view invoice milik user agar hemat kode & konsisten
        // Pastikan path view sesuai dengan file invoice yang sudah Anda punya
        return view('web.pages.order.invoice', compact('order'));
    }

    public function printLabel(
        Order $order
    )
    {
        // Load relasi user/items jika perlu
        return view('admin.pages.order.print-label', compact('order'));
    }
}