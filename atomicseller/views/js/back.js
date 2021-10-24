/**
 * 2007-2019 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
$(window).ready(function () {
    // Tab Content
    var imgSelected;
    // Tab Content : Change position
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
                data === 'success' ? showSuccessMessage(connection_error) : showErrorMessage(active_error);
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
                data === 'success' ? showSuccessMessage(connection_error) : showErrorMessage(active_error);
            }
        });
    });
});
