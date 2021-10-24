$(window).ready(function () {

    // Tab Content
    $('.listing-body').sortable({
        update: function () {
            var blocks = [];
            $('.listing-general-rol').each(function () {
                blocks.push($(this).attr('data-block'));
            });

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: psr_controller_block_url,
                data: {
                    ajax: true,
                    action: 'UpdatePosition',
                    blocks: blocks,
                },
                success: function (data) {
                    if (data == 'success') {
                        showSuccessMessage(successPosition);
                    }  else {
                        showErrorMessage(errorPosition);
                    }
                }
            });
        }
    });

    // Tab Content : Set active/inactive
    $(document).on('click', '.listing-row .switch-input', (e) => {
        var switchIsOn = $(e.target).hasClass('-checked');
        var status = switchIsOn ? 1 : 0;

        $(e.target).parent().find('.switch_text').hide();
        if (switchIsOn) {
            $('input', e.target).attr('checked', false);
            $(e.target).removeClass('-checked');
            $(e.target).parent().find('.switch-off').show();
        } else {
            $('input', e.target).attr('checked', true);
            $(e.target).addClass('-checked');
            $(e.target).parent().find('.switch-on').show();
        }

        $.ajax({
            url: psr_controller_block_url,
            type: 'POST',
            dataType: 'JSON',
            async: false,
            data: {
                controller: psr_controller_block,
                action: 'changeBlockStatus',
                idpsr: $(e.target).parent().attr('data-cart_psreassurance_id'),
                status: status,
                ajax: true,
            },
            success: (data) => {
                if (data === 'success') {
                    showNoticeMessage(block_updated);
                } else {
                    showErrorMessage(active_error);
                }
            }
        });
    });

    // Tab Label Settings : test connection
    $(document).on('click', '#testConnection', function () {
        var t = $('#wsToken').val();
        var s = $('#wsStorekey').val()
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
                data === 'success' ? showSuccessMessage(connection_success) : showErrorMessage(connection_error);
            }
        });
    });

    // Tab Email Settings : save configruation
    $(document).on('click', '#saveEmailConf', function () {
        var t = $('#title').val();
        var c = $('#content').val()
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
});
