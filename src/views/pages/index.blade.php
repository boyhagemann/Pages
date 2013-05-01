<div class="btn-group-hover">
    <h1>Pages</h1>
    <div class="btn-group">
        <a href="{{ URL::route('cms.pages.create') }}" class="btn">Add new page</a>
        <a href="{{ URL::route('pages.import') }}" class="btn">Import</a>
    </div>
</div>

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