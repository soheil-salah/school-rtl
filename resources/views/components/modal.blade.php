<button class="btn me-1 mb-1 {{ isset($btnColor) ? $btnColor : 'btn-primary' }} {{ isset($btnTitleColor) ? $btnTitleColor : null }} btn-lg px-4 fs-4 font-medium {{ isset($btnClass) ? $btnClass : null }}" data-bs-toggle="modal" data-bs-target="#{{ isset($id) ? $id : 'bs-example-modal-xlg' }}" {!! isset($data) ? $data : null !!}>
    {{ $btn }}
    @isset($icon)
        {!! $icon !!}
    @endisset
</button>

<!-- sample modal content -->
<div class="modal fade" id="{{ isset($id) ? $id : 'bs-example-modal-xlg' }}" {!! isset($tabindex) && $tabindex == false ? null : 'tabindex="-1"' !!} aria-labelledby="{{ isset($id) ? $id : 'bs-example-modal-xlg' }}" aria-hidden="true">
    <div class="modal-dialog {{ isset($size) ? $size : null }}">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    {{ $modal }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{ $slot }}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
