jQuery(function () {
    $("#tbl-event tr").on('click', function() {


        type = $(this).attr("data-type");

        switch (type) {
            case "link":
                
                    location.href = $(this).attr("data-href"); 
  
                break;
        
            default:
                break;
        }

       
    });

});    