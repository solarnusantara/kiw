<tr>
    <td style="padding-left: {{ $level * 20 }}px;">{{ str_repeat('-', $level) }} {{ $category['name'] }}</td>
    <td>{{ $category['id'] }}</td>
</tr>
@if (!empty($category['children']))
    @foreach ($category['children'] as $child)
        @include('backend.downloads.child', ['category' => $child ,'level' => $level + 1])
    @endforeach
@endif