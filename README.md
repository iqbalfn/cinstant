Cinstant
====

Convert HTML main article to be valid Facebook Instant Article. Please note that
this library is not meant to convert entirely HTML document to Instant Article.
Use the library to convert main article of the page only, as in most case main
article is the part where you generated it by WYSIWYG ( ex: tinymce ). Another
HTML part should rewrite to fullfill Instant Article specifications.

Due to complicated processing in background, I suggest you to not to use the
library for every user request. Cache the result or save it to DB instead of
convert it everytime user ask for it.

Usage
-----

```php
<?php

require_once '/path/to/Cinstant.php';

$html = '<div id="main-content">...</div>';
$options = array(...);

$content = new Cinstant($html, $options);

echo $content->article;
```

Methods
-------

### setOptions ( string|array `$key`, mixed `$value` )

Set the options value

```php
<?php

// #1
$options = array(
    'localHost' => 'http://localhost'
);

$cinstant->setOptions($options);

// #2
$cinstant->setOptions('localHost', 'http://localhost');
```

### convert ( string `$html`, array `$options` )

Start convert the content.

```php
<?php

// #1

$html = '<div id="main-content">...</div>';
$opts = array(...);

$cinstant = new Cinstant($html, $opts);

echo $cinstant->article;

// #2

$cinstant = new Cinstant;

$cinstant->html = '<div id="main-content">...</div>';
$cinstant->setOptions(...);

$cinstant->convert();

echo $cinstant->article;
```

Properties
----------

List of `Cinstant` properties.

### html *string*

Original HTML of the content.

### article *string*

The converted article of the html.

Options
-------

List of options that `Cinstant` understand and use during conversion.

### localHost *string*

Set the relative media path to be absolute to this domain.

```php

$cins = new Cinstant;
$cins->html = '<img src="/relative/path/to/image.jpg">';
$cins->setOptions('localHost', 'http://example.com/');

// the syntax like `<img src="/media/image.jpg">`
// converted to `<img src="http://example.com/media/image.jpg">`
```

### assetFeedback

The status of assets feedback, it accept boolean `false` or string `fb:none` to 
disable all feedback on asset. Otherwise it also accept value string `fb:likes`, 
`fb:comments` or `fb:likes fb:comments` to enable any of them, or simply boolean
`true` to enable all.

```php

$cins = new Cinstant;
$cins->html = '<img src="/relative/path/to/image.jpg">';

// the syntax like `<img src="http://example.com/media/image.jpg">`

$cins->setOptions('assetFeedback', true);
// converted to `<figure data-feedback="fb:likes fb:comments"><img src="http://example.com/media/image.jpg"></figure>`

$cins->setOptions('assetFeedback', false);
// converted to `<figure data-feedback="fb:none"><img src="http://example.com/media/image.jpg"></figure>`

$cins->setOptions('assetFeedback', 'fb:likes');
// converted to `<figure data-feedback="fb:likes"><img src="http://example.com/media/image.jpg"></figure>`
```

Dependencies
------------

1. [html5lib-php](https://github.com/html5lib/html5lib-php)  
Not to mention PHP 7.0.3, they still have no idea how to read HTML5 syntax.

Contribute
----------

This project is under MIT license, and hosted on github. You know what is that mean,
don't you?

Todo
----

2. [map](https://developers.facebook.com/docs/instant-articles/reference/map)
3. [slideshow](https://developers.facebook.com/docs/instant-articles/reference/slideshow)
4. video
5. [figcaption position](https://developers.facebook.com/docs/instant-articles/reference/caption)

Bug?
----

You know, just report it.