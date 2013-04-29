<h1>All Pages</h1>

<p>
    {{ link_to_route('cms.pages.create', 'Add new page') }} | 
    {{ link_to_route('pages.import', 'Import') }}

</p>

@if ($pages->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
				<th>Title</th>
                <th>Name</th>
				<th>Path</th>
				<th>Layout</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pages as $page)
                <tr>
					<td>{{ $page->title }}</td>
                    <td>{{ $page->name }}</td>
					<td>{{ $page->path }}</td>
					<td>{{ $page->layout->title }}</td>
                    <td>{{ link_to_route('cms.pages.content', 'Content', array($page->id), array('class' => 'btn btn-info btn-small')) }}</td>
                    <td>{{ link_to_route('cms.pages.edit', 'Properties', array($page->id), array('class' => 'btn btn-info btn-small')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('cms.pages.destroy', $page->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-small')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages
@endif