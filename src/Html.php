<?php

namespace Html;

/**
 * Class Html
 * @package Html
 */
class Html {
	
	/**
	 * @var string
	 */
	private $tagName = 'div';
	/**
	 * @var string
	 */
	private $id = '';
	/**
	 * @var array
	 */
	private $classNames = [];
	/**
	 * @var array
	 */
	private $attributes = [];
	/**
	 * @var array
	 */
	private $styles = [];
	/**
	 * @var string
	 */
	private $content = '';
	/**
	 * @var array
	 */
	private $children = [];
	
	/**
	 * Statically creates an html element string.
	 *
	 * @param string $tagName
	 * @param string $content
	 * @param null   $attributes
	 *
	 * @return string
	 */
	public static function createElement( $tagName = 'div', $content = '', $attributes = NULL )
	{
		$newAttributes = '';
		
		if ( ! empty($attributes) && is_array( $attributes ) )
		{
			$mappedAttributes = [];
			foreach ( $attributes as $name => $value )
			{
				$mappedAttributes[] = self::createAttribute( $name, $value );
			}
			$newAttributes = implode( ' ', $mappedAttributes );
		}
		
		return "<$tagName $newAttributes>$content</$tagName>";
	}
	
	/**
	 * Statically create an attribute.
	 * Just returns the attribute string.
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return string
	 */
	public static function createAttribute( $name, $value )
	{
		if ( empty($value) )
		{
			return '';
		}
		else
		{
			return sprintf( '%s="%s"', (string) $name, (string) $value );
		}
	}
	
	/**
	 * Renders an instance of Html.
	 * Used for recursively rendering instances with children.
	 *
	 * @param Html $el
	 *
	 * @return string
	 */
	public static function renderNode( Html $el )
	{
		return $el->render();
	}
	
	/**
	 * Html constructor.
	 *
	 * @param string $tagName
	 * @param string $content
	 */
	function __construct( $tagName = 'div', $content = '' )
	{
		$this->tagName = $tagName;
		$this->content = $content;
	}
	
	/**
	 * Define the element's id attribute.
	 *
	 * @param $id
	 *
	 * @return Html $this
	 */
	public function id( $id )
	{
		$this->id = (string) $id;
		
		return $this;
	}
	
	/**
	 * @return string|void
	 */
	public function getId()
	{
		if ( ! empty($this->id) )
		{
			return "id=\"{$this->id}\"";
		}
		
		return '';
	}
	
	/**
	 * Add a single class to an element.
	 *
	 * @param $className
	 *
	 * @return Html $this
	 */
	public function addClass( $className )
	{
		if ( ! in_array( $className, $this->classNames ) )
		{
			array_push( $this->classNames, $className );
		}
		
		return $this;
	}
	
	/**
	 * Add an array of classes to an element.
	 *
	 * @param array $classList
	 *
	 * @return Html $this
	 */
	public function addClasses( array $classList )
	{
		array_map( [ $this, 'addClass' ], $classList );
		
		return $this;
	}
	
	/**
	 * @return string|void
	 */
	private function getClasses()
	{
		if ( ! empty($this->classNames) )
		{
			return 'class="' . implode( ' ', $this->classNames ) . '"';
		}
		else
		{
			return '';
		}
	}
	
	/**
	 * Add an attribute to an element.
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return Html $this
	 */
	public function addAttribute( $name, $value )
	{
		array_push( $this->attributes, self::createAttribute( $name, $value ) );
		
		return $this;
	}
	
	/**
	 * Add an array of attributes to an element.
	 *
	 * @param array $attributeList
	 *
	 * @return Html $this
	 */
	public function addAttributes( array $attributeList )
	{
		foreach ( $attributeList as $name => $value )
		{
			$this->addAttribute( $name, $value );
		}
		
		return $this;
	}
	
	/**
	 * @return string|void
	 */
	private function getAttributes()
	{
		if ( ! empty($this->attributes) )
		{
			return implode( ' ', $this->attributes );
		}
		else
		{
			return '';
		}
	}
	
	/**
	 * Add a style to an element.
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return Html $this
	 */
	public function addStyle( $name, $value )
	{
		array_push( $this->styles, "$name:$value" );
		
		return $this;
	}
	
	/**
	 * Add an array of styles to an element.
	 *
	 * @param array $styleList
	 *
	 * @return Html $this
	 */
	public function addStyles( array $styleList )
	{
		foreach ( $styleList as $name => $value )
		{
			$this->addStyle( $name, $value );
		}
		
		return $this;
	}
	
	/**
	 * @return string|void
	 */
	public function getStyles()
	{
		if ( ! empty($this->styles) )
		{
			return 'style="' . implode( ';', $this->styles ) . '"';
		}
		else
		{
			return '';
		}
	}
	
	/**
	 * Append content to the elements content body.
	 *
	 * @param $newContent
	 *
	 * @return Html $this
	 */
	public function append( $newContent )
	{
		$this->content .= $newContent;
		
		return $this;
	}
	
	/**
	 * Prepend content to the element's content body.
	 *
	 * @param $newContent
	 *
	 * @return Html $this
	 */
	public function prepend( $newContent )
	{
		$this->content = $newContent . $this->content;
		
		return $this;
	}
	
	/**
	 * Initialize the element's content body.
	 *
	 * @param $newContent
	 *
	 * @return Html $this
	 */
	public function setContent( $newContent )
	{
		$this->content = $newContent;
		
		return $this;
	}
	
	/**
	 * Instantiates a new element instance,
	 * pushes it on to the parent's array of children,
	 * and returns the newly created child instance.
	 *
	 * @param string $tagName
	 * @param string $content
	 *
	 * @return Html
	 */
	public function newChild( $tagName = 'div', $content = '' )
	{
		$child            = new Html( $tagName, $content );
		$this->children[] = $child;
		
		return $child;
	}
	
	/**
	 * Render the child elements (recursive).
	 *
	 * @return string
	 */
	public function renderChildren()
	{
		return implode( '', array_map( '\Html\Html::renderNode', $this->children ) );
	}
	
	/**
	 * Render the element object to an html string.
	 *
	 * @return string
	 */
	public function render()
	{
		return (
			'<'
			. implode( ' ', [
				$this->tagName,
				$this->getId(),
				$this->getClasses(),
				$this->getAttributes(),
				$this->getStyles(),
			] )
			. '>'
			. $this->content
			. $this->renderChildren()
			. "</{$this->tagName}>"
		);
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
	
}
