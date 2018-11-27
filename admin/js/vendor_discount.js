$(function () {

    var $table = $('.vendor-discount');

    $('.add-vendor-discount').click(function () {

        var lastId = $table.find('tbody tr:last-child').data('id');

        lastId = lastId ? lastId : 0;

        $table.append(template_row(lastId + 1));

        return false;
    });


    function template_row(id) {

        return '<tr data-id="'+id+'">'+
                    '<td><input type="text" name="discount['+id+'][value]"></td>'+
                    '<td><input type="text" name="discount['+id+'][quantity]"></td>'+
                    '<td>'+
                        '<a href="#" class="remove"><img src="img/del16.gif" alt="уд." title="удалить" align="absmiddle"></a>'+
                    '</td>'+
                '</tr>';

    }

    $table.delegate('.remove', 'click', function () {

        $(this).closest('tr').remove();

        return false;
    });

});