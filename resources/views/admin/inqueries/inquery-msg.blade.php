<div class="modal-header">
    <h5 class="modal-title" id="inqueryModalLabel">{{ $inquery->msg_subject }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" id="inquery-content">
    {{ $inquery->message }}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق النافذة</button>
    @if($inquery->deleted_at == null)
    <button type="button" class="btn btn-primary read-as-mark" data-inquery-id="{{ $inquery->id }}">علامة كمقروء</button>
    @endif
</div>