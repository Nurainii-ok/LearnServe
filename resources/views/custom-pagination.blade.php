{{-- CUSTOM PAGINATION LOADED SUCCESSFULLY --}}
<!-- DEBUG: Custom pagination is working -->
@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center">
        <ul class="pagination" style="margin: 0;">
            {{-- Previous Number --}}
            @if ($paginator->currentPage() -1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->currentPage() - 1) }}" 
                       style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd; margin: 0 2px; border-radius: 6px;">
                        {{ $paginator->currentPage() - 1 }}
                    </a>
                </li>
            @endif

            {{-- Current Page --}}
            <li class="page-item active">
                <span class="page-link" 
                      style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: #944e25; border: 1px solid #944e25; color: white; margin: 0 2px; border-radius: 6px;">
                    {{ $paginator->currentPage()  }}
                </span>
            </li>

            {{-- Next Number --}}
            @if ($paginator->currentPage() < $paginator->lastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->currentPage() + 1) }}" 
                       style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd; margin: 0 2px; border-radius: 6px;">
                        {{ $paginator->currentPage() + 1 }}
                    </a>
                </li>
            @endif

            {{-- Show more pages if needed --}}
            @if ($paginator->lastPage() > 3 && $paginator->currentPage() < $paginator->lastPage() - 1)
                <li class="page-item">
                    <span style="padding: 8px 4px;">...</span>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" 
                       style="font-size: 14px; padding: 8px 12px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; text-decoration: none; border: 1px solid #ddd; margin: 0 2px; border-radius: 6px;">
                        {{ $paginator->lastPage() }}
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
