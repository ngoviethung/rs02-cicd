<!-- select -->
@php
	$current_value = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';
    $entity_model = $crud->getRelationModel($field['entity'],  - 1);

    if (!isset($field['options'])) {
        $options = $field['model']::all();
    } else {
        $options = call_user_func($field['options'], $field['model']::query());
    }
    
    $categories = App\Models\Category::all();        
@endphp

<div @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <select
        name="{{ $field['name'] }}"
        @include('crud::inc.field_attributes')
        >

        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif

        @if (count($categories))
        <optgroup label="Sleep">
          @foreach ($categories as $connected_entity_entry)
            @if($connected_entity_entry->type == 'sleep')
                @if($current_value == $connected_entity_entry->id)
                    <option value="{{ $connected_entity_entry->id }}" selected>{{ $connected_entity_entry->name }}</option>
                @else
                    <option value="{{ $connected_entity_entry->id }}">{{ $connected_entity_entry->name }}</option>
                @endif
            @endif
            @endforeach
          </optgroup>
         
          <optgroup label="Meditate">
             @foreach ($categories as $connected_entity_entry)
             @if($connected_entity_entry->type == 'meditate')
                @if($current_value == $connected_entity_entry->id)
                    <option value="{{ $connected_entity_entry->id }}" selected>{{ $connected_entity_entry->name }}</option>
                @else
                    <option value="{{ $connected_entity_entry->id }}">{{ $connected_entity_entry->name }}</option>
                @endif
             @endif
            @endforeach
          </optgroup>
          <optgroup label="Music">
             @foreach ($categories as $connected_entity_entry)
             @if($connected_entity_entry->type == 'music')
                @if($current_value == $connected_entity_entry->id)
                    <option value="{{ $connected_entity_entry->id }}" selected>{{ $connected_entity_entry->name }}</option>
                @else
                    <option value="{{ $connected_entity_entry->id }}">{{ $connected_entity_entry->name }}</option>
                @endif
             @endif
            @endforeach
          </optgroup>
          <optgroup label="Body">
           @foreach ($categories as $connected_entity_entry)
           @if($connected_entity_entry->type == 'body')
                @if($current_value == $connected_entity_entry->id)
                    <option value="{{ $connected_entity_entry->id }}" selected>{{ $connected_entity_entry->name }}</option>
                @else
                    <option value="{{ $connected_entity_entry->id }}">{{ $connected_entity_entry->name }}</option>
                @endif
           @endif
            @endforeach
          </optgroup>
            
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

</div>

