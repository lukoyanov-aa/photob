<?php

class actionPhotobattleBattle extends cmsAction {
	
	public function run($id = false){
		
		if (!$id) { cmsCore::error404(); }
		
		$battle = $this->model->getBattle($id);
		
		if (!$battle) { cmsCore::error404(); }
		
		$template = cmsTemplate::getInstance();
		
		$user = cmsUser::getInstance();
		
		$template_file = 'battle';
		$vote_photos = false;
		
		if ($battle['status'] == photobattle::STATUS_OPENED){
			
			$vote_photos = $this->model->getPhotosForVoting($id, $user->id);
			
			if ($vote_photos && count($vote_photos)==2){
				$template_file = 'versus';
			}
			
		}
		
		$user_photos_count = $this->model->getUserPhotosCount($user->id, $id);
		$is_max = cmsUser::isPermittedLimitReached('battles', 'max_photos', $user_photos_count);
		
		$is_user_in_battle = $user->is_admin ? false : $is_max;
		
		$template->render($template_file, array(
			'battle' => $battle,
			'is_user_in_battle' => $is_user_in_battle,
			'vote_photos' => $vote_photos
		));
		
	}
	
}