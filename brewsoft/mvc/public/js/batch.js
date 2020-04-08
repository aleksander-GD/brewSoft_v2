window.onload = function() {
    $("#table tr").click(function() {
        $(this).addClass('selected').siblings().removeClass('selected');
        var value = $(this).find('td:first').html();
        console.log(value);
    });


    $('.editbatch').on('click', function(e) {
        event.preventDefault();
        var value = $("#table tr.selected td:first").html();
        // window.location = 'brewsoft/mvc/public/manager/editBatch/' + value;
        var url = 'brewsoft/mvc/public/manager/editBatch/' + value;
        // To make a post request towards the controller with batchID value.
        var form = $('<form action="' + url + '" method="post">' +
            '<input type="text" name="api_url" value="' + url + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });
};