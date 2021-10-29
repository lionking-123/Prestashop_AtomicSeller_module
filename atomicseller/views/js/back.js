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
            data == 'success' ? showSuccessMessage(connection_success) : showErrorMessage(active_error);
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
            var res = JSON.parse(JSON.stringify(data));
            var len = res['data'].length;

            html = "";
            if(len > 0) {
                for(var i = 0; i < len; i++) {
                    html += "<tr>";
                    html += "<td>" + res['data'][i]['reference'] + "</td>";
                    html += "<td>" + res['data'][i]['date'] + "</td>";
                    html += "<td>" + res['data'][i]['status'] + "</td>";
                    html += "<td>" + res['data'][i]['customer'] + "</td>";
                    html += "<td><button type='button' onclick='viewOrderDetail(" + res['data'][i]['id_order'] + ", `" + res['data'][i]['reference'] + "`, `" + res['data'][i]['date'] + "`)'>View</button></td>";
                    html += "</tr>";
                }

                $("#resetBtn").prop("disabled", false);
            } else {
                html += "<tr>";
                html += "<td colspan='5'>No data to display.</td>";
                html += "</tr>";

                $("#resetBtn").prop("disabled", true);
            }

            $("#orderBody").html(html);
            $("#det_order_ref").val("");
            $("#det_order_date").val("");
            $("#getLabelBtn").prop("disabled", true);
            $("#sendEmailBtn").prop("disabled", true);
        }
    });
});

$(document).on('click', '#resetBtn', function() {
    var html = "";
    html += "<tr>";
    html += "<td colspan='5'>No data to display.</td>";
    html += "</tr>";

    $("#orderBody").html(html);
    $("#resetBtn").prop("disabled", true);

    $("#det_order_ref").val("");
    $("#det_order_date").val("");
    $("#getLabelBtn").prop("disabled", true);
    $("#sendEmailBtn").prop("disabled", true);
});

function viewOrderDetail(id, ref, date) {
    console.log(id);
    $("#det_order_ref").val(ref);
    $("#det_order_date").val(date);
    $("#getLabelBtn").prop("disabled", false);
    $("#sendEmailBtn").prop("disabled", false);
}

function getReturnLabel() {
    var ref = $("#det_order_ref").val();

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: psr_controller_atomicseller_url,
        data: {
            action: 'GetReturnLabel',
            orderKey : ref,
        },
        success: function (data) {
            var statusCode = data['Header']['StatusCode'];
            if(statusCode == 200) {
                showSuccessMessage(data['Response']['Documents'][0]['DocURL']);
                $("#emailContent").val(data['Response']['Documents'][0]['DocURL']);
            } else {
                showErrorMessage(data['Header']['ReturnMessage']);
                $("#emailContent").val(data['Header']['ReturnMessage']);
            }
        }
    });
}

function sendEmail() {
    var content = $("#emailContent").val();
    var ref = $("#det_order_ref").val();

    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: psr_controller_atomicseller_url,
        data: {
            action: 'EmailSendToCustomer',
            order_ref: ref,
            eContent: content,
        },
        success: function (data) {
            console.log("Email sent!");
        }
    });
}