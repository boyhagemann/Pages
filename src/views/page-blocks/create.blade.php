<h1>Add content</h1>

{{ Form::open(['route' => 'cms.pageblocks.store']) }}
    <ul>
        
        @if($page)
        {{ Form::hidden('page_id', $page) }}
        @else
        <li>
            {{ Form::label('page_id', 'Page:') }}
            {{ Form::modelSelect('page_id', 'Boyhagemann\Pages\Model\Page') }}
        </li>
        @endif

        @if($page)
        {{ Form::hidden('zone_id', $zone) }}
        @else
        <li>
            {{ Form::label('zone_id', 'Zone:') }}
            {{ Form::modelSelect('zone_id', 'Boyhagemann\Pages\Model\Zone') }}
        </li>
        @endif
        
        <li>
            {{ Form::label('block_id', 'Block:') }}
            {{ Form::modelSelect('block_id', 'Boyhagemann\Pages\Model\Block', array(
                'query' => function($q) {
                    $q->where('available', '=', true);
                }
            )) }}
        </li>

        @if($position)
        {{ Form::hidden('position', $position) }}
        @else
        <li>
            {{ Form::label('position', 'Position:') }}
            {{ Form::text('position') }}
        </li>        
        @endif

        <li>
            {{ Form::label('defaults', 'Defaults:') }}
            {{ Form::textarea('defaults') }}
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


