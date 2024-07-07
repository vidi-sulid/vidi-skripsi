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
            $('form')[0].reset();
            $(':button').prop('disabled', false);
            info("Data Berhasil disimpan !",'bg-success');
            $('#formdatatable').DataTable().ajax.reload();
            $("#modalForm").modal('hide');
            $("#detail-rekening").html("");
            $("#detail-mutasi").html("");
            
            
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
                    $('#formdatatable').DataTable().ajax.reload();
                    toastr.success("Data Berhasil dihapus !","info") ;
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
