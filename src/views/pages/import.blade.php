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
                    <td>{{ link_to_action('Boyhagemann\Pages\Controller\PagesController@importOne', 'Import', array($route['path']), array('class' => 'btn btn-info')) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no pages to import
@endif