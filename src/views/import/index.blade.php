<h1>Import Pages</h1>

<a href="{{ URL::route('pages.import.all') }}" class="btn btn-primary">Import all</a>

@if ($routes)
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
				<th>Path</th>
				<th>Uses</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($routes as $name => $route)
                <tr>
					<td>{{ $route->getPath() }}</td>
					<td>{{ $route->getOption('_uses') }}</td>
                    <td>
                        {{ Form::open(array('method' => 'POST', 'route' => 'pages.import.page')) }}
                            {{ Form::hidden('name', $name) }}
                            {{ Form::submit('Import', array('class' => 'btn')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages to import
@endif