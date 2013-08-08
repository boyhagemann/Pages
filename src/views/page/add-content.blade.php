
{{ Form::open(array('route' => array('admin.pages.content.store', $page->id, $block->id))) }}
{{ Form::renderFields($form) }}
{{ Form::submit('Add') }}
{{ Form::close() }}