<?php

namespace App\Livewire\Admin\Filter;

use App\Models\Filter;
use App\Models\FilterGroup;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Create Filter')]
class FilterCreateComponent extends Component
{
    public string $title;
    public $filter_group_id;

    public function save()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255|unique:filters,title',
            'filter_group_id' => 'required|integer|exists:filter_groups,id',
        ]);

        Filter::query()->create($validated);
        session()->flash('success', 'Filter created successfully.');
        $this->redirectRoute('admin.filters.index', navigate: true);
    }

    public function render()
    {
        $filter_groups = FilterGroup::all();

        return view('livewire.admin.filter.filter-create-component', [
            'filter_groups' => $filter_groups,
        ]);
    }
}
