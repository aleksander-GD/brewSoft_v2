//var timer_check;
$(document).ready(function() {
    //event.preventDefault();
    var productionlistIDValueQueue;
    var batchIDValueQueue;
    var productionlistIDValueCompleteBatch;
    var batchIDValueCompleteBatch;
    /*  $('.generateBatchReport').on('click', function(e) {
         var productID;
         var productAmount;
         var deadline;
         var speed;

         //var timer_check = window.setInterval(getCompletedBatches, 1000);
         event.preventDefault();
         productionlistIDValueCompleteBatch = $("#completedBatchData tr.selected td:eq(0)").html();
         batchIDValueCompleteBatch = $("#completedBatchData tr.selected td:eq(1)").html();
         if (productionlistIDValueCompleteBatch != null) {
             window.location = 'displayOeeForBatch/' + productionlistIDValueCompleteBatch;
             window.location = 'batchReport/' + productionlistIDValueCompleteBatch;

         } else {
             window.location = 'completedBatches';
         }

     }); */

    var ww = $(window).width();
    var wh = $(window).height();
    if (ww <= 375 && wh < 812) {
        $("#formobilescreen").show();
    } else {

        $("#formobilescreen").hide();

    }
    $('.showOeeForBatch').on('click', function(e) {
        event.preventDefault();
        productionlistIDValueCompleteBatch = $("#completedBatchData tr.selected td:eq(0)").html();
        batchIDValueCompleteBatch = $("#completedBatchData tr.selected td:eq(1)").html();
        if (productionlistIDValueCompleteBatch != null) {
            window.location = 'batchReport/' + productionlistIDValueCompleteBatch;
            if (productionlistIDValueCompleteBatch != null) {
                window.location = 'batchReport/' + productionlistIDValueCompleteBatch;

            } else {
                window.location = 'completedBatches';
            }
        }
    });

    $('.editbatch').on('click', function(e) {
        event.preventDefault();
        productionlistIDValueQueue = $("#queuedBatchData tr.selected td:eq(0)").html();
        batchIDValueQueue = $("#queuedBatchData tr.selected td:eq(1)").html();

        if (productionlistIDValueQueue != null) {
            window.location = 'editBatch/' + productionlistIDValueQueue;


        } else {

            window.location = 'batchqueue';
        }

    });
    $('#table tr').on('click', function() {
        console.log("check");
        if (window.location = 'completedBatches') {
            window.location = 'batchReport/' + productionlistIDValueCompleteBatch;
        }
        if (window.location = 'batchqueue') {
            window.location = 'editBatch/' + productionlistIDValueQueue;
        }
        return false;

    });
    $('.canceleditbuttoneditbatch').on('click', function(e) {
        event.preventDefault();
        window.location.replace('/brewsoft/mvc/public/manager/batchqueue')

    });
    $('.canceleditbuttonshowoee').on('click', function(e) {
        event.preventDefault();
        window.location.replace('/brewsoft/mvc/public/manager/completedBatches')

    });
    var data_array = new Array();


    $('#productID').innerHTML = productID;
    $('#productAmount').innerHTML = productAmount;
    $('#deadline').innerHTML = deadline;
    $('#speed').innerHTML = speed;

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
            if (data) {
                document.getElementById("queuedBatchData").innerHTML = data;
                $("#queuedBatchData tr").click(function() {
                    $(this).addClass('selected').siblings().removeClass('selected');
                    var productlistid = $(this).find('td:eq(0)').html();
                    var batchid = $(this).find('td:eq(1)').html();

                    console.log('productlistid: ' + productlistid);
                    console.log('batchid: ' + batchid);
                });
            } else {
                console.log("Show bootstrap alert for getQueuedbatch");
            }
        }
    });
}



function getCompletedBatches(searchParameter) {
    $.ajax({
        url: "/brewsoft/mvc/app/services/searchInCompletedBatches.php?searchParameter=" + searchParameter,
        type: "GET",
        async: true,
        searchParameter: "searchParameter",
        success: function(data) {

            if (data) {
                document.getElementById("completedBatchData").innerHTML = data;
                $("#completedBatchData tr").click(function() {
                    $(this).addClass('selected').siblings().removeClass('selected');
                    var productlistid = $(this).find('td:eq(0)').html();
                    var batchid = $(this).find('td:eq(1)').html();
                    console.log('productlistid: ' + productlistid);
                    console.log('batchid: ' + batchid);
                });

                /* clearInterval(timer_check); */
            } else {
                console.log("Show bootstrap alert for getCompletedBatch");
                /* clearInterval(timer_check_alive); */
            }
        }
    });
}
var loaded_content = false;

function trueOrFalse(bool) {
    return bool;
}

function once(fn, context) {
    var result;

    return function() {
        if (fn) {
            result = fn.apply(context || this, arguments);
            fn = null;
        }

        return result;
    };
}

document.addEventListener("DOMContentLoaded", function() {
    getCompletedBatches(document.getElementById("search").value);
    getQueuedBatches(document.getElementById("search").value);
});
