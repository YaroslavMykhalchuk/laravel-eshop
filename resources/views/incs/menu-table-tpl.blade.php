<tr wire:key="{{ $item['id'] }}">
    <td>{{ $item['id'] }}</td>
    <td><span style="padding-left: {{ strlen($tab) * 3 }}px;">{{ $tab . $item['title'] }}</span></td>
    <td>
        <a class="btn btn-info btn-circle" href="{{ route('category', $item['slug']) }}" wire:navigate>
            <i class="fa-solid fa-eye"></i>
        </a>
        <a class="btn btn-warning btn-circle" href="{{ route('admin.categories.edit', $item['id']) }}" wire:navigate>
            <i class="fa-solid fa-pen"></i>
        </a>
        <button class="btn btn-danger btn-circle" wire:click="deleteCategory({{ $item['id'] }})" wire:confirm="Are you sure?" wire:loading.attr="disabled">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

@if(isset($item['children']))
    {!! \App\Helpers\Category\Category::getHtml($item['children'], "$tab - ") !!}
@endif
