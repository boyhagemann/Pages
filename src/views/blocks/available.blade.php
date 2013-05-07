<h2>Available blocks</h2>

<p>
    {{ link_to_route('cms.blocks.create', 'Add new block') }} | 
</p>

@if ($blocks->count())    
<ul class="">
@foreach ($blocks as $block)
    <li>
        <a href="">{{ $block->title }}</a>
    </li>
@endforeach
</ul>
@else
    There are no available blocks
@endif