<h1>Edit Page</h1>

<ul class="nav nav-tabs">
    <li><a href="{{ URL::route('cms.pages.edit', $page->id) }}">Properties</a></li>
    <li class="active"><a href="{{ URL::route('cms.pageblocks.edit', $page->id) }}">Content</a></li>
</ul>

@foreach($zones as $zone)
<section>
    <h3>{{ $zone->title }}</h3>
    @if(isset($content[$zone->name]))
    @foreach($content[$zone->name] as $content)
    <blockquote class="block">
        <p>{{ $content->block->title }}</p>
        <small>{{ $content->block->action }}</small>
        <div class="btn-group">
            <a href="" class="btn btn-mini btn-primary">Edit</a>
            <a href="" class="btn btn-mini">Remove</a>
        </div>
    </blockquote>
    @endforeach
    @endif
</section>
@endforeach