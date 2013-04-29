<h1>Edit Block</h1>

{{ Form::model($block, array('method' => 'PATCH', 'route' => array('cms.blocks.update', $block->id))) }}
    <ul>

        <li>
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title') }}
        </li>
        
        <li>
            {{ Form::label('action', 'Uses:') }}
            {{ Form::text('action') }}
        </li>

        <li>
            {{ Form::label('available', 'Available:') }}
            {{ Form::checkbox('available') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('cms.blocks.show', 'Cancel', $block->id, array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif