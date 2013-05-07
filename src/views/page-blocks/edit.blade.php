<h1>Edit Content</h1>

{{ Form::model($pageblock, array('method' => 'PATCH', 'route' => array('cms.pageblocks.update', $pageblock->id))) }}
    <ul>

        <li>
            {{ Form::label('page_id', 'Page:') }}
            {{ Form::modelSelect('page_id', 'Boyhagemann\Pages\Model\Page') }}
        </li>

        <li>
            {{ Form::label('zone_id', 'Zone:') }}
            {{ Form::modelSelect('zone_id', 'Boyhagemann\Pages\Model\Zone') }}
        </li>

        <li>
            {{ Form::label('block_id', 'Block:') }}
            {{ Form::modelSelect('block_id', 'Boyhagemann\Pages\Model\Block', array(
                'query' => function($q) {
                    $q->where('available', '=', true);
                }
            )) }}
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