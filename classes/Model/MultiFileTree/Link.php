<?php

class Model_MultiFileTree_Link extends ORM {

	protected $_table_name = 'links';

	protected $_belongs_to = array(
		'parent' => array(),
		'child' => array(),
	);

}
