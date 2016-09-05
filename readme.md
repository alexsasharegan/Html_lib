# Html_lib
### A library for creating Html via chainable PHP objects.
- - - -

#### Methods

```php
<?php

require_once 'path/to/Html_lib/Html_Autoloader.php';

// Instantiation
$div = new Html; # defaults to an empty 'div'
$button = new Html('button'); # specify the tagName
$p = new Html('p', 'This is a paragraph with some content.'); # specify inner element text

// Adding classes
$div = new Html; # create a new div
$div->addClass('item'); # add class .item
$div->addClasses(['col-lg-3', 'col-md-4', 'col-sm-6']); # add multiple classes using an array

// Adding attributes
$input = new Html('input'); # create a new input
$input->addAttribute('type', 'text'); # add type="text" attr
$input->addAttributes(['required' => true, 'pattern' => '[a-zA-Z]']); # add an array of attrs

// Adding styles
$p = new Html('p'); # create a new paragraph
$p->addStyle('color', 'red'); # set color to red
$p->addStyles(['font-size' => '1.2em', 'text-transform' => 'uppercase',]); # set an array of inline styles

// Chaining
$parentDiv = new Html;
$parentDiv->addStyle('color', 'red')
    ->addAttributes([ 'data-toggle' => 'tooltip', 'title' => 'This is my tooltip!' ])
    ->addClass('awesome');
// <div class="awesome" data-toggle="tooltip" title="This is my tooltip!" style="color:red"></div>

// now lets give it child elements
$parentDiv->createChild('h3', 'Chaining');
$parentDiv->createChild('p', 'This is some awesome chaining!');
$childForm = $parentDiv->createChild('form')->addAttribute('method', 'POST');
$childForm->createChild('input')->addAttribute('type', 'text');
$childForm->createChild('button', 'Send')->addAttribute('type', 'submit');

echo $parentDiv;
//  <div class="awesome" data-toggle="tooltip" title="This is my tooltip!"
//  style="color:red">
//    <h3>Chaining</h3>
//    <p>This is some awesome chaining!</p>
//    <form method="POST">
//      <input type="text">
//      <button type="submit">Send</button>
//    </form>
//  </div>
```
