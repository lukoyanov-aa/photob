<?php

class actionPhotobattleBattle extends cmsAction{
    
    public function run($id = false/*параметр передаваемый в адресной строке*/){
        
        if (!$id){ cmsCore::error404();}
        
        $battle = $this->model->getBattle($id);
        
        if (!$battle){ cmsCore::error404();}
        
        $template = cmsTemplate::getInstance();
        
        $template->render('battle', array( //рендерим шаблон и передаем в него ряд параметров
            'battle' => $battle
        ));
    }

}