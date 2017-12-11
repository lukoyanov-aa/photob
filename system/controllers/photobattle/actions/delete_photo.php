<?php

class actionPhotobattleDeletePhoto extends cmsAction {
	
	public function run($photo_id=false){
		
		if (!$photo_id) { cmsCore::error404(); }
		if (!cmsUser::isAdmin()) { cmsCore::error404(); }

		$photo = $this->model->getPhoto($photo_id);
		
		$this->model->deletePhoto($photo_id);
		
		$this->redirectToAction('battle', array($photo['battle_id']));

	}
	
}