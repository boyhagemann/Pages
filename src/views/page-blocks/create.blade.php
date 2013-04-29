<h1>Add content</h1>

{{ Form::open(['route' => 'cms.pageblocks.store']) }}
    <ul>
        
        <li>
            {{ Form::label('page_id', 'Page:') }}
            {{ Form::text('page_id') }}
        </li>

        <li>
            {{ Form::label('zone_id', 'Zone:') }}
            {{ Form::text('zone_id') }}
        </li>

        <li>
            {{ Form::label('block_id', 'Block:') }}
            {{ Form::text('block_id') }}
        </li>

        <li>
            {{ Form::label('position', 'Position:') }}
            {{ Form::text('position') }}
        </li>
        
        <li>
            {{ Form::submit('Submit', array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif


