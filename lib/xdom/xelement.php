<?php 

class XElement {
	/** @var DOMDocument */
	private $doc = null;

	/** @var Element */
	private $element = null;
	
	/**
	 * Constructor
	 * @param DOMDocument $doc
	 * @param Element $element
	 */
	public function __construct($doc, $element) {
		$this->doc = $doc;
		$this->element = $element;	
	}
	
	/**
	 * Retrieves the Dom Element instance which is encapsulated by XElement
	 * return Element
	 */
	protected function getDomElement() {
		return $this->element;	
	}
	
	/**
	 * Append its encapsulated Dom Element to the document.
	 * @return XElement
	 */
	public function appendToDocument() {
		$this->doc->appendChild($this->element);
		return $this;
	}
	
	/**
	 * Append an element within other element
	 * @param XElement $xelement XElement created by XDom
	 */
	public function appendChild($xelement) {
		$element = $xelement->getDomElement();
		$this->element->appendChild($element);
		return $this;
	}
	
	/**
	 * Add text content to the element
	 * @param string $text
	 * @return XElement
	 */
	public function appendText($text) {
		$text_node = $this->doc->createTextNode($text);
		$this->element->appendChild($text_node);
		return $this;
	}
	
}