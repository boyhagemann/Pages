<h1>Pages</h1>

<br><br>

<ul class="nav nav-tabs">
    <li><a href="{{ URL::route('cms.pages.index') }}"><i class="icon-th-list"></i> Overview</a></li>
    <li><a href="{{ URL::route('cms.pages.create') }}"><i class="icon-plus-sign"></i> Create new page</a></li>
    <li class="active"><a href="{{ URL::route('pages.import') }}"><i class="icon-download-alt"></i> Import pages</a></li>
</ul>

@if ($routes)

    <p>
        <a href="{{ URL::route('pages.import.all') }}" class="btn btn-primary"><i class="icon-download-alt"></i> Import all</a>
    </p>

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
