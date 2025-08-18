<?php

namespace App\Helpers\Cart;

use App\Models\Product;

class Cart
{
    public static function add2Cart(int $productId, int $quantity = 1): bool
    {
        $added = false;

        if (self::hasProductInCart($productId)) {
           session(["cart.{$productId}.quantity" => session("cart.{$productId}.quantity") + $quantity ]);
           $added = true;
        }
        else {
            $product = Product::find($productId);
            if ($product) {
                $new_product = [
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'image' => $product->getImage(),
                    'price' => $product->price,
                    'quantity' => $quantity,
                ];
                session(["cart.{$productId}" => $new_product]);
                $added = true;
            }
        }
        return $added;
    }

    public static function removeProductFromCart(int $productId): bool
    {
        if (self::hasProductInCart($productId)) {
            session()->forget("cart.{$productId}");
            return true;
        }
        return false;
    }

    public static function getCart(): array
    {
        return session("cart") ? session("cart") : [];
    }

    public static function clearCart()
    {
        session()->forget("cart");
    }

    public static function getCartTotalSum(): int
    {
        $total = 0;
        foreach (self::getCart() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public static function getCartQuantityItems(): int
    {
        return count(self::getCart());
    }

    public static function getCartQuantityTotal()
    {
        $cart = self::getCart();
        return array_sum(array_column($cart, 'quantity'));
    }

    public static function hasProductInCart(int $productId)
    {
        return session()->has('cart.' . $productId);
    }

    public static function updateItemQuantity(int $productId, int $quantity): bool
    {
        $updated = false;

        if (self::hasProductInCart($productId)) {
            session(["cart.{$productId}.quantity" => $quantity]);
            $updated = true;
        }
        return $updated;
    }

}
