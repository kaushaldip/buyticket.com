/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) 
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	 config.uiColor = '#D3D3D3';
     //config.width = 850;     // 850 pixels wide.
     config.width = '60%';   // CSS unit.
	 config.allowedContent = true;
    //config.filebrowserImageUploadUrl = siteName+'/admin/upload.php',
    config.filebrowserImageWindowWidth = '640',
    config.filebrowserImageWindowHeight = '480'
//         config.format_div = { element: 'div', attributes: { 'class': 'normalDiv' } };
//         config.format_h1 = { element: 'h1', attributes: { 'class': 'contentTitle1' } };
//         config.format_h2 = { element: 'h2', attributes: { 'class': 'contentTitle2' } };
//         config.format_h3 = { element: 'h3', attributes: { 'class': 'contentTitle3' } };
//         config.format_h4 = { element: 'h4', attributes: { 'class': 'contentTitle4' } };
//         config.format_h5 = { element: 'h5', attributes: { 'class': 'contentTitle5' } };
   // config.removeButtons = 'Underline,JustifyCenter,About';
    config.entities  = false;
    config.basicEntities = false;
    config.entities_greek = false;
    config.entities_latin = false;
    
         
};
