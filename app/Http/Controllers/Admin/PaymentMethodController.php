<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\PaymentMethodRepositoryInterface;
use App\Http\Requests\Admin\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\Admin\PaymentMethod\UpdatePaymentMethodRequest;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function __construct(
        protected PaymentMethodRepositoryInterface $repository
    ) {}

    public function index(Request $request)
    {
        $params = $request->only([
            'search', 
            'is_active', 
            'sort', 
            'direction'
        ]);

        $paymentMethods = $this->repository->getAll($params);

        return view('admin.pages.payment-method.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.pages.payment-method.create');
    }

    public function store(
        StorePaymentMethodRequest $request
    )
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('payment-methods', 'public');
        }

        $this->repository->create($data);

        return to_route('admin.payment-methods.index')
                ->with('success', 'Payment method created successfully.');
    }

    public function edit(int $id)
    {
        $paymentMethod = $this->repository->findById($id);
        return view('admin.pages.payment-method.edit', compact('paymentMethod'));
    }

    public function update(
        UpdatePaymentMethodRequest $request, 
        string $id
    )
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('payment-methods', 'public');
        }

        $this->repository->update($id, $data);

        return to_route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(
        string $id
    )
    {
        $this->repository->delete($id);

        return to_route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}