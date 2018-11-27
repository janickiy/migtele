$(function () {

    $.fn.select2.amd.define('select2/i18n/ru',[],function () {
        // Russian
        return {
            errorLoading: function () {
                return '��������� �� ����� ���� ��������.';
            },
            inputTooLong: function (args) {
                var overChars = args.input.length - args.maximum;
                var message = '����������, ������� ' + overChars + ' ������';
                if (overChars >= 2 && overChars <= 4) {
                    message += '�';
                } else if (overChars >= 5) {
                    message += '��';
                }
                return message;
            },
            inputTooShort: function (args) {
                var remainingChars = args.minimum - args.input.length;

                var message = '����������, ������� ' + remainingChars + ' ��� ����� ��������';

                return message;
            },
            loadingMore: function () {
                return '��������� ��� ��������';
            },
            maximumSelected: function (args) {
                var message = '�� ������ ������� ' + args.maximum + ' �������';

                if (args.maximum  >= 2 && args.maximum <= 4) {
                    message += '�';
                } else if (args.maximum >= 5) {
                    message += '��';
                }

                return message;
            },
            noResults: function () {
                return '������ �� �������';
            },
            searching: function () {
                return '�����';
            }
        };
    });



    $('.interested-products').select2({
        language: "ru",
        ajax: {
            url: '/admin/goods_ajax.php',
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        }
    });

    $('.cattmr-selecttest').select2({
        language: "ru"
    });




    $('.interested-products').on('select2:select', function (evt) {
        var $parent = $(this).closest('td'),
            $table = $parent.find('.interested-products-table tbody');

        add_row_in_interested_products_table($table, evt.params.data.id, evt.params.data.text);

        $(this).val('');
        $(this).trigger('change');

    });


    $('.interested-products-table').delegate('.remove_interested_product', 'click', function () {
        $(this).closest('tr').fadeOut('slow', function () {
            $(this).remove();
        });
    });




});

function add_row_in_interested_products_table($table, id, name) {
    $table.append(template_interested_product(id, name))
}

function template_interested_product(id, name) {

    return '<tr>' +
        '<td style="width: 90%">'+name+'</td>' +
        '<td><a href="#" class="remove_interested_product"><img src="img/del16.gif" hspace="2" alt="��." title="�������" align="absmiddle"></a>' +
        '<input type="hidden" name="interested_products[]" value="'+id+'">'+
        '</td>'+
        '</tr>';

}
