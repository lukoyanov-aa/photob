<?php

class actionPhotobattleIndex extends cmsAction{
    
    public function run(){
        
        $template = cmsTemplate::getInstance();
        $battles = array();
        $template->render('index', array(
            'battles' => $battles
        ));
    }

}