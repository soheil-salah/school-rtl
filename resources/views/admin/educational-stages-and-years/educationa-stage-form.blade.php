<label for="" class="form-label">السنوات الدراسية</label>
<!-- outer repeater -->
<div class="repeater">
    <div data-repeater-list="educational_years">
    <div data-repeater-item>
        <div class="form-group row mb-3">
            <div class="col-9">
                <input type="text" class="form-control" name="educational_year" required>
            </div>
            <div class="col-3">
                <button type="button" data-repeater-delete class="btn btn-danger btn-sm">مسج</button>
            </div>
        </div>
    </div>
    </div>
    <button type="button" data-repeater-create class="btn btn-primary btn-sm">اضافة حقل جديد</button>
</div>

<script>
$('.repeater').repeater({
    show: function () {
        $(this).slideDown();
    },
    hide: function (deleteElement) {
        if(confirm('Are you sure you want to delete this element?')) {
            $(this).slideUp(deleteElement);
        }
    },
    ready: function (setIndexes) {
    },
    isFirstItemUndeletable: true
});
</script>