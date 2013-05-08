<h2>Available blocks</h2>

<p>
    <a href="{{ URL::route('cms.blocks.create') }}"><i class="icon-plus-sign"></i> Add new block</a> &nbsp; &nbsp;  
    <a href="{{ URL::route('cms.blocks.index') }}"><i class="icon-list"></i> Overview</a>
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