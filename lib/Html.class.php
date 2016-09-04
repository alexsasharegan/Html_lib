<?php

class Html {

  public  $tagName    = 'div',
          $classNames = [],
          $attributes = [],
          $styles     = [],
          $content    = '',
          $children   = [];

  public static function createElement( $tagName, $content, $attributes = null ) {
    $newAttributes = '';

    if ( !empty($attributes) ) {
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

  function __construct( $tagName, $content = '' ) {
    $this->tagName = $tagName;
    $this->content = $content;

    return $this;
  }

  public function addClass( $className ) {
    if ( !in_array($className, $this->classNames) ) {
      array_push( $this->classNames, $className );
    }

    return $this;
  }

  public function addAttribute( $name, $value ) {
    array_push( $this->attributes, Html::createAttribute( $name, $value ) );

    return $this;
  }

  public function addText( $text ) {
    $this->content = $text;

    return $this;
  }

  public function createChild( $tagName ) {
    $child = new Html( $tagName );
    $this->children[] = $child;

    return $child;
  }

  public function render() {
    return (
      '<'
      . implode( ' ', [
          $this->tagName,
          implode( ' ', [ 'class="', $this->classNames], '"' ),
          implode( ' ', $this->attributes ),
          implode( ';', $this->styles ),
        ])
      . '>'
      . $this->content
      . implode( '', array_map( 'Html::renderNode', $this->children ) )
      . '</'
      . $this->tagName
      . '>'
    );
  }

  public function __toString() {
    return $this->render();
  }

}
