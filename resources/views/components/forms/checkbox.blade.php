@props(['disabled' => false, 'checked' => false, 'name' => ''])

<input 
    type="checkbox" 
    name="{{$name}}" 
    {{ $checked ? 'checked' : '' }} 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600']) !!} />
