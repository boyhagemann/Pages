<h2>Overview</h2>

<table class="table table-striped">
	<tr>
		<thead>
		@foreach($overview->labels() as $label)
		<th>{{ $label }}</th>
		@endforeach
		<th></th>
		</thead>
	</tr>
	<tbody>
	@foreach($overview->rows() as $id => $row)
	<tr>
		@foreach($row->columns() as $column)
		<td>{{ $column }}</td>
		@endforeach
		<td class="col-4">
			{{ Form::open(array('route' => array($route . '.destroy', $id), 'method' => 'DELETE')) }}
			<a href="{{ URL::route($route . '.edit', $id) }}" class="btn btn-small btn-primary">Properties</a>
			<a href="{{ URL::route('admin.content', $id) }}" class="btn btn-small btn-primary">Content</a>
			{{ Form::submit('Delete', array('class' => 'btn btn-small')) }}
			{{ Form::close() }}
		</td>
	</tr>
	@endforeach
	</tbody>
</table>

{{ $overview->links() }}

<div>
	<a href="{{ URL::route($route . '.create') }}">Create</a>
</div>
