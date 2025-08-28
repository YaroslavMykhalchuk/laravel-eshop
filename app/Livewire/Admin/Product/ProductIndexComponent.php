<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Products')]
class ProductIndexComponent extends Component
{
    use WithPagination;

    public function deleteProducts(Product $product)
    {
        try {
            DB::beginTransaction();

            DB::table('filter_products')
                ->where('product_id', $product->id)
                ->delete();
            if($product->image){
                Storage::disk('public_uploads_delete')->delete($product->image);
            }
            if($gallery = $product->gallery){
                Storage::disk('public_uploads_delete')->delete($gallery);
            }
            $product->delete();

            DB::commit();

            session()->flash('success', 'Product has been deleted.');
            return;
        } catch (\Exception $e)
        {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error deleting product')");

        }
    }

    public function render()
    {
        $products = Product::query()
            ->with(['category'])
            ->orderBy('id', 'desc')
            ->paginate();

        return view('livewire.admin.product.product-index-component', [
            'products' => $products
        ]);
    }
}
