{{-- One labelled form row. Expects: name, label, and either $input (html) or type/value. --}}
<div class="form-group row">
    <label for="f_{{ $name }}" class="col-sm-3 col-form-label">{{ $label }}</label>
    <div class="col-sm-9">
        @if (($type ?? 'text') === 'select')
            <select name="{{ $name }}" id="f_{{ $name }}" class="form-control">
                @foreach ($options as $value => $text)
                    <option value="{{ $value }}" @selected(old($name, $value_) == $value)>{{ $text }}</option>
                @endforeach
            </select>
        @elseif (($type ?? 'text') === 'textarea')
            <textarea name="{{ $name }}" id="f_{{ $name }}" class="form-control" rows="{{ $rows ?? 4 }}" @if ($plain ?? false) data-plain @endif>{{ old($name, $value_) }}</textarea>
        @else
            <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="f_{{ $name }}" class="form-control" value="{{ old($name, $value_) }}" @isset($min) min="{{ $min }}" @endisset @isset($placeholder) placeholder="{{ $placeholder }}" @endisset>
        @endif
        @isset($help)<small class="text-muted">{{ $help }}</small>@endisset
        @error($name)<div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
</div>
