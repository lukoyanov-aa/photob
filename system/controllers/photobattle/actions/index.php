<?php

class actionPhotobattleIndex extends cmsAction{
    
    public function run(){
        
        $template = cmsTemplate::getInstance();
        $total = $this->model->getBattlesCount();
        $battles = $this->model->getBattles();
        $template->render('index', array(
            'battles' => $battles,
            'total' => $total
        ));
    }

}