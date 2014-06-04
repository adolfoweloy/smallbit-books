<?php
/**
 * Auxiliar class to help managing some SEO features along your web app.
 * @author adolfo
 */
class SEOHelper {
	
	public $title = '';
	public $description = '';
	
	/**
	 * Builds a SEO Helper based on a yaml file description.
	 * @param string $controller - the name of the controller 
	 * @param string $seo_config_file
	 * @return SEOHelper
	 */
	public static function build($controller, $seo_config_file) {
		$seo = Spyc::YAMLLoad($seo_config_file);
		
		if (isset($seo[$controller]) && $seo[$controller]['title'][0]) {
			$title = $seo[$controller]['title'][0];
			$description = join(' ', $seo[$controller]['description']);
		} else {
			$title = $seo['default_title'][0];	
			$description =  $seo['default_description'][0];	
		}
		
		$nseo = new SEOHelper();
		$nseo->title = $title;
		$nseo->description = $description;

		return $nseo;
	}
	
}