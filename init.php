<?php

Route::set('multifiletree/edit', 'multifiletree/(<id>)/edit', array(
	'id' => '[0-9]+',
))->defaults(array(
	'controller' => 'MultiFileTree',
	'action'     => 'edit',
));

Route::set('multifiletree/save', 'multifiletree/(<id>/)save', array(
	'id' => '[0-9]+',
))->defaults(array(
	'controller' => 'MultiFileTree',
	'action'     => 'save',
));

Route::set('multifiletree/render', 'multifiletree/<id>.<ext>', array(
	'id' => '[0-9]+',
))->defaults(array(
	'controller' => 'MultiFileTree',
	'action'     => 'render',
));

Route::set('multifiletree', 'multifiletree(/<id>(/<action>))', array(
	'id' => '[0-9]+',
	'action' => '(|view|children)',
))->defaults(array(
	'controller' => 'MultiFileTree',
	'action'     => 'view',
));

Route::set('multifiletree/new', 'multifiletree/new')->defaults(array(
	'controller' => 'MultiFileTree',
	'action'     => 'edit',
));
