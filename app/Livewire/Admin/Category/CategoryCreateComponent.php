<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Create Category')]
class CategoryCreateComponent extends Component
{
    public string $title;
    public int $parent_id = 0;

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|max:255',
            'parent_id' => 'required|integer',
        ]);

        $category = Category::query()->create($validated);

        cache()->forget('categories_html');
        session()->flash('success', 'Category created successfully.');
        $this->redirectRoute('admin.categories.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.category.category-create-component');
    }
}
