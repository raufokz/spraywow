@switch($name)
    @case('dashboard')
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M4 13h7V4H4v9Z"></path>
            <path d="M13 20h7v-7h-7v7Z"></path>
            <path d="M13 4h7v5h-7V4Z"></path>
            <path d="M4 20h7v-5H4v5Z"></path>
        </svg>
        @break
    @case('products')
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M6 7 12 4l6 3-6 3-6-3Z"></path>
            <path d="M6 7v10l6 3 6-3V7"></path>
            <path d="m12 10 6-3"></path>
        </svg>
        @break
    @case('categories')
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M4 6h7v7H4V6Z"></path>
            <path d="M13 6h7v7h-7V6Z"></path>
            <path d="M4 15h7v5H4v-5Z"></path>
            <path d="M13 15h7v5h-7v-5Z"></path>
        </svg>
        @break
    @case('orders')
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M8 7h8"></path>
            <path d="M8 11h8"></path>
            <path d="M8 15h5"></path>
            <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"></path>
        </svg>
        @break
    @case('blog')
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M5 5.5A2.5 2.5 0 0 1 7.5 3H19v18H7.5A2.5 2.5 0 0 0 5 23V5.5Z"></path>
            <path d="M8 7h8"></path>
            <path d="M8 11h8"></path>
            <path d="M8 15h5"></path>
        </svg>
        @break
    @case('customers')
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M16 19a4 4 0 0 0-8 0"></path>
            <path d="M12 13a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path>
            <path d="M18 8a3 3 0 1 1 0 6"></path>
        </svg>
        @break
    @default
        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
            <path d="M12 3v3"></path>
            <path d="M12 18v3"></path>
            <path d="M4.9 4.9 7 7"></path>
            <path d="m17 17 2.1 2.1"></path>
            <path d="M3 12h3"></path>
            <path d="M18 12h3"></path>
            <path d="m4.9 19.1 2.1-2.1"></path>
            <path d="M17 7 19.1 4.9"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
@endswitch
