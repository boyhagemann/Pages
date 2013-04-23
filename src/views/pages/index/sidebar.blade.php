<h1>All Pages in sidebar</h1>

<p>{{ link_to_route('cms.pages.create', 'Add new page') }}</p>

@if ($pages->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
				<th>Path</th>
				<th>Title</th>
				<th>Layout</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pages as $page)
                <tr>
                    <td>{{ $page->name }}</td>
					<td>{{ $page->path }}</td>
					<td>{{ $page->title }}</td>
					<td>{{ $page->layout }}</td>
                    <td>{{ link_to_route('cms.pages.edit', 'Edit', array($page->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('cms.pages.destroy', $page->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages
@endif