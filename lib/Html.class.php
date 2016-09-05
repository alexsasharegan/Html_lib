<?php

class Html {

  private $tagName    = 'div',
          $id         = '',
          $classNames = [],
          $attributes = [],
          $styles     = [],
          $content    = '',
          $children   = [];

  public static function createElement( $tagName, $content, $attributes = null ) {
    $newAttributes = '';

    if ( !empty($attributes) && is_array( $attributes ) ) {
      $mappedAttributes = [];
      foreach ($attributes as $name => $value) {
        $mappedAttributes[] = Html::createAttribute( $name, $value );
      }
      $newAttributes = implode( ' ', $mappedAttributes );
    }

    return "<$tagName $newAttributes>$content</$tagName>";
  }

  public static function createAttribute( $name, $value ) {
    if ( empty($value) ) {
      return '';
    } else {
      return "{$name}=\"{$value}\"";
    }
  }

  public static function renderNode(Html $el) {
    return $el->render();
  }

  function __construct( $tagName = 'div', $content = '' ) {
    $this->tagName = $tagName;
    $this->content = $content;
  }

  public function id( $id ) {
    $this->id = $id;
    return $this;
  }

  public function getId() {
    if ( !empty( $this->id ) ) {
      return "id=\"{$this->id}\"";
    }
    return;
  }

  public function addClass( $className ) {
    if ( !in_array($className, $this->classNames) ) {
      array_push( $this->classNames, $className );
    }
    return $this;
  }

  public function addClasses( array $classList ) {
    array_map( [$this, 'addClass'], $classList );
    return $this;
  }

  private function getClasses() {
    if ( !empty($this->classNames) ) {
      return 'class="' . implode( ' ', $this->classNames ) . '"';
    } else {
      return;
    }
  }

  public function addAttribute( $name, $value ) {
    array_push( $this->attributes, Html::createAttribute( $name, $value ) );
    return $this;
  }

  public function addAttributes( array $attributeList ) {
    foreach ($attributeList as $name => $value) {
      $this->addAttribute( $name, $value );
    }
    return $this;
  }

  private function getAttributes() {
    if ( !empty($this->attributes) ) {
      return implode( ' ', $this->attributes );
    } else {
      return;
    }
  }

  public function addStyle( $name, $value ) {
    array_push( $this->styles, "$name:$value" );
    return $this;
  }

  public function addStyles( array $styleList ) {
    foreach ( $styleList as $name => $value ) {
      $this->addStyle( $name, $value );
    }
    return $this;
  }

  public function getStyles() {
    if ( !empty($this->styles) ) {
      return 'style="' . implode( ';', $this->styles ) . '"';
    } else {
      return;
    }
  }

  public function addText( $text ) {
    $this->content = $text;
    return $this;
  }

  public function createChild( $tagName, $content = '' ) {
    $child = new Html( $tagName, $content );
    $this->children[] = $child;
    return $child;
  }

  public function renderChildren() {
    return implode( '', array_map( 'Html::renderNode', $this->children ) );
  }

  public function render() {
    return (
      '<'
      . implode( ' ', [
          $this->tagName,
          $this->getId(),
          $this->getClasses(),
          $this->getAttributes(),
          $this->getStyles(),
        ])
      . '>'
      . $this->content
      . $this->renderChildren()
      . "</{$this->tagName}>"
    );
  }

  public function __toString() {
    return $this->render();
  }

}
