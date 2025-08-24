<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use App\Models\Product;
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

        $category->delete();
        cache()->forget('categories_html');
        $this->js("toastr.success('Category deleted successfully.');");
    }

    public function render()
    {
        return view('livewire.admin.category.category-index-component');
    }
}
