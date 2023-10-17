        <div class="card w-100 position-relative overflow-hidden mb-0">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold">المعلومات الشخصية</h5>
                <form method="post" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="my-4">
                                <label for="name" class="form-label fw-semibold">Your Name</label>
                                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="my-4">
                                <label for="email" class="form-label fw-semibold">Your Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="flex items-center gap-4">
                                <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
