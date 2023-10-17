<div class="card w-100 position-relative overflow-hidden mb-0">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold">المعلومات الشخصية</h5>
        <form method="post" action="{{ route('admin.password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')
            
            <div class="row">
                <div class="col-4">
                    <label for="current_password">كلمة السر الحالية</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" autocomplete="current-password">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>
                <div class="col-4">
                    <label for="password">كلمة السر الجديدة</label>
                    <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>
                <div class="col-4">
                    <label for="password_confirmation">تاكيد كلمة السر</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="flex items-center gap-4">
                        <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                            <button class="btn btn-primary">تحديث</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
