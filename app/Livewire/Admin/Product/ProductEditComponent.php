<?php

namespace App\Livewire\Admin\Product;

use App\Helpers\Traits\HasCategoryFilters;
use App\Models\Filter;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Edit Product')]
class ProductEditComponent extends Component
{

    use WithFileUploads, HasCategoryFilters;

    public Product $product;
    public string $title;
    public $category_id;
    public array $selectedFilters = [];
    public int $price = 0;
    public int $old_price = 0;
    public bool $is_hit = false;
    public bool $is_new = false;
    public ?string $excerpt;
    public string $content;
    public $photo;
    public $photos;
    #[Validate]
    public $image;
    #[Validate]
    public $gallery;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->title = $product->title;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->old_price = $product->old_price;
        $this->is_hit = $product->is_hit;
        $this->is_new = $product->is_new;
        $this->excerpt = $product->excerpt;
        $this->content = $product->content;
        $this->photo = $product->image;
        $this->photos = $product->gallery;
        $this->selectedFilters = DB::table('filter_products')
            ->where('product_id', '=', $this->product->id)
            ->pluck('filter_id')
            ->toArray();
    }

    public function updatedCategoryId()
    {
        $this->selectedFilters = [];
    }

    #[Computed]
    public function filters()
    {
        return $this->getCategoryFilters($this->category_id);
    }

    protected function rules()
    {
        return [
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'selectedFilters.*' => 'numeric',
            'price' => 'required|integer',
            'old_price' => 'integer',
            'is_hit' => 'boolean',
            'is_new' => 'boolean',
            'excerpt' => 'nullable|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        $folders = date('Y') . '/' . date('m') . '/' . date('d');
        if (!empty($validated['image'])) {
            $validated['image'] = "uploads/" . $validated['image']->store($folders);
        } else {
            $validated['image'] = $this->photo;
        }

        if (!empty($validated['gallery'])) {
            foreach ($validated['gallery'] as $k => $photo) {
                $validated['gallery'][$k] = "uploads/" . $photo->store($folders);
            }
            $validated['gallery'] = array_merge($validated['gallery'], $this->photos);
        } else {
            $validated['gallery'] = $this->photos;
        }

        try {
            DB::beginTransaction();

            $this->product->update($validated);
            DB::table('filter_products')
                ->where('product_id', '=', $this->product->id)
                ->delete();

            if (!empty($validated['selectedFilters'])) {
                $filter_groups = Filter::query()
                    ->whereIn('id', $validated['selectedFilters'])->get();
                $data = [];
                foreach ($filter_groups as $filter_group) {
                    $data[] = [
                        'filter_id' => $filter_group->id,
                        'product_id' => $this->product->id,
                        'filter_group_id' => $filter_group->filter_group_id,
                    ];
                }
                DB::table('filter_products')->insert($data);
            }

            DB::commit();
            session()->flash('success', 'Product updated successfully');
            $this->redirectRoute('admin.products.index', navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error updating product')");
        }
    }

    public function deleteGalleryItem($id)
    {
        if (isset($this->photos[$id])) {
            unset($this->photos[$id]);
        }
    }

    public function render()
    {
        return view('livewire.admin.product.product-edit-component');
    }
}
