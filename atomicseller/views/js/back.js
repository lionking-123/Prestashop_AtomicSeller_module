// Tab Label Settings : test connection
$(document).on('click', '#testConnection', function () {
    var t = $('#wsToken').val();
    var s = $('#wsStorekey').val();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: psr_controller_atomicseller_url,
        data: {
            action: 'TestConnection',
            wToken: t,
            wStorekey: s,
        },
        success: function (data) {
            data === 'success' ? showSuccessMessage(connection_success) : showErrorMessage(active_error);
        }
    });
});

// Tab Email Settings : save configruation
$(document).on('click', '#saveEmailConf', function () {
    var t = $('#eTitle').val();
    var c = $('#eContent').val();
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: psr_controller_atomicseller_url,
        data: {
            action: 'SaveEmailConf',
            eTitle: t,
            eContent: c,
        },
        success: function (data) {
            data === 'success' ? showSuccessMessage(psre_success) : showErrorMessage(active_error);
        }
    });
});

$(document).on('click', '#seachBtn', function() {
    var r = $("#order_ref").val();
    var d = $("#order_date").val();
    var s = $("#order_status").val();
    var c = $("#customer_name").val();

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: psr_controller_atomicseller_url,
        data: {
            action: 'SearchOrderList',
            order_ref: r,
            order_date: d,
            order_status: s,
            customer_name: c,
        },
        success: function (data) {
            data ? console.log("Success") : console.log("Failed!");
        }
    });
});

$(document).on('click', '#resetBtn', function() {
    $("#order_ref").val("");
    $("#order_date").val("");
    $("#order_status").val("");
    $("#customer_name").val("");

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: psr_controller_atomicseller_url,
        data: {
            action: 'ResetOrderList'
        },
        success: function (data) {
            data ? console.log("Success!") : console.log("Failed!");
        }
    });
});