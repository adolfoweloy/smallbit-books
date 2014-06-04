<?php
class ImageUpload {
	private $invalidImageFile = FALSE;
	private $invalidImageType = FALSE;
	private $invalidImageSize = FALSE;
	
	public $width = 0;
	public $height = 0;
	
	public function setInvalidImageFile($InvalidImageFile) {
		$this->invalidImageFile = $InvalidImageFile;
		return $this;
	}
	
	public function getInvalidImageFile() {
		return $this->invalidImageFile;
	}
	
	public function setInvalidImageType($InvalidImageType) {
		$this->invalidImageType = $InvalidImageType;
		return $this;
	}
	
	public function getInvalidImageType() {
		return $this->invalidImageType;
	}
	
	public function setInvalidImageSize($InvalidImageSize) {
		$this->invalidImageSize = $InvalidImageSize;
		return $this;
	}
	
	public function getInvalidImageSize() {
		return $this->invalidImageSize;
	}
	
}