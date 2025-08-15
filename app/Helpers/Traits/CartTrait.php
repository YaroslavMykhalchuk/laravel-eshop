<?php

namespace App\Helpers\Traits;

use App\Helpers\Cart\Cart;

trait CartTrait
{

    public $quantity = 1;
    public function add2Cart(int $productId, $quantity = false)
    {
        $quantity = $quantity ? (int)$this->quantity : 1;
        if($quantity < 1) {
            $quantity = 1;
        }
        if(Cart::add2Cart($productId, $quantity)) {
            $this->js("toastr.success('Product added to cart successfully!')");
            $this->dispatch('cart-updated');
        } else {
            $this->js("toastr.error('Oops! Something went wrong!')");
        }
    }

    public function removeFromCart(int $productId)
    {
        if(Cart::removeProductFromCart($productId)) {
            $this->js("toastr.success('Product removed from cart successfully!')");
            $this->dispatch('cart-updated');
        } else {
            $this->js("toastr.error('Oops! Something went wrong!')");
        }

    }
}
