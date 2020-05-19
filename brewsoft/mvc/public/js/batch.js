var timer_check;
var timer_check_alive;
$(document).ready(function() {
    var productionlistIDValueQueue;
    var batchIDValueQueue;
    var productionlistIDValueCompleteBatch;
    var batchIDValueCompleteBatch;

    $('.generateBatchReport').on('click', function(e) {
        var productID;
        var productAmount;
        var deadline;
        var speed;

        //var timer_check = window.setInterval(getCompletedBatches, 1000);

        var timer_check_alive = setInterval(function() {
            check_database_alive_call();
        }, 100000);
    });


    $('.showOeeForBatch').on('click', function(e) {
        event.preventDefault();
        productionlistIDValueCompleteBatch = $("#completedBatchData tr.selected td:eq(0)").html();
        batchIDValueCompleteBatch = $("#completedBatchData tr.selected td:eq(1)").html();
        if (productionlistIDValueCompleteBatch != null) {
            window.location = 'batchReport/' + productionlistIDValueCompleteBatch;
            console.log(check_database_alive_call());
            if (check_database_alive_call()) {
                if (productionlistIDValueCompleteBatch != null) {
                    window.location = 'batchReport/' + productionlistIDValueCompleteBatch;

                } else {
                    window.location = 'completedBatches';
                }
            } else {
                console.log("Show bootstrap alert for showOeeForBatch on click");
            }
        }
    });


    $('.editbatch').on('click', function(e) {
        event.preventDefault();
        productionlistIDValueQueue = $("#queuedBatchData tr.selected td:eq(0)").html();
        batchIDValueQueue = $("#queuedBatchData tr.selected td:eq(1)").html();
        console.log(check_database_alive_call());

        if (productionlistIDValueQueue != null) {
            window.location = 'editBatch/' + productionlistIDValueQueue;

        } else {

            window.location = 'batchqueue';
        }

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
            if (check_database_alive_call()) {

                /* stop form from submitting normally */
                event.preventDefault();

                /* get the action attribute from the <form action=""> element */
                //console.log(this.href.substring(this.href.lastIndexOf('/') + 1));
                var $form = $(this),
                    url = $form.attr('action', "/brewsoft/mvc/public/manager/editBatch/" + productionlistIDValue);

                /* Send the data using post with element id*/
                if (check_database_alive_call() != false) {
                    var posting = $.post(url, {
                        productID: $('#productID').val(),
                        productAmount: $('#productAmount').val(),
                        deadline: $('#deadline').val(),
                        speed: $('#speed').val()
                    });
                }
            } else {
                console.log("Show bootstrap alert for editBatch on click");
            }

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
            if (data && check_database_alive_call()) {
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

            if (data && check_database_alive_call()) {
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

function check_database_alive_call() {
    var boolcheck;
    var deferred = $.Deferred();
    var count = 0;


    $.ajax({
        url: "/brewsoft/mvc/app/services/DatabaseStatus.php",
        type: "GET",
        async: true,
        success: function(data) {
            if (data && data !== "false") {

                if (!loaded_content) {
                    getCompletedBatches("");
                    getQueuedBatches("");
                    loaded_content = true;
                } else {
                    console.log("connection success");
                    boolcheck = true;

                }

            } else {
                console.log("error with database");
                boolcheck = false;
                loaded_content = false;
            }
        },
        complete: function() {
            deferred.resolve(trueOrFalse(boolcheck));
        }
    });
    return deferred.promise();
}

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