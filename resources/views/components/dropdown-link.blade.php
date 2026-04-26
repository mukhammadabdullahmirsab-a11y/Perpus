@php
    $defaultStyle = 'color: var(--dropdown-text);';
    $passedStyle = $attributes->get('style', '');
    $finalStyle = $passedStyle ? $passedStyle : $defaultStyle;
@endphp
<a {{ $attributes->except('style')->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 transition duration-150 ease-in-out cursor-pointer']) }}
   style="{{ $finalStyle }}"
   onmouseover="this.style.background='var(--bg-hover)'"
   onmouseout="this.style.background='transparent'">{{ $slot }}</a>
