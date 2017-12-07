<?php

class actionPhotobattleDelete extends cmsAction{
    
    public function run($id = false){
        
        if (!cmsUser::isAdmin()/*проверяем если текущий пользователь НЕ Администратор*/){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        if (!$id){
            cmsCore::error404(); //выводим ошибку 404
        }
        $battle = $this->model->getBattle($id);
        
        if (!$battle){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        $this->model->deleteBattle($id);
        
        $this->redirectToAction('');
    }

}