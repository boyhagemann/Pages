<h1>Blocks</h1>

<br><br>

<ul class="nav nav-tabs">
    <li><a href="{{ URL::route('cms.blocks.index') }}"><i class="icon-th-list"></i> Overview</a></li>
    <li class="active"><a href="{{ URL::route('cms.blocks.create') }}"><i class="icon-plus-sign"></i> Create new block</a></li>
    <li><a href=""><i class="icon-download-alt"></i> Import blocks</a></li>
</ul>


{{ Form::open(['route' => 'cms.blocks.store']) }}
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


