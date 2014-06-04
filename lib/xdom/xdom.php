<?php
require_once 'xelement.php';

/**
 * XDom: a simple facade for DOMDocument class from PHP
 * The intent of this is to allow someone to write less code when dealing with XML Creation.
 * XDom isn't dealing with XML reading. You can improve it if you want.
 */
class XDom {
  private $doc = null;
 
  /** 
  * private constructor to force user to use createDocument static method
  */
  private function __construct($doc) {
    $this->doc = $doc;
  }

  /**
  * create an instance of XDom agregating it with an instance of DOMDocument.
  * @return XDom
  */
  public static function createDocument() {
    $doc = new DOMDocument('1.0');
    $dom = new XDom($doc);
    return $dom;
  }

  /**
  * creates an element that may have attributes represented with an associative array.
  * @param string $name        the name of the element
  * @param array  $attributes  associative array with attribute name and attribute value respectively
  * @return XElement
  */
  public function createElement($name, $attributes = array()) {
    $el = $this->doc->createElement($name);
    foreach ($attributes as $attr_name => $attr_value) {
      $el->setAttribute($attr_name, $attr_value);
    }
    
    $xelement = new XElement($this->doc, $el);
    
    return $xelement;
  }

  /**
   * append the <code>$el</code> to the DOMDocument encapsulated by XDom.
   * @param Element $el the element to be appended within the document.
   * @return void
  */
  public function appendToDocument($el) {
    $this->doc->appendChild($el);
  }

  /**
   * appends an element inside another element.
   * @param Element $el                  element that will receive another element to append
   * @param Element $element_to_append   element to be inserted within the first Element
   * @return void
  */
  public function appendChildTo($el, $element_to_append) {
    $el->appendChild($element_to_append);
  }

  /**  
   * returns xml as string (as an HTML)
   * @return string
  */
  public function saveHTML() {
    return $this->doc->saveHTML();
  }

  /**  
   * returns xml as string
   * @return string
  */
  public function saveXML() {
    return $this->doc->saveXML();
  }

}

