$(document).ready(function() {
    var productionlistIDValue;
    var batchIDValue;



    $('.editbatch').on('click', function(e) {
        event.preventDefault();
        productionlistIDValue = $("#queuedBatchData tr.selected td:eq(0)").html();
        batchIDValue = $("#queuedBatchData tr.selected td:eq(1)").html();
        if (productionlistIDValue != null) {
            window.location = 'editBatch/' + productionlistIDValue;

        } else {
            window.location = 'batchqueue';
        }
    });





    $('.canceleditbutton').on('click', function(e) {
        event.preventDefault();
        window.location.replace('/brewsoft/mvc/public/manager/batchqueue')

    });

    function submitEditBatch() {
        $("#editform").submit(function(event) {

            /* stop form from submitting normally */
            event.preventDefault();

            /* get the action attribute from the <form action=""> element */
            //console.log(this.href.substring(this.href.lastIndexOf('/') + 1));
            var $form = $(this),
                url = $form.attr('action', "/brewsoft/mvc/public/manager/editBatch/" + productionlistIDValue);

            /* Send the data using post with element id*/
            var posting = $.post(url, {
                productID: $('#productID').val(),
                productAmount: $('#productAmount').val(),
                deadline: $('#deadline').val(),
                speed: $('#speed').val()
            });


            /* the results */
            posting.done(function(data) {
                $('#editstatus').text("Edit success");

            });
        });
    }
});

function getQueuedBatches(searchParameter) {
    $.ajax({
        url: "/brewsoft/mvc/app/services/searchInQueueList.php?searchParameter=" + searchParameter,
        type: "GET",
        async: true,
        searchParameter: "searchParameter",
        success: function(data) {
            document.getElementById("queuedBatchData").innerHTML = data;
            $("#queuedBatchData tr").click(function() {
                $(this).addClass('selected').siblings().removeClass('selected');
                var productlistid = $(this).find('td:eq(0)').html();
                var batchid = $(this).find('td:eq(1)').html();
                console.log('productlistid: ' + productlistid);
                console.log('batchid: ' + batchid);
            });
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    getQueuedBatches(document.getElementById("search").value);
});