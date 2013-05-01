<h1><a href="{{ URL::route('cms.pages.index') }}">Page &raquo;</a> {{ $page->title }} </h1>

<br><br>


<ul class="nav nav-tabs">
    <li class="active"><a href="{{ URL::route('cms.pages.content', $page->id) }}"><i class="icon-th-list"></i> Content</a></li>
    <li><a href="{{ URL::route('cms.pages.edit', $page->id) }}"><i class="icon-wrench"></i> Properties</a></li>
    <li><a href="{{ URL::route('cms.pages.delete', $page->id) }}"><i class="icon-trash"></i> Delete</a></li>
</ul>
@foreach($zones as $zone)
<section>
    <h3>{{ $zone->title }}</h3>
    <a href="{{ URL::route('cms.pageblocks.create') }}" class="btn">Add content</a>
    @if(isset($content[$zone->name]))
    @foreach($content[$zone->name] as $content)
    <blockquote class="block">
        <p>{{ $content->block->title }}</p>
        <small>{{ $content->block->action }}</small>
        <div class="btn-group">
            <a href="{{ URL::route('cms.pageblocks.edit', array($content->id)) }}" class="btn btn-mini btn-primary">Edit</a>
            <a href="" class="btn btn-mini">Remove</a>
        </div>
    </blockquote>
    @endforeach
    @endif
</section>
@endforeach