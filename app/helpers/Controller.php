<?php
/**
 * Defines a controller which have direct access to view template instance.
 */
class Controller {
    /** 
     * @var Smarty
     */
    protected $view = null;
    
    /**
     * @var SEO data (title and description metatag)
     */
    protected $seo_info = null;
    
    /**
     * All controllers must have index to avoid no such method invocation
     * when developer forgive to implement a method for his controller.
     */
    public function index() {}
    
    /**
     * allows for ControllerManager to send the smarty instance.
     * @param Smarty $smarty 
     */
    public function setView($smarty) {
        $this->view = $smarty;
    }
    
    /**
     * Retrieves current view template.
     * @return Smarty
     */
    public function getView() {
        return $this->view;
    }

    public function setSeoInfo($SeoInfo)
    {
    	$this->seo_info = $SeoInfo;
    	return $this;
    }
    
    public function getSeoInfo()
    {
    	return $this->seo_info;
    }
    
}
?>
