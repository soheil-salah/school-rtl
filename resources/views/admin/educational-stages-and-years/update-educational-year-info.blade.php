<div class="modal-header d-flex align-items-center">
    <h4 class="modal-title" id="updateEducationalYearInfoModalLabel">
        {{ $educationalYear->name }}
    </h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="update-education-year">
    {{ csrf_field() }}
    <input type="hidden" name="education_year_id" value="{{$educationalYear->id}}">
    <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-4">
                    <label for="order">الترتيب</label>
                    <input type="number" class="form-control" name="order" id="order" pattern="[0-9]+" value="{{$educationalYear->order}}">
                </div>
                <div class="col-4">
                    <label for="education_year_name">اسم السنة الدراسية</label>
                    <input type="text" class="form-control" name="education_year_name" id="education_year_name" value="{{$educationalYear->name}}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger ml-2" data-bs-dismiss="modal">غلق النافذة</button>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
</form>