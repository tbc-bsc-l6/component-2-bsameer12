<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\Orders;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function invoicePdf(Orders $order, InvoiceService $invoiceService)
    {
        return $invoiceService->createInvoice($order)->stream();
    }

    public function invoice(Orders $order)
    {
        return view('livewire.invoice', compact('order'));
    }

    public function render()
    {
        $user = Auth::user();

        $orders = Orders::with('orderItems')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.dashboard', compact('orders'));
    }

}