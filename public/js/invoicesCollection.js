// add-collection-widget.js


const sub_total = function(quantity,price,discount){

    return quantity*price-(((quantity*price)*discount)/100);
}


$(function () {

    $('.add-collection-widget').on('click',(function (e) {
        
        var list = $($(this).attr('data-list-selector'));
        var table = $("#tableInvoice > tbody");
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        //var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        //newElem.appendTo(table);
        table.append('<tr class="lineInvoce">' + newWidget + '</tr>');
    }));

    // $(document).on('change','.product', function (e){

    //     var url = "/ajax/get/product/" + $(this).val();
    //     var price = $(this).parents('tr').find('.price');
    //     var quantity = $(this).parents('tr').find('.quantity').val();
    //     var discount = $(this).parents('tr').find('.discount').val();
    //     var subtotal = $(this).parents('tr').find('.subtotal');

    //     $.get(url, function( data ) {

    //         price.val(data.price)
    //         //totalLine = quantity*data.price-(((quantity*data.price)*discount)/100);
    //         subtotal.val(sub_total(quantity,data.price,discount));

    //       });
    // })

    // $(document).on('change','.quantity', function (e){

    //     var price = $(this).parents('tr').find('.price').val();
    //     var quantity = $(this).parents('tr').find('.quantity').val();
    //     var discount = $(this).parents('tr').find('.discount').val();
    //     var subtotal = $(this).parents('tr').find('.subtotal');

    //     //totalLine = quantity*price-(((quantity*price)*discount)/100);
    //     subtotal.val(sub_total(quantity,price,discount));

    // })


    $(document).on('change','.lineInvoce', function (e){

        var price = $(this).find('.price');
        var quantity = $(this).find('.quantity').val();
        var discount = $(this).find('.discount').val();
        var subtotal = $(this).find('.subtotal');


    if ($(this).find('.price').val() == 1){

        var url = "/ajax/get/product/" + $(this).find('.form-select').val();
        $.get(url, function( data ) {

            price.val(data.price)
            //totalLine = quantity*data.price-(((quantity*data.price)*discount)/100);
            subtotal.val(sub_total(quantity,data.price,discount));

        });
    }



        //totalLine = quantity*price-(((quantity*price)*discount)/100);
        subtotal.val(sub_total(quantity,price.val(),discount));

    })

});
