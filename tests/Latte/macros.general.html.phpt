<?php

/**
 * Test: Latte\Engine: general HTML test.
 *
 * @author     David Grudl
 */

use Latte\Runtime\Html,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$latte = new Latte\Engine;
$latte->setTempDirectory(TEMP_DIR);
$latte->addFilter('translate', 'strrev');
$latte->addFilter('join', 'implode');

$params['hello'] = '<i>Hello</i>';
$params['xss'] = 'some&<>"\'/chars';
$params['people'] = array('John', 'Mary', 'Paul', ']]> <!--');
$params['menu'] = array('about', array('product1', 'product2'), 'contact');
$params['el'] = new Html("<div title='1/2\"'></div>");

Assert::matchFile(
	__DIR__ . '/expected/macros.general.html.phtml',
	$latte->compile(__DIR__ . '/templates/general.latte')
);
Assert::matchFile(
	__DIR__ . '/expected/macros.general.html.html',
	$latte->renderToString(
		__DIR__ . '/templates/general.latte',
		$params
	)
);
