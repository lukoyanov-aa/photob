<?php

class actionPhotobattleAdd extends cmsAction{
    
    public function run(){
        
        $template = cmsTemplate::getInstance();
        
        $template->render('form_battle', array(
            'do' => 'add'
        ));
    }

}