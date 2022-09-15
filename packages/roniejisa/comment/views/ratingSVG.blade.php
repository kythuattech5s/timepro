@for ($i = 1; $i <= 5; $i++)
    <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.23503 0.413086L10.6809 5.40725L16.1517 6.21309L12.1934 10.0981L13.1275 15.5864L8.23503 12.9939L3.34253 15.5864L4.27669 10.0981L0.318359 6.21309L5.78836 5.40725L8.23503 0.413086Z" fill="
        @if ($rating->rating >= $i) 
        #F59E0B
        @else
        #D6DAE0 @endif
        " />
    </svg>
@endfor
