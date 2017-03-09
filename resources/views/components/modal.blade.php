{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100">{{ $title }}</h4>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                {{ $buttons }}
            </div>
        </div>
    </div>
</div>