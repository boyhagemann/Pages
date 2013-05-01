<h1><a href="{{ URL::route('cms.pages.index') }}">Pages &raquo;</a> {{ $page->title }} </h1>

<br><br>


<ul class="nav nav-tabs">
    <li class="active"><a href="{{ URL::route('cms.pages.content', $page->id) }}"><i class="icon-th-list"></i> Content</a></li>
    <li><a href="{{ URL::route('cms.pages.edit', $page->id) }}"><i class="icon-wrench"></i> Properties</a></li>
    <li><a href="{{ URL::route('cms.pages.delete', $page->id) }}"><i class="icon-trash"></i> Delete</a></li>
</ul>

@foreach($zones as $zone)
<section class="btn-group-hover">
    <h3>{{ $zone->title }}</h3>   
    <div class="btn-group">
        <a href="{{ URL::route('cms.pageblocks.create') }}" class="btn"><i class="icon-plus"></i> Add content</a>
    </div> 
</section>
<section class="zone">

    @if(isset($content[$zone->name]))
    @foreach($content[$zone->name] as $pageblock)
    <blockquote class="block btn-group-hover global-{{ $pageblock->block->grlobal }}">
        <p>{{ $pageblock->block->title }}</p>
        <small>{{ $pageblock->block->action }}</small>
        <div class="btn-group">
            <a href="{{ URL::route('cms.pageblocks.edit', array($pageblock->id)) }}" class="btn btn-mini btn-primary"><i class="icon-pencil"></i> Edit</a>
            <a href="" class="btn btn-mini"><i class="icon-trash"></i> Remove</a>
        </div>
    </blockquote>
    @endforeach
    @endif
</section>
@endforeach