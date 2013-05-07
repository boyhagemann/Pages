<h1>Pages</h1>

<br><br>

<ul class="nav nav-tabs">
    <li class="active"><a href="{{ URL::route('cms.pages.index') }}"><i class="icon-th-list"></i> Overview</a></li>
    <li><a href="{{ URL::route('cms.pages.create') }}"><i class="icon-plus-sign"></i> Create new page</a></li>
    <li><a href="{{ URL::route('pages.import') }}"><i class="icon-download-alt"></i> Import pages</a></li>
</ul>

@if ($pages->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
				<th>Title</th>
				<th>Path</th>
				<th>Layout</th>
				<th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pages as $page)
                <tr>
					<td class="nowrap">{{ $page->title }}</td>
					<td class="nowrap">{{ $page->path }}</td>
					<td class="nowrap">{{ $page->layout->title }}</td>
                    <td class="nowrap">
                        <a href="{{ URL::route('cms.pages.content', array($page->id)) }}" class="btn btn-mini"><i class="icon-list-alt"></i> Content</a>
                        <a href="{{ URL::route('cms.pages.edit', array($page->id)) }}" class="btn btn-mini"><i class="icon-pencil"></i> Properties</a>
                        <a href="{{ URL::route('cms.pages.delete', array($page->id)) }}" class="btn btn-mini"><i class="icon-trash"></i> Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages
@endif