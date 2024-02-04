@props(['disabled' => false, 'options' => [], 'name' => '', 'value' => ''])

<select {{ $disabled ? 'disabled' : '' }} name="{{$name}}" {!! $attributes->merge(['class' => 'form-input']) !!}>
    @foreach ($options as $key => $opt)
        <option value="{{$key}}" {{ $value === $key ? 'selected' : '' }}>{{$opt}}</option>
    @endforeach
</select>
