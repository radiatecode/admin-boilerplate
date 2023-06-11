function preloadingAjax(options) {
    let swalOptions = {
        title: options.title == undefined ? 'Confirmation' : options.title,
        text: options.text == undefined ? 'Are you sure?' : options.text,
        icon: options.icon == undefined ? 'info' : options.icon,
        confirmText: options.confirmText == undefined ? 'Yes, Do It' : options.confirmText
    }

    let ajaxOptions = {
        url: options.ajax.url,
        type: options.ajax.type == undefined ? 'GET' : options.ajax.type,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        }
    }

    if (options.data !== undefined) {
        ajaxOptions.data = options.ajax.data;
    }

    Swal.fire({
        title: swalOptions.title,
        text: swalOptions.text,
        icon: swalOptions.icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: swalOptions.confirmText,
        showLoaderOnConfirm: true,
        preConfirm: async function () {
            await $.ajax(ajaxOptions)
                .done(function (response) { return response; })
                .fail(function (error) {
                    Swal.close();

                    if ($.inArray(error.status, [400, 401, 403, 404, 406]) !== -1) {
                        Swal.fire({
                            title: 'Error! - ' + error.statusText,
                            text: error.responseJSON,
                            icon: 'error',
                        });

                        return;
                    }

                    Swal.fire({
                        title: 'Error! ' + error.status,
                        text: 'Something went wrong!',
                        type: 'error',
                    });
                    console.error(error);
                });
        },
        backdrop: true,
        allowOutsideClick: () => !Swal.isLoading()
    }).then(function (result) {
        if (result.value) {
            window.location.reload();
        }
    });
}