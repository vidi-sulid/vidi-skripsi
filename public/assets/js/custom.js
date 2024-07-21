
function save(url,type) {
    $(':button').prop('disabled', true);
    var data = $("#form1").serialize();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: type,
        data: data,
        success: function(data) {
            var form = $('form')[0];
            if (form) {
                if ( typeof form.reset === 'function') {
                    form.reset();
                }
            }
            $(':button').prop('disabled', false);
            info("Data Berhasil disimpan !",'bg-success');
            $("#modalForm").modal('hide');
            $("#detail-rekening").html("");
            $("#detail-mutasi").html("");
                        
            Livewire.on('eventName', (data) => {
                console.log('Received event from Livewire:', data);
                // Lakukan tindakan berdasarkan data yang diterima
            });
            var element = document.getElementById('formdatatable');

            if (element) {
                // Reload the DataTable using AJAX
                $('#formdatatable').DataTable().ajax.reload();
            }
            if(data == "reload"){
                location.reload();
            }

            
        },
        error: function(xhr, status, error) {
            var errors = xhr.responseJSON.errors;

            // Loop through errors and display them
            for (var key in errors) {
                if (errors.hasOwnProperty(key)) {

                    var errorMessages = errors[key].join(', ');
                    info(errorMessages,"bg-warning");

                }
            }

            $(':button').prop('disabled', false);
        }
    })
}

$('.numeral-mask').toArray().forEach(function(field){
    new Cleave(field, {
        numeral: true,
        numeralDecimalMark: ',',
        delimiter: '.'
    })
 });
 
function hapus(url){

    Swal.fire({
        title: "Apakah Anda Yakin ?",
        text: "Data Yang Sudah Dihapus Tidak Bisa Dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Tetap Hapus!"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "delete",
                success: function(data) {
                    var element = document.getElementById('formdatatable');

                    if (element) {
                        // Reload the DataTable using AJAX
                        $('#formdatatable').DataTable().ajax.reload();
                    }
                    info("data berhasil dihapus") ;
                }
            })
        }
    })
}

function info(message,bgtype='bg-success') {
    const e = document.querySelector(".toast-ex");
    $(".toast-body").text(message);
    $(".toast-header-info").text("Notifikasi");
    e.classList.add(bgtype, "fade");
    var toast = new bootstrap.Toast(e);
    // Show the toast
    toast.show();
    setTimeout(function () {
        $('#toastId').removeClass(bgtype);
    }, 2000);
    
}

function openModal(url) {
    $("#modalForm").modal('show');
    $("#modalContent").load(url,function(){
        // console.log(Livewire);
        // Livewire.restart(); 
        
    });
}

function number_format(number, decimals, decimalSeparator, thousandsSeparator) {
    decimals = decimals || 0;
    decimalSeparator = decimalSeparator || '.';
    thousandsSeparator = thousandsSeparator || ',';

    number = parseFloat(number);

    if (isNaN(number) || !isFinite(number)) {
        return NaN;
    }

    var fixedNumber = number.toFixed(decimals);

    var parts = fixedNumber.split('.');
    var integerPart = parts[0];
    var decimalPart = parts.length > 1 ? decimalSeparator + parts[1] : '';

    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator);

    return integerPart + decimalPart;
}

document.addEventListener('livewire:load', function () {
    Livewire.on('componentReset', function () {
        // Handle the reset event, e.g., reload data or update UI
        console.log('Livewire component has been reset');
    });
});

function logout(event) {
    Swal.fire({
        title: "Apakah Anda Yakin ?",
        text: "Ingin Keluar Dari Aplikasi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya!"
    }).then((result) => {
        if (result.value) {
            event.preventDefault();

            fetch('https://vidi.my.id/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // body: JSON.stringify({}) // Add any data if needed
            }).then(response => {
                if (response.ok) {
                    // Optional: Perform any additional actions after successful logout
                    console.log('Logged out successfully');
                    // Example: Redirect to login page
                    window.location.href = '/login';
                } else {
                    console.error('Logout failed');
                }
            }).catch(error => {
                console.error('Error during logout:', error);
            });
        }
    })   
}

function initializeDataTable() {
    // Hapus DataTable jika sudah ada untuk menghindari duplikasi
    if ($.fn.DataTable.isDataTable('#tableReport')) {

        $('#tableReport').DataTable().destroy();
    }
    // Inisialisasi ulang DataTable
    $('#tableReport').DataTable({
        // Konfigurasi DataTable Anda
        paging: false,
        searching: true,
        info: false,
        responsive:true
        // ...opsi lainnya
    });
}

function select2Custom(){
    var s, i, e = $(".select2"),
            e = (e.length && e.each(function() {
                var e = $(this);
                e.wrap('<div class="position-relative"></div>').select2({
                    dropdownParent: e.parent(),
                    placeholder: e.data("placeholder")
                })
            }), $(".form-repeater"));
        e.length && (s = 2, i = 1, e.on("submit", function(e) {
            e.preventDefault()
        }), e.repeater({
            show: function() {
                var a = $(this).find(".form-control, .form-select"),
                    t = $(this).find(".form-label");
                a.each(function(e) {
                    var r = "form-repeater-" + s + "-" + i;
                    $(a[e]).attr("id", r), $(t[e]).attr("for", r), i++
                }), s++, $(this).slideDown(), $(".select2-container").remove(), $(
                    ".select2.form-select").select2({
                    placeholder: "Placeholder text"
                }), $(".select2-container").css("width", "100%"), $(
                    ".form-repeater:first .form-select").select2({
                    dropdownParent: $(this).parent(),
                    placeholder: "Placeholder text"
                }), $(".position-relative .select2").each(function() {
                    $(this).select2({
                        dropdownParent: $(this).closest(".position-relative")
                    })
                })
            }
        }));
}