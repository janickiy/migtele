CKEDITOR.plugins.add( 'migtele_delivery_block', {
    icons: 'migtele_delivery',
    init: function( editor ) {

        editor.addCommand( 'migtele_delivery_command', new CKEDITOR.dialogCommand( 'migtele_delivery_blockDialog' ) );

        editor.ui.addButton( 'Migtele delivery block', {
            label: 'Блок с фото и информацией',
            command: 'migtele_delivery_command',
            toolbar: 'insert',
            icon: 'migtele_delivery'
        });


    }
});

CKEDITOR.dialog.add( 'migtele_delivery_blockDialog', function( editor ) {

    return {
        title: 'Вставить блок',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'tab-basic',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'title',
                        label: 'Заголовок',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Поле не должно быть пустым" )
                    },
                    {
                        type: 'textarea',
                        id: 'description',
                        label: 'Текст',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Поле не должно быть пустым" )
                    }
                ]
            }
        ],
        onOk: function() {

            var dialog = this;

            var html = '<div class="delivery-list_item">' +
                '<div class="img"><img src="/fck/new/plugins/migtele_delivery_block/demo/moscow.png" alt=""></div>' +
                '<div class="info">' +
                '<a href="javascript:void(0);" class="title">'+dialog.getValueOf( 'tab-basic', 'title' )+'</a>' +
                '<div class="description">'+dialog.getValueOf( 'tab-basic', 'description' )+'</div>' +
                '</div>' +
                '</div>';

            editor.insertHtml(html);

        }
    };
});