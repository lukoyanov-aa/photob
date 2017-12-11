<?php

class actionPhotobattleVote extends cmsAction {
	
	public function run($won_id=false, $lost_id=false){

		if (!$won_id || !$lost_id) { cmsCore::error404(); }
		
		$photo_won = $this->model->getPhoto($won_id);
		$photo_lost = $this->model->getPhoto($lost_id);
		
		if ($photo_won['battle_id'] != $photo_lost['battle_id']) { cmsCore::error404(); }
		
		$battle = $this->model->getBattle($photo_won['battle_id']);
		
		if ($battle['status'] != photobattle::STATUS_OPENED) { cmsCore::error404(); }
		
		$user = cmsUser::getInstance();
		
		$vote_won = array(
			'user_id' => $user->id,
			'photo_id' => $won_id,
			'score' => 1
		);
		
		$vote_lost = array(
			'user_id' => $user->id,
			'photo_id' => $lost_id,
			'score' => 0
		);
		
		$this->model->addVote($vote_won);
		$this->model->addVote($vote_lost);
		
		$this->redirectBack();

	}
	
}