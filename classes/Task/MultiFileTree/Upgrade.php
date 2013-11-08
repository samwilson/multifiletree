<?php

class Task_MultiFileTree_Upgrade extends Minion_Task
{

	public function _execute(array $params)
	{
		$db = Database::instance();
		if ( ! $db->list_tables('items'))
		{
			Minion_CLI::write('Creating table: items');
			$sql = 'CREATE TABLE '.$db->quote_table('items').' ('
				.$db->quote_column('id').' INT(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,'
				.$db->quote_column('name').' VARCHAR(200) NOT NULL UNIQUE'
				.') ENGINE=InnoDB';
			$db->query(NULL, $sql);
		}
		if ( ! $db->list_tables('links'))
		{
			Minion_CLI::write('Creating table: links');
			$sql = 'CREATE TABLE '.$db->quote_table('links').' (
				parent_id INT(8) NOT NULL,
				child_id INT(8) NOT NULL,
				PRIMARY KEY (parent_id, child_id)
				) ENGINE=InnoDB';
			$db->query(NULL, $sql);
		}
		if ( ! $db->query(NULL, 'SHOW INDEXES FROM '.$db->quote_table('links').' WHERE Column_name="parent_id"'))
		{
			$sql = 'ALTER TABLE '.$db->quote_table('links').'
				ADD CONSTRAINT parent_item FOREIGN KEY parent_item (parent_id) REFERENCES items (id) ON DELETE CASCADE ON UPDATE CASCADE,
				ADD CONSTRAINT child_item FOREIGN KEY child_item (child_id) REFERENCES items (id) ON DELETE CASCADE ON UPDATE CASCADE';
			$db->query(NULL, $sql);
		}
		if ( ! DB::select()->from('items')->where('id', '=', 1)->execute()) 
		{
			Minion_CLI::write('Creating item #1');
			$db->query(NULL,'INSERT INTO '.$table_prefix.'items SET id=1, name="Multifiletree"');
		}
	}

}
