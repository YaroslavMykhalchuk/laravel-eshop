<?php

namespace App\Livewire\Admin\Product;

use App\Helpers\Traits\HasCategoryFilters;
use App\Models\Filter;
use App\Models\FilterGroup;
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
#[Title('Create Product')]
class ProductCreateComponent extends Component
{
    use WithFileUploads, HasCategoryFilters;

    public string $title;
    public $category_id;
    public int $price = 0;
    public int $old_price = 0;
    public bool $is_hit = false;
    public bool $is_new = false;
    public array $selectedFilters = [];
    public string $excerpt;
    public string $content;
    #[Validate('nullable|image|mimes:jpeg,png,jpg|max:2048')]
    public $image;
    #[Validate]
    public $gallery;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $folders = date('Y') . '/' . date('m') . '/' . date('d');
        if($validated['image']) {
            $validated['image'] = "uploads/" . $validated['image']->store($folders);
        }
        if(!empty($validated['gallery'])) {
            foreach ($validated['gallery'] as $k => $photo) {
                $validated['gallery'][$k] = "uploads/" . $photo->store($folders);
            }
        }

        try {
            DB::beginTransaction();

            $product = Product::query()
                ->create($validated);

            if(!empty($validated['selectedFilters'])) {
                $filter_groups = Filter::query()
                    ->whereIn('id', $validated['selectedFilters'])
                    ->get();
                $data = [];
                foreach ($filter_groups as $filter_group) {
                    $data[] = [
                        'filter_id' => $filter_group->id,
                        'product_id' => $product->id,
                        'filter_group_id' => $filter_group->filter_group_id,
                    ];
                }
                DB::table('filter_products')->insert($data);
            }

            DB::commit();
            session()->flash('success', 'Product created successfully.');
            $this->redirectRoute('admin.products.index', navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->js("toastr.error('Error saving product');");
        }
    }

    public function render()
    {
        return view('livewire.admin.product.product-create-component');
    }
}
