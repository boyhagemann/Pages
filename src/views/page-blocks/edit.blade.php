<h1>Edit Content</h1>

{{ Form::model($pageblock, array('method' => 'PATCH', 'route' => array('cms.pageblocks.update', $pageblock->id))) }}
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
            {{ Form::label('defaults', 'Defaults:') }}
            {{ Form::textarea('defaults') }}
        </li>
        
        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('cms.pages.content', 'Cancel', $pageblock->page->id, array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif