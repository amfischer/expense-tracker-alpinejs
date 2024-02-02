@props(['disabled' => false, 'options' => [], 'name' => ''])

<select {{ $disabled ? 'disabled' : '' }} name="{{$name}}" {!! $attributes->merge(['class' => 'form-input']) !!}>
    @foreach ($options as $key => $opt)
        <option value="{{$key}}" {{ old($name) == $key ? 'selected' : '' }}>{{$opt}}</option>
    @endforeach
</select>
