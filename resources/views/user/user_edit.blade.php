<div class="modal-content">
    <form id='form1'>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Edit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control"
                        placeholder="Nama" />
                </div>
                <div class="col-6 mb-3">
                    <label for="nameBasic" class="form-label">Role</label>
                    <select class="form-control" name="role" id="role" required>
                        <option value=""> Pilih Role</option>
                        @foreach (Spatie\Permission\Models\Role::where('name', '!=', 'Super-Admin')->get() as $account)
                            <option value="{{ $account->id }}" {{ $user->hasRole($account->name) ? 'selected' : '' }}>
                                {{ $account->id . '-' . $account->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="nameBasic" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email"
                        required value={{ $user->email }} />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="button" p class="btn btn-primary"
                onclick="save('{{ route('user.update', $user->id) }}','put')"><i class="bx bx-save"></i> Save
                changes</button>
        </div>
    </form>
</div>
