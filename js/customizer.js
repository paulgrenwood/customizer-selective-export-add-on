( function( $ ) {
	
	var CEI = {
	
		init: function()
		{
			console.log( 'init function has fired' );
			$( 'input[name=cei-export-typography-button]' ).on(  'click', CEI._export__typography );
			$( 'input[name=cei-export-button]' ).on( 'click', CEI._export__all );
			$( 'input[name=cei-import-button]' ).on( 'click', CEI._import );
		},
	
		_export__all: function()
		{
			console.log(  'export ALL fired' );
			window.location.href = CEIConfig.customizerURL + '?cei-export-type=all&cei-export=' + CEIConfig.exportNonce;
		},
	
		_export__typography: function()
		{
			console.log(  'export TYPE fired' );
			window.location.href = CEIConfig.customizerURL + '?cei-export-type=typography&cei-export=' + CEIConfig.exportNonce;
		},
	
		_import: function()
		{
			var win			= $( window ),
				body		= $( 'body' ),
				form		= $( '<form class="cei-form" method="POST" enctype="multipart/form-data"></form>' ),
				controls	= $( '.cei-import-controls' ),
				file		= $( 'input[name=cei-import-file]' ),
				message		= $( '.cei-uploading' );
			
			if ( '' == file.val() ) {
				alert( CEIl10n.emptyImport );
			}
			else {
				win.off( 'beforeunload' );
				body.append( form );
				form.append( controls );
				message.show();
				form.submit();
			}
		}
	};
	
	$( CEI.init );
	
})( jQuery );