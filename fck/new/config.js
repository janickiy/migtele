/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */


CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// config.contentsCss = 'fonts.css';
	// config.font_names = 'Arial;Times New Roman;Verdana';
	config.language = 'ru';
    config.extraPlugins = 'migtele_delivery_block,migtele_payment_block';
    config.extraAllowedContent = '*[*]{*}(*)';
};

