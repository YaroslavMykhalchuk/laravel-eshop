<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Categories')]
class CategoryIndexComponent extends Component
{

    public function deleteCategory(Category $category): void
    {
        $categories_cnt = Category::query()
            ->where('parent_id', $category->id)
            ->count();

        if ($categories_cnt) {
            $this->js("toastr.error('Error! Category has child categories.');");
            return;
        }

        $products_cnt = Product::query()
            ->where('category_id', $category->id)
            ->count();
        if ($products_cnt) {
            $this->js("toastr.error('Error! Category has products.');");
            return;
        }

        try {
            DB::beginTransaction();

            DB::table('category_filters')
                ->where('category_id', $category->id)
                ->delete();
            $category->delete();

            DB::commit();

            cache()->forget('categories_html');
            $this->js("toastr.success('Category deleted successfully.');");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error deleting category.');");
        }
    }

    public function render()
    {
        return view('livewire.admin.category.category-index-component');
    }
}
