$(function () {

    $.fn.select2.amd.define('select2/i18n/ru',[],function () {
        // Russian
        return {
            errorLoading: function () {
                return 'Результат не может быть загружен.';
            },
            inputTooLong: function (args) {
                var overChars = args.input.length - args.maximum;
                var message = 'Пожалуйста, удалите ' + overChars + ' символ';
                if (overChars >= 2 && overChars <= 4) {
                    message += 'а';
                } else if (overChars >= 5) {
                    message += 'ов';
                }
                return message;
            },
            inputTooShort: function (args) {
                var remainingChars = args.minimum - args.input.length;

                var message = 'Пожалуйста, введите ' + remainingChars + ' или более символов';

                return message;
            },
            loadingMore: function () {
                return 'Загружаем ещё ресурсы…';
            },
            maximumSelected: function (args) {
                var message = 'Вы можете выбрать ' + args.maximum + ' элемент';

                if (args.maximum  >= 2 && args.maximum <= 4) {
                    message += 'а';
                } else if (args.maximum >= 5) {
                    message += 'ов';
                }

                return message;
            },
            noResults: function () {
                return 'Ничего не найдено';
            },
            searching: function () {
                return 'Поиск…';
            }
        };
    });

    $('#select-category').select2({
        language: "ru",
    }).on('select2:select', function (evt) {
        var $selected = $(this).find('option:selected'),
            id_cattype = $selected.data('id_cattype'),
            id_catrazdel = $selected.data('id_catrazdel');

        $('input[name="category_id"]').val(id_cattype);
        $('input[name="subcategory_id"]').val(id_catrazdel);
    });


    $('.select-categories').select2({
        language: "ru",
    }).on('select2:select', function (evt) {
        var $parent = $(this).closest('td'),
            $table = $parent.find('tbody'),
            field_name = $(this).data('field-name');

        add_row_in_table($table, evt.params.data.id, evt.params.data.text, field_name);

        $(this).val('');
        $(this).trigger('change');

    });

    $('.select2').select2({
        language: "ru",
    });



    function add_row_in_table($table, id, name, field_name) {
        $table.append(template(id, name, field_name))
    }

    function template(id, name, field_name) {

        return '<tr>' +
            '<td style="width: 90%">'+name+'</td>' +
            '<td><a href="#" class="remove_row"><img src="img/del16.gif" hspace="2" alt="уд." title="удалить" align="absmiddle"></a>' +
            '<input type="hidden" name="'+field_name+'" value="'+id+'">'+
            '</td>'+
            '</tr>';

    }

    $('.selectors-table').delegate('.remove_row', 'click', function () {
        $(this).closest('tr').fadeOut('slow', function () {
            $(this).remove();
        });
    });

});