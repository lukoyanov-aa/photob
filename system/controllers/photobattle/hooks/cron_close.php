<?php

class onPhotobattleCronClose extends cmsAction {
	
	public function run(){
		
		$this->model->closeExpiredBattles();
		
	}
	
}