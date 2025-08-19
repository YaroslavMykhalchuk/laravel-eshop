<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CheckoutComponent extends Component
{

    public string $name;
    public string $email;
    public string $note;

    public function mount()
    {
        $this->name = auth()->user()->name ?? '';
        $this->email = auth()->user()->email ?? '';
    }

    public function saveOrder()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'note' => 'string|nullable|max:255',
        ]);

        $validated = array_merge($validated, [
            'user_id' => auth()->id(),
            'total' => \App\Helpers\Cart\Cart::getCartTotalSum(),
        ]);

        try {
            DB::beginTransaction();
            $order = Order::query()->create($validated);
            $order_products = [];
            $cart = \App\Helpers\Cart\Cart::getCart();
            foreach ($cart as $product_id => $product) {
                $order_products[] = [
                    'product_id' => $product_id,
                    'title' => $product['title'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'slug' => $product['slug'],
                    'image' => $product['image'],

                ];
            }
            $order->orderProducts()->createMany($order_products2);
            $this->js("toastr.success('Order created successfully!')");
            DB::commit();
        } catch ( \Exception $e ) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error ordering!')");
        }
    }

    public function render()
    {
        return view('livewire.cart.checkout-component');
    }
}
