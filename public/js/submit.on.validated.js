function ajaxSubmitOnValidated(formId, showErrorList = false, callback = null, redirectTo = null) {
    let $form = $('#' + formId);

    $form.parsley().on('field:validated', function () {
        let ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    }).on('form:submit', function (e) {
        $.removeLaravelErrors();

        if (callback) {
            let result = callback();

            if (!result) {
                return false;
            }
        }

        var formData = new FormData($form[0]);

        networkRequest('alert').ajax({
            url: $form.attr('action'),
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        }, function (response) {
            if (response === 'success' || response.status === 'success') {
                if(redirectTo){
                    window.location.href = redirectTo;
                }else{
                    window.location.reload();
                }
            }
        }, function (error) {
            if (error.status === 422) {
                $.laravelErrorShow(error.responseJSON.errors, showErrorList);
            } else if (error.status === 404) {
                toastr.error(error.responseJSON.message, 'Not Found!', { progressBar: true });
            } else {
                toastr.error('Something went wrong!', 'Error! ' + error.status, { progressBar: true });
                console.log(error);
            }
        });

        return false;
    });
}

function submitOnValidated(formId, callback = null) {
    let $form = $('#' + formId);

    $form.parsley().on('field:validated', function () {
        let ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    }).on('form:submit', function (e) {
        if (callback) {
            let result = callback();

            return !!result;
        }

        return true;
    });
}

$.ajaxSubmitOnValidated = function (formId, showErrorList = false, callback = null, redirectTo = null) {
    ajaxSubmitOnValidated(formId, showErrorList, callback, redirectTo);
}

$.submitOnValidated = function (formId, callback = null) {
    submitOnValidated(formId, callback);
}
