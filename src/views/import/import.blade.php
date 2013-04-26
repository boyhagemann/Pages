<h1>Import Pages</h1>

@if ($routes)
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
				<th>Path</th>
				<th>Uses</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($routes as $route)
                <tr>
					<td>{{ $route['path'] }}</td>
					<td>{{ $route['uses']}}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('cms.pages.import', $page->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages to import
@endif