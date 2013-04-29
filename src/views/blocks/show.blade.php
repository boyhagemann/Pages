<h1>Show Block</h1>

<p>{{ link_to_route('cms.blocks.index', 'Return to all blocks') }}</p>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Uses</th>
            <th>Available</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>{{ $block->title }}</td>
            <td>{{ $block->action }}</td>
            <td>{{ $block->available }}</td>
            <td>{{ link_to_route('cms.blocks.edit', 'Edit', array($block->id), array('class' => 'btn btn-info')) }}</td>
            <td>
                {{ Form::open(array('method' => 'DELETE', 'route' => array('cms.blocks.destroy', $block->id))) }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
    </tbody>
</table>