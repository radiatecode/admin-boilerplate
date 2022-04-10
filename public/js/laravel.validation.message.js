/**
 *
 * @param errors
 */
function laravelErrors(errors){
    // remove previous error message
    $.removeLaravelErrors();

    var generalErrors = [];

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
                singleElm[0].parentNode.querySelector(".invalid-feedback").innerHTML = value[0]; // value.join(' ') [to show all errors for this key]
            }else{
                generalErrors.push(value[0]);
            }
        }
    });

    if (generalErrors.length > 0){
        Swal.fire({
            title: 'Error !',
            html: generalErrors.join(', '),
            type: 'error'
        })
    }
}

/**
 * jquery error show function
 *
 * @param errors
 */
$.laravelErrorShow = function (errors){
   laravelErrors(errors);
}

$.removeLaravelErrors = function (){
    $('.form-control').removeClass('is-invalid');
    $('.error').html('');
}
