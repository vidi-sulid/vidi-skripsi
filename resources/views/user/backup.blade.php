@extends('layouts.app')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">System /</span> Backup Database
    </h4>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card mb-6">
                <h5 class="card-header">Download file di bawah</h5>
                <div class="card-body">
                    <div id="jstree-context-menu" class="overflow-auto"></div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
@endsection

@section('addon_js')
    <script src="{{ asset('assets/vendor/libs/jstree/jstree.js') }}"></script>

    <script>
        $(function() {
            var pathBackup = {!! json_encode($pathBackup) !!};

            // Example usage:
            console.log(pathBackup);

            var t = $("html").hasClass("light-style") ? "default" : "default-dark",
                e = $("#jstree-basic"),
                s = $("#jstree-custom-icons"),
                x = $("#jstree-context-menu"),
                n = $("#jstree-drag-drop"),
                c = $("#jstree-checkbox"),
                l = $("#jstree-ajax");
            x.length && x.jstree({
                core: {
                    themes: {
                        name: t
                    },
                    check_callback: !0,
                    data: pathBackup
                },
                plugins: ["types", "contextmenu"],
                types: {
                    default: {
                        icon: "bx bx-folder"
                    },
                    html: {
                        icon: "bx bxl-html5 text-danger"
                    },
                    css: {
                        icon: "bx bxl-css3 text-info"
                    },
                    img: {
                        icon: "bx bx-image text-success"
                    },
                    js: {
                        icon: "bx bxl-nodejs text-warning"
                    },
                    database: {
                        icon: 'bx bxl-postgresql text-info'
                    }
                }
            }).on('select_node.jstree', function(e, data) {
                if (data.node.a_attr.href !== "#") {
                    window.location.href = data.node.a_attr.href;
                }
            });
        });
    </script>
@endsection
