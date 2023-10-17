<form {{ $attributes }}>
    {{ csrf_field() }}

    {{ $slot }}

    <hr>
    
    @if(isset($submit))
    <button type="submit" {!! isset($submitAttrs) ? $submitAttrs : null !!}>
        {{ isset($submitTitle) ? $submitTitle : 'Save' }}
    </button>
    @endif

    @if(isset($reset))
    <button type="reset" {!! isset($resetAttrs) ? $resetAttrs : null !!}>
        {{ isset($resetTitle) ? $resetTitle : 'Reset' }}
    </button>
    @endif

    @if(isset($button))
    <button type="button" {!! isset($buttonAttrs) ? $buttonAttrs : null !!}>
        {{ isset($btnTitle) ? $btnTitle : 'Click' }}
    </button>
    @endif

</form>