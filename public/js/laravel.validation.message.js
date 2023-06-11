/**
 *
 * @param errors
 * @param showAsList
 */
function laravelErrors(errors,showAsList = false){
    // remove previous error message
    $.removeLaravelErrors();

    var generalErrors = '';

    // error loop
    $.each(errors, function (key, value) {
        if (key.includes('.')) { // validation multiple array input element
            var split = key.split('.');

            var array_name = split[0];
            var index = parseInt(split[1]);
            var name = split[2];

            var element = document.getElementsByName(array_name + '['+index+']['+ name +']');

            var parent = element[0].parentNode;

            element[0].classList.add("is-invalid");

            var invalidFeedback = parent.querySelector(".invalid-feedback");

            if (invalidFeedback){
                invalidFeedback.innerHTML = value[0]; // value.join(' ') [to show all errors for this key]
            }else{
                parent.innerHTML += '<span class="error invalid-feedback">'+ value[0] +'</span>';
            }
        }else{
            var singleElm = document.getElementsByName(key);

           if (singleElm.length > 0){
                singleElm[0].classList.add("is-invalid");

                var invalid = singleElm[0].parentNode.querySelector(".invalid-feedback");

                if (invalid){
                    invalid.innerHTML = value[0]; // value.join(' ') [to show all errors for this key]
                }else{
                    singleElm[0].parentNode.innerHTML += '<span class="error invalid-feedback">'+ value[0] +'</span>';
                }
           }
        }

        if (showAsList){
            generalErrors += '<li>' + value[0] + '</li>';
        }
    });

    if (showAsList){
        var unOrderErrorList = '<div class="alert alert-danger">\n' +
            '<ul>\n' +
             generalErrors+'\n' +
            '</ul>\n' +
            '</div>';

       $('.laravel-errors').html(unOrderErrorList);
    }
}

function laravelErrorsWithToast(errors){
    // error loop
    $.each(errors, function (key, value) {
        toastr.error(value[0], 'Error!', {progressBar: true});
    });
}

function laravelErrorsWithList(errors){
    var generalErrors = '';

    // error loop
    $.each(errors, function (key, value) {
        generalErrors += '<li>' + value[0] + '</li>';
    });

    var unOrderErrorList = '<div class="alert alert-danger">\n' +
        '<ul>\n' +
        generalErrors+'\n' +
        '</ul>\n' +
        '</div>';

    $('.laravel-errors').html(unOrderErrorList);
}

/**
 * jquery error show function
 *
 * @param errors
 * @param showAsList
 */
$.laravelErrorShow = function (errors,showAsList = false){
   laravelErrors(errors,showAsList);
}

$.laravelErrorWithToast = function (errors){
    laravelErrorsWithToast(errors);
}

$.laravelErrorsWithList = function (errors){
    laravelErrorsWithList(errors);
}

$.removeLaravelErrors = function (){
    $('.form-control').removeClass('is-invalid');

    $('.error').html('');

    $('.laravel-errors').html('');
}
