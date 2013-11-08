<?php

class Model_MultiFileTree_Item extends ORM {

	protected $_table_name = 'items';

	protected $_has_many = array(
		'parents' => array('through' => 'categories'),
		'children' => array('through' => 'categories'),
	);

	/** @var array File information (from $_FILES) */
	protected $file = FALSE;

	public function save(Validation $validation = NULL)
	{
		$datalog = new DataLog($this->_table_name, $this->_original_values);
		$parent = parent::save($validation);
		$datalog->save($this->pk(), $this->_object, $this->_related);
		$this->save_file();
		return $parent;
	}

	public function set_file($file_array = FALSE)
	{
		if ( ! $file_array OR empty($file_array['tmp_name']))
		{
			return FALSE;
		}
		$this->mime_type = $file_array['type'];
		$this->file = $file_array;
	}

	protected function save_file()
	{
		if ( ! $this->file)
		{
			return;
		}
		$storage = Storage::factory();
		$hash = md5($this->id);
		$ext = File::ext_by_mime($this->file['type']);
		$path = '/'.$hash[0].'/'
				.$hash[1].'/'
				.$hash[2].'/'
				.$this->id.'/'
				.'1.'.$ext; // @TODO
		//$path = $storage->hash("$this->id/1");
		$storage->set($path, $this->file['tmp_name'], TRUE);
	}

	public function get_path()
	{
		$hash = md5($this->id);
		$path = '/'.$hash[0].'/'
			.$hash[1].'/'
			.$hash[2].'/'
			.$this->id.'/'
			.'1.'.$this->get_ext(); // @todo
		return $path;
	}

	public function get_ext()
	{
		return File::ext_by_mime($this->mime_type);
	}

	public function get_url($protocol = 'http')
	{
		$storage = Storage::factory();
		return $storage->url($this->get_path(), $protocol);
	}

	public function get_cache_filename()
	{
		$tmp_name = Kohana::$cache_dir."/multifiletree".$this->get_path();
		if ( ! is_dir(dirname($tmp_name)))
		{
			mkdir(dirname($tmp_name), 0755, TRUE);
		}
		$storage = Storage::factory();
		$storage->get($this->get_path(), $tmp_name);
		return realpath($tmp_name);
	}

	public function find_all_children()
	{
		if ($this->loaded())
		{
			$this->where('categories.parent_id', '=', $this->id)
				->join('categories');
		}
		else
		{
			$this->where('categories.parent_id', 'IS', NULL)
				->join('categories', 'LEFT');
		}
		return $this->on('categories.child_id', '=', $this->_object_name.'.id')
			->find_all();
	}

}
