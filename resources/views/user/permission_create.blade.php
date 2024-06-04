<div class="modal-content p-2 p-md-3">
    <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
            <h3 class="role-title">Add New Role</h3>
            <p>Set role permissions</p>
        </div>
        <!-- Add role form -->
        <form id="form1" class="row g-3">
            <div class="col-12 mb-4">
                <label class="form-label" for="modalRoleName">Role Name</label>
                <input type="text" id="modalRoleName" name="name" class="form-control"
                    placeholder="Enter a role name" tabindex="-1" />
            </div>
            <div class="col-12">
                <h4>Role Permissions</h4>
                <!-- Permission table -->
                <div class="table-responsive">
                    <table class="table table-flush-spacing">
                        <tbody>
                            <tr>
                                <td class="text-nowrap fw-medium">Administrator Access <i
                                        class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Allows a full access to the system"></i></td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                        <label class="form-check-label" for="selectAll">
                                            Select All
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($menu as $key => $value)
                                <tr>
                                    <td class="text-nowrap fw-medium">{{ $key }}</td>
                                    <td>
                                        <div class="d-flex">
                                            @foreach ($value as $key1 => $value1)
                                                @foreach ($value1 as $key2 => $value)
                                                    <div class="form-check me-3 me-lg-5">
                                                        <input class="form-check-input" name="permissions[]"
                                                            type="checkbox" id="{{ $key1 . '_' . $value }}"
                                                            value="{{ strtolower($key1) . '_' . strtolower($value) }}" />
                                                        <label class="form-check-label"
                                                            for="{{ $key1 . '_' . $value }}">
                                                            {{ $value }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- Permission table -->
            </div>
            <div class="col-12 text-center">
                <button type="button" onclick="save('{{ route('permission.store') }}','post')"
                    class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
            </div>
        </form>
        <!--/ Add role form -->
    </div>
</div>
<script>
    const t = document.querySelector("#selectAll"),
        o = document.querySelectorAll('[type="checkbox"]');
    t.addEventListener("change", t => {
        o.forEach(e => {
            e.checked = t.target.checked
        })
    })
</script>
<div>
