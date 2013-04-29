<h1>All blocks</h1>

<p>
    {{ link_to_route('cms.blocks.create', 'Add new block') }} | 
</p>

@if ($blocks->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
				<th>Title</th>
				<th>Uses</th>
				<th>Available</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($blocks as $block)
                <tr>
					<td>{{ $block->title }}</td>
					<td>{{ $block->action }}</td>
					<td>{{ $block->available }}</td>
                    <td>{{ link_to_route('cms.blocks.edit', 'Edit', array($block->id), array('class' => 'btn btn-info btn-small')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('cms.blocks.destroy', $block->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-small')) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    There are no blocks
@endif