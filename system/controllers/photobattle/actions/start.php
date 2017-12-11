<?php

class actionPhotobattleStart extends cmsAction {
	
	public function run($id=false){
		
		if (!$id) { cmsCore::error404(); }
		if (!cmsUser::isAdmin()) { cmsCore::error404(); }
		
		$battle = $this->model->getBattle($id);
		
		if (!$battle) { cmsCore::error404(); }
		
		$this->model->setBattleStatus($id, photobattle::STATUS_OPENED);
		
		$this->redirectToAction('battle', array($id));

	}
	
}