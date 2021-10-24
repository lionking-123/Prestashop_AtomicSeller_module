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
