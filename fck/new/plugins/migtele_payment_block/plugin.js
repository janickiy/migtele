CKEDITOR.plugins.add( 'migtele_payment_block', {
    icons: 'migtele_payment',
    init: function( editor ) {

        function registerCssFile( url ) {
            var head = editor.document.getHead();
            var link = editor.document.createElement( 'link' , {
                attributes: {
                    type: 'text/css',
                    rel: 'stylesheet',
                    href: url
                }
            } );
            head.append( link );
        }


        editor.addCommand( 'migtele_payment_command', {
            exec: function( editor ) {

                editor.insertElement( createBlock() );

                init();

                //editor.insertHtml(getHtml());

            },
            allowedContent: 'span{*}(*);div{*}(*);br'
        });

        editor.ui.addButton( 'Migtele payment block', {
            label: 'Методы оплаты',
            command: 'migtele_payment_command',
            toolbar: 'insert',
            icon: 'migtele_payment'
        });


        function createBlock() {

            var block = editor.document.createElement( 'div', { 'attributes' : { 'class': 'payment-block-wrapper' } }),
                titleContainer = editor.document.createElement( 'div', { 'attributes' : { 'class': 'payment-titles' } });
            var titles = ['Наличная оплата', 'Банковскими картами', 'Электронными деньгами', 'Безналичный расчет', 'Оплатить заказ'];


            for (var i = 0; i < titles.length; i++){

                var titleWrapper = editor.document.createElement( 'div'),
                    title = editor.document.createElement( 'span', { 'attributes' : { 'data-id': i+1 } });

                if(i == 0)
                    title.addClass('active');

                title.appendText(titles[i]);
                titleWrapper.append(title);

                titleContainer.append(titleWrapper);
            }


            block.append(titleContainer);

            block.appendHtml('<div class="payment-texts">' +
                '<div data-id="1" style="display: block;">' +
                '<div class="payment-images">' +
                '</div>' +
                '<div class="payment-text"><p>Наличная оплата</p></div>' +
                '</div>' +
                '<div style="display: none;" data-id="2">' +
                '<div class="payment-images">' +
                '</div>' +
                '<div class="payment-text"><p>Банковскими картами</p></div>' +
                '</div>' +'<div style="display: none;" data-id="3">' +
                '<div class="payment-images">' +
                '</div>' +
                '<div class="payment-text"><p>Электронными деньгами</p></div>' +
                '</div>' +'<div style="display: none;" data-id="4">' +
                '<div class="payment-images">' +
                '</div>' +
                '<div class="payment-text"><p>Безналичный расчет</p></div>' +
                '</div>' +
                '<div style="display: none;" data-id="5">' +
                '<div class="payment-images">' +
                '</div>' +
                '<div class="payment-text"><p>[payment-form]</p></div>' +
                '</div>' +
                '</div>');

            return block;

        }

        function init(){

            $("iframe.cke_wysiwyg_frame").contents().find(".payment-titles span").click(function () {

                var id = $(this).data('id'),
                    $parent = $(this).closest('.payment-block-wrapper'),
                    titles = $parent.find(".payment-titles"),
                    payments = $parent.find(".payment-texts");

                payments.find('>div').hide();
                titles.find('span').removeClass('active');

                titles.find('span[data-id="'+id+'"]').addClass('active');
                payments.find('div[data-id="'+id+'"]').show();

            });

        }


        var path = this.path;
        editor.on( 'mode', function() {

            if ( this.mode != 'wysiwyg' ) {
                return;
            }

            registerCssFile( path + 'css/payment.css' );

            init();


        });

    }
});
