<?php

class Controller_MultiFileTree extends Controller_Template {

	/** @var string */
	public $template = 'multifiletree/template';

	/** @var Model_Item The current item, maybe not loaded. */
	private $item;

	public function before()
	{
		parent::before();
		$id = $this->request->param('id');
		$this->item = ORM::factory('MultiFileTree_Item', $id);
		$this->template->sitetitle = Kohana::$config->load('settings')->get('sitetitle', 'MultiFileTree');
		$this->template->roots = ORM::factory('MultiFileTree_Item')->find_all_children();

		$this->template->action = $this->request->action();
	}

	public function action_children()
	{
		$items = ORM::factory('MultiFileView_Item');
		$children = $items->children($this->item->id())
				->as_array('id', 'name');
		echo json_encode($children);
		exit(0);
	}

	public function action_view()
	{

		// If no ID provided, send to item #1.
		if ($this->request->param('id') == NULL)
		{
			$url = Route::url('multifiletree', array('id' => 1), TRUE);
			$this->redirect($url);
		}

		// Complain if it doesn't exist.
		if ( ! $this->item->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$this->template->title = $this->item->name;
		$view = View::factory('multifiletree/view');
		$view->item = $this->item;
		$datalog_url = 'datalog/items/'.$this->item->id;
		$view->datalog = Request::factory($datalog_url)->execute()->body();
		$this->template->main = $view;

	}

	public function action_render()
	{
		$filename = URL::title($this->item->name).'.'.$this->item->get_ext();
		$opts = array('inline'=>true, 'mime_type'=>$this->item->mime_type);
		$this->response->send_file($this->item->get_cache_filename(), $filename, $opts);
	}

	public function action_edit()
	{
		$this->template->title = ($this->item->id) ? 'Edit item #' . $this->item->id : 'New';
		$edit_form = View::factory('multifiletree/edit');
		$edit_form->item = $this->item;

		// DataLog
		$datalog_url = 'datalog/items/'.$this->item->id;
		$edit_form->datalog = Request::factory($datalog_url)->execute()->body();

		$this->template->main = $edit_form;
	}

	public function action_save()
	{
		$this->item->name = $this->request->post('name');
		$this->item->set_file(Arr::get($_FILES, 'file'));
		try
		{
			$this->item->save();
		}
		catch (ORM_Validation_Exception $e)
		{
			$this->errors = $e->errors('multifiletree');
		}

		$this->redirect_to_id($this->item->id);
	}

	/**
	 * Redirect to an item.
	 *
	 * @param integer $id The ID of the item to which to redirect.
	 */
	protected function redirect_to_id($id)
	{
		$params = array('id' => $id);
		$this->redirect(Route::url('multifiletree', $params, TRUE));
	}

}
