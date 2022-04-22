"use strict";
(function ($, window, i) {
    /* get selector name */
    $.fn._init = $.fn.init;

    $.fn.init = function (selector, context, root) {
        return (typeof selector === 'string') ?
            new $.fn._init(selector, context, root).data('selector', selector) :
            new $.fn._init(selector, context, root);
    };

    $.fn.getSelector = function () {
        return $(this).data('selector');
    };
    /* ..end get selector name*/

    $.fn.deleteConfirm = function () {
        var selector = $(this).getSelector();

        if (selector !== undefined)
        {
            $(document).on("click", selector, function ()
            {
                var url = $(this).data('delete-url');

                if (url === undefined)
                {
                    Swal.fire({
                        title: 'Attribute Missing !',
                        text: 'Add data-delete-url attribute to the deletable button',
                        type: 'error'
                    });
                } else {
                    deleteAjax({
                        url: url,
                        type: "DELETE"
                    });
                }

            });
        }
    };

    $.fn.deleteSelectedConfirm = function (url = null)
    {
        var selector = $(this).getSelector();

        if (selector !== undefined) {
            $(document).on("click", selector, function ()
            {
                var values = checkBoxValues();

                var options = {};

                if(! url){
                    options.url = $(this).data('delete-url');
                }

                if (values.length !== 0) {
                    options.type = "POST";

                    options.data = {selected_rows: values};

                    deleteAjax(options);
                } else {
                    Swal.fire({
                        title: 'First Select The Items!',
                        text: 'you need to select the items to delete',
                        icon: 'warning'
                    });
                }
            });
        }
    };

    let deleteAjax = function (options) {
        let ajaxOptions = {
            url: options.url,
            type: options.type,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': window.CSRF_TOKEN
            }
        }

        if (options.type === 'POST') {
            ajaxOptions.data = options.data;
        }

        let title = "You want to delete selected "

        Swal.fire({
            title: 'Are you sure?',
            text: options.type === 'POST' ? title + "items?" : title + "item?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!',
            showLoaderOnConfirm: true,
            preConfirm: async function () {
                await $.ajax(ajaxOptions)
                    .done(function (response) {return response;})
                    .fail(function (error) {
                        Swal.close();
                        if (error.status === 404) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Data not found!',
                                type: 'error',
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
            allowOutsideClick: () => !Swal.isLoading()
        }).then(function (result) {
            window.location.reload();
        });
    }

    let checkBoxValues = function () {
        var bulkIds = 'input[name="bulkIds[]"]';

        var arr = $(bulkIds + ':checked').map(function () {
            return this.value; // $(this).val()
        }).get();

        return arr;
    }

})(jQuery, this, 0);
