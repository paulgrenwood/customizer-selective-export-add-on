<?php

/**
*Themainexport/importclass.
*
*@since0.1
*/
finalclassCEI_Core{

	/**
	*Anarrayofcoreoptionsthatshouldn'tbeimported.
	*
	*@since0.3
	*@accessprivate
	*@vararray$core_options
	*/
	staticprivate$core_options=array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);
	
	staticprivate$keys_optout__typography=array(
		'fl-topbar-bg-color',
		'fl-topbar-text-color',
		'fl-topbar-link-color',
		'fl-topbar-hover-color',
		'fl-header-bg-color',
		'fl-header-text-color',
		'fl-header-link-color',
		'fl-header-hover-color',
		'fl-nav-bg-color',
		'fl-nav-text-color',
		'fl-nav-link-color',
		'fl-nav-hover-color',
		'fl-footer-widgets-bg-color',
		'fl-footer-widgets-text-color',
		'fl-footer-widgets-link-color',
		'fl-footer-widgets-hover-color',
		'fl-footer-bg-color',
		'fl-footer-text-color',
		'fl-footer-link-color',
		'fl-footer-hover-color',
		'nav_menu_locations',
		'custom_css_post_id',
		'gwstandard__intro_text__font_size',
		'gwstandard__body_font__margin_bottom',
		'gwstandard__intro_text__margin_bottom',
		'gwstandard__small_text__line_height',
		'gwstandard__small_text__margin_bottom',
		'fl-content-width',
		'fl-body-bg-color',
		'fl-button-style',
		'b42s__blockquote__color',
		'fl-title-text-color',
		'fl-body-text-color',
		'fl-heading-text-color'
	);
	
	/**
	*Loadatranslationforthisplugin.
	*
	*@since0.1
	*@returnvoid
	*/
	staticpublicfunctionload_plugin_textdomain()
	{
		load_plugin_textdomain('customizer-export-import',false,basename(CEI_PLUGIN_DIR).'/lang/');
	}

	/**
	*Checktoseeifweneedtodoanexportorimport.
	*Thisshouldbecalledbythecustomize_registeraction.
	*
	*@since0.1
	*@since0.3Passing$wp_customizetotheexportandimportmethods.
	*@paramobject$wp_customizeAninstanceofWP_Customize_Manager.
	*@returnvoid
	*/
	staticpublicfunctioninit($wp_customize)
	{
		if(current_user_can('edit_theme_options')){

			if(isset($_REQUEST['cei-export'])){
				$type=$_REQUEST['cei-export-type']?:'all';
				self::_export($wp_customize,$type);
			}
			if(isset($_REQUEST['cei-import'])&&isset($_FILES['cei-import-file'])){
				self::_import($wp_customize);
			}
		}
	}

	/**
	*Printsscriptsforthecontrol.
	*
	*@since0.1
	*@returnvoid
	*/
	staticpublicfunctioncontrols_print_scripts()
	{
		global$cei_error;

		if($cei_error){
			echo'<script>alert("'.$cei_error.'");</script>';
		}
	}

	/**
	*Enqueuesscriptsforthecontrol.
	*
	*@since0.1
	*@returnvoid
	*/
	staticpublicfunctioncontrols_enqueue_scripts()
	{
		//Register
		wp_register_style('cei-css',CEI_PLUGIN_URL.'css/customizer.css',array(),CEI_VERSION);
		wp_register_script('cei-js',CEI_PLUGIN_URL.'js/customizer.js',array('jquery'),CEI_VERSION,true);

		//Localize
		wp_localize_script('cei-js','CEIl10n',array(
			'emptyImport'	=>__('Pleasechooseafiletoimport.','customizer-export-import')
		));

		//Config
		wp_localize_script('cei-js','CEIConfig',array(
			'customizerURL'	=>admin_url('customize.php'),
			'exportNonce'	=>wp_create_nonce('cei-exporting')
		));

		//Enqueue
		wp_enqueue_style('cei-css');
		wp_enqueue_script('cei-js');
	}

	/**
	*Registersthecontrolwiththecustomizer.
	*
	*@since0.1
	*@paramobject$wp_customizeAninstanceofWP_Customize_Manager.
	*@returnvoid
	*/
	staticpublicfunctionregister($wp_customize)
	{
		require_onceCEI_PLUGIN_DIR.'classes/class-cei-control.php';

		//Addtheexport/importsection.
		$wp_customize->add_section('cei-section',array(
			'title'	=>__('Export/Import','customizer-export-import'),
			'priority'=>10000000
		));

		//Addtheexport/importsetting.
		$wp_customize->add_setting('cei-setting',array(
			'default'=>'',
			'type'	=>'none'
		));

		//Addtheexport/importcontrol.
		$wp_customize->add_control(newCEI_Control(
			$wp_customize,
			'cei-setting',
			array(
				'section'	=>'cei-section',
				'priority'	=>1
			)
		));
	}

	/**
	*Exportcustomizersettings.
	*
	*@since0.1
	*@since0.3Added$wp_customizeparamandexportingofoptions.
	*@accessprivate
	*@paramobject$wp_customizeAninstanceofWP_Customize_Manager.
	*@returnvoid
	*/
	staticprivatefunction_export($wp_customize,$selective_type)
	{
		if(!wp_verify_nonce($_REQUEST['cei-export'],'cei-exporting')){
			return;
		}

		$theme		=get_stylesheet();
		$template	=get_template();
		$charset	=get_option('blog_charset');
		$mods		=get_theme_mods();
		$data		=array(
						'template'=>$template,
						'mods'	=>$mods?$mods:array(),
						'options'	=>array()
					);
					
		$select_type=$selective_type?:'all';

		//GetoptionsfromtheCustomizerAPI.
		$settings=$wp_customize->settings();
		
		if($select_type=='typography'){
			
			$data['options']['export-type']='typography';
			
			//error_log(print_r($mods,true));
			
			unset($data['options']);
			
			
			/*foreach($keys_optin__typographyas$type_key){
				$data['type_mods'][$type_key]=$data['mods'][$type_key];
			}
			
			unset($data['mods']);*/
			
			//=============
			$keys_optin__typography=array( 'fl-body-font-size', 'fl-body-font-size_medium', 'fl-body-font-size_mobile', 'fl-body-line-height', 'fl-body-line-height_medium', 'fl-body-line-height_mobile', 'fl-body-font-family', 'fl-body-font-weight', 'b42s__body_font__margin_bottom', 'b42s__body_font__margin_bottom_medium', 'b42s__body_font__margin_bottom_mobile', 'b42s__intro_text__font_size', 'b42s__intro_text__font_size_medium', 'b42s__intro_text__font_size_mobile', 'b42s__intro_text__line_height', 'b42s__intro_text__line_height_medium', 'b42s__intro_text__line_height_mobile', 'b42s__intro_text__margin_bottom', 'b42s__intro_text__margin_bottom_medium', 'b42s__intro_text__margin_bottom_mobile', 'b42s__intro_text_alt__font_size', 'b42s__intro_text_alt__font_size_medium', 'b42s__intro_text_alt__font_size_mobile', 'b42s__intro_text_alt__line_height', 'b42s__intro_text_alt__line_height_medium', 'b42s__intro_text_alt__line_height_mobile', 'b42s__intro_text_alt__margin_bottom', 'b42s__intro_text_alt__margin_bottom_medium', 'b42s__intro_text_alt__margin_bottom_mobile', 'b42s__small_text__font_size', 'b42s__small_text__font_size_medium', 'b42s__small_text__font_size_mobile', 'b42s__small_text__line_height', 'b42s__small_text__line_height_medium', 'b42s__small_text__line_height_mobile', 'b42s__small_text__margin_bottom', 'b42s__small_text__margin_bottom_medium', 'b42s__small_text__margin_bottom_mobile', 'b42s__header_nav__font_format', 'b42s__header_nav__font_weight', 'b42s__header_nav__font_size', 'b42s__header_nav__font_size_medium', 'b42s__header_nav__font_size_mobile', 'b42s__header_nav__line_height', 'b42s__header_nav__line_height_medium', 'b42s__header_nav__line_height_mobile', 'b42s__header_nav__letter_spacing', 'b42s__header_nav__letter_spacing_medium', 'b42s__header_nav__letter_spacing_mobile', 'b42s__blockquote__font_size', 'b42s__blockquote__font_size_medium', 'b42s__blockquote__font_size_mobile', 'b42s__blockquote__line_height', 'b42s__blockquote__line_height_medium', 'b42s__blockquote__line_height_mobile', 'b42s__blockquote__margin_bottom', 'b42s__blockquote__margin_bottom_medium', 'b42s__blockquote__margin_bottom_mobile', 'fl-nav-font-family', 'fl-nav-font-weight', 'fl-nav-font-format', 'fl-nav-font-size', 'fl-heading-style', 'fl-title-font-family', 'fl-title-font-weight', 'fl-title-font-format', 'fl-heading-font-family', 'fl-heading-font-weight', 'fl-heading-font-format', 'fl-h1-font-size', 'fl-h1-font-size_medium', 'fl-h1-font-size_mobile', 'fl-h1-line-height', 'fl-h1-line-height_medium', 'fl-h1-line-height_mobile', 'fl-h1-letter-spacing', 'fl-h1-letter-spacing_medium', 'fl-h1-letter-spacing_mobile', 'fl-h2-font-size', 'fl-h2-font-size_medium', 'fl-h2-font-size_mobile', 'fl-h2-line-height', 'fl-h2-line-height_medium', 'fl-h2-line-height_mobile', 'fl-h2-letter-spacing', 'fl-h2-letter-spacing_medium', 'fl-h2-letter-spacing_mobile', 'b42s__h2__font_weight', 'b42s__h2__font_format', 'fl-h3-font-size', 'fl-h3-font-size_medium', 'fl-h3-font-size_mobile', 'fl-h3-line-height', 'fl-h3-line-height_medium', 'fl-h3-line-height_mobile', 'fl-h3-letter-spacing', 'fl-h3-letter-spacing_medium', 'fl-h3-letter-spacing_mobile', 'b42s__h3__font_weight', 'b42s__h4__font_format', 'fl-h4-font-size', 'fl-h4-font-size_medium', 'fl-h4-font-size_mobile', 'fl-h4-line-height', 'fl-h4-line-height_medium', 'fl-h4-line-height_mobile', 'fl-h4-letter-spacing', 'fl-h4-letter-spacing_medium', 'fl-h4-letter-spacing_mobile', 'b42s__h4__font_weight', 'b42s__h4__font_format', 'fl-h5-font-size', 'fl-h5-font-size_medium', 'fl-h5-font-size_mobile', 'fl-h5-line-height', 'fl-h5-line-height_medium', 'fl-h5-line-height_mobile', 'fl-h5-letter-spacing', 'fl-h5-letter-spacing_medium', 'fl-h5-letter-spacing_mobile', 'b42s__h5__font_weight', 'b42s__h5__font_format', 'fl-h6-font-size', 'fl-h6-font-size_medium', 'fl-h6-font-size_mobile', 'fl-h6-line-height', 'fl-h6-line-height_medium', 'fl-h6-line-height_mobile', 'fl-h6-letter-spacing', 'fl-h6-letter-spacing_medium', 'fl-h6-letter-spacing_mobile', 'b42s__h6__font_weight', 'b42s__h6__font_format', 'fl-button-font-family', 'fl-button-font-weight', 'fl-button-font-size', 'fl-button-line-height', 'fl-button-text-transform', );
			//=============
			
			
			$data['mods'] = array_intersect_key( $mods, array_flip( $keys_optin__typography ) );
			/*$typographic_mods=array_filter(
				$mods,
				function($key)use($keys_optin__typography){
					returnin_array($key,$keys_optin__typography);
				},
				ARRAY_FILTER_USE_KEY
			);
			
			
			$data['mods']=$typographic_mods;*/
			//asdf
			//$data=array_intersect_key($mods,self::$keys_optin__typography);
			
			
/*
			foreach($data['mods']as$mod_key=>$mod_value){
				if(!in_array($mod_key,self::$keys_optin__typography)){
					unset($data['mods'][$mod_key]);
				}
			}
*/
			
			//Setthedownloadheaders(filename).
			header('Content-disposition:attachment;filename='.$theme.'_typography-export.dat');
			
			
		}elseif($select_type=='all'){
			
			$data['options']['export-type']='all';
			
			foreach($settingsas$key=>$setting){

				if('option'==$setting->type){
	
					//Don'tsavewidgetdata.
					if('widget_'===substr(strtolower($key),0,7)){
						continue;
					}
	
					//Don'tsavesidebardata.
					if('sidebars_'===substr(strtolower($key),0,9)){
						continue;
					}
					
					//Don'tsavecoreoptions.
					if(in_array($key,self::$core_options)){
						continue;
					}
	
					$data['options'][$key]=$setting->value();
				}
			}
			
			//Plugindeveloperscanspecifyadditionaloptionkeystoexport.
			$option_keys=apply_filters('cei_export_option_keys',array());
	
			foreach($option_keysas$option_key){
				$data['options'][$option_key]=get_option($option_key);
			}
	
			if(function_exists('wp_get_custom_css_post')){
				$data['wp_css']=wp_get_custom_css();
			}
			
			//Setthedownloadheaders(filename).
			header('Content-disposition:attachment;filename='.$theme.'_full-export.dat');
		}

		//Setthedownloadheaders(content-type).
		header('Content-Type:application/octet-stream;charset='.$charset);

		//Serializetheexportdata.
		echoserialize($data);

		//Startthedownload.
		die();
	}

	/**
	*ImportsuploadedmodsandcallsWordPresscorecustomize_saveactionsso
	*themesthathookintothemcanactbeforemodsaresavedtothedatabase.
	*
	*@since0.1
	*@since0.3Added$wp_customizeparamandimportingofoptions.
	*@accessprivate
	*@paramobject$wp_customizeAninstanceofWP_Customize_Manager.
	*@returnvoid
	*/
	staticprivatefunction_import($wp_customize)
	{
		//Makesurewehaveavalidnonce.
		if(!wp_verify_nonce($_REQUEST['cei-import'],'cei-importing')){
			return;
		}

		//MakesureWordPressuploadsupportisloaded.
		if(!function_exists('wp_handle_upload')){
			require_once(ABSPATH.'wp-admin/includes/file.php');
		}

		//Loadtheexport/importoptionclass.
		require_onceCEI_PLUGIN_DIR.'classes/class-cei-option.php';

		//Setupglobalvars.
		global$wp_customize;
		global$cei_error;

		//Setupinternalvars.
		$cei_error	=false;
		$template	=get_template();
		$overrides=array('test_form'=>false,'test_type'=>false,'mimes'=>array('dat'=>'text/plain'));
		$file=wp_handle_upload($_FILES['cei-import-file'],$overrides);

		//Makesurewehaveanuploadedfile.
		if(isset($file['error'])){
			$cei_error=$file['error'];
			return;
		}
		if(!file_exists($file['file'])){
			$cei_error=__('Errorimportingsettings!Pleasetryagain.','customizer-export-import');
			return;
		}

		//Gettheuploaddata.
		$raw=file_get_contents($file['file']);
		$data=@unserialize($raw);

		//Removetheuploadedfile.
		unlink($file['file']);

		//Datachecks.
		if('array'!=gettype($data)){
			$cei_error=__('Errorimportingsettings!Pleasecheckthatyouuploadedacustomizerexportfile.','customizer-export-import');
			return;
		}
		if(!isset($data['template'])||!isset($data['mods'])){
			$cei_error=__('Errorimportingsettings!Pleasecheckthatyouuploadedacustomizerexportfile.','customizer-export-import');
			return;
		}
		if($data['template']!=$template){
			$cei_error=__('Errorimportingsettings!Thesettingsyouuploadedarenotforthecurrenttheme.','customizer-export-import');
			return;
		}

		//Importimages.
		if(isset($_REQUEST['cei-import-images'])){
			$data['mods']=self::_import_images($data['mods']);
		}

		//Importcustomoptions.
		if(isset($data['options'])){

			foreach($data['options']as$option_key=>$option_value){

				$option=newCEI_Option($wp_customize,$option_key,array(
					'default'		=>'',
					'type'			=>'option',
					'capability'	=>'edit_theme_options'
				));

				$option->import($option_value);
			}
		}

		//Ifwp_cssissetthenimportit.
		if(function_exists('wp_update_custom_css_post')&&isset($data['wp_css'])&&''!==$data['wp_css']){
			wp_update_custom_css_post($data['wp_css']);
		}

		//Callthecustomize_saveaction.
		do_action('customize_save',$wp_customize);

		//Loopthroughthemods.
		foreach($data['mods']as$key=>$val){

			//Callthecustomize_save_dynamicaction.
			do_action('customize_save_'.$key,$wp_customize);

			//Savethemod.
			set_theme_mod($key,$val);
		}

		//Callthecustomize_save_afteraction.
		do_action('customize_save_after',$wp_customize);
	}

	/**
	*Importsimagesforsettingssavedasmods.
	*
	*@since0.1
	*@accessprivate
	*@paramarray$modsAnarrayofcustomizermods.
	*@returnarrayThemodsarraywithanynewimportdata.
	*/
	staticprivatefunction_import_images($mods)
	{
		foreach($modsas$key=>$val){

			if(self::_is_image_url($val)){

				$data=self::_sideload_image($val);

				if(!is_wp_error($data)){

					$mods[$key]=$data->url;

					//Handleheaderimagecontrols.
					if(isset($mods[$key.'_data'])){
						$mods[$key.'_data']=$data;
						update_post_meta($data->attachment_id,'_wp_attachment_is_custom_header',get_stylesheet());
					}
				}
			}
		}

		return$mods;
	}

	/**
	*Takenfromthecoremedia_sideload_imagefunctionand
	*modifiedtoreturnanarrayofdatainsteadofhtml.
	*
	*@since0.1
	*@accessprivate
	*@paramstring$fileTheimagefilepath.
	*@returnarrayAnarrayofimagedata.
	*/
	staticprivatefunction_sideload_image($file)
	{
		$data=newstdClass();

		if(!function_exists('media_handle_sideload')){
			require_once(ABSPATH.'wp-admin/includes/media.php');
			require_once(ABSPATH.'wp-admin/includes/file.php');
			require_once(ABSPATH.'wp-admin/includes/image.php');
		}
		if(!empty($file)){

			//Setvariablesforstorage,fixfilefilenameforquerystrings.
			preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i',$file,$matches);
			$file_array=array();
			$file_array['name']=basename($matches[0]);

			//Downloadfiletotemplocation.
			$file_array['tmp_name']=download_url($file);

			//Iferrorstoringtemporarily,returntheerror.
			if(is_wp_error($file_array['tmp_name'])){
				return$file_array['tmp_name'];
			}

			//Dothevalidationandstoragestuff.
			$id=media_handle_sideload($file_array,0);

			//Iferrorstoringpermanently,unlink.
			if(is_wp_error($id)){
				@unlink($file_array['tmp_name']);
				return$id;
			}

			//Buildtheobjecttoreturn.
			$meta					=wp_get_attachment_metadata($id);
			$data->attachment_id	=$id;
			$data->url				=wp_get_attachment_url($id);
			$data->thumbnail_url	=wp_get_attachment_thumb_url($id);
			$data->height			=$meta['height'];
			$data->width			=$meta['width'];
		}

		return$data;
	}

	/**
	*Checkstoseewhetherastringisanimageurlornot.
	*
	*@since0.1
	*@accessprivate
	*@paramstring$stringThestringtocheck.
	*@returnboolWhetherthestringisanimageurlornot.
	*/
	staticprivatefunction_is_image_url($string='')
	{
		if(is_string($string)){

			if(preg_match('/\.(jpg|jpeg|png|gif)/i',$string)){
				returntrue;
			}
		}

		returnfalse;
	}
}
