<?php

class actionPhotobattleAdd extends cmsAction{
    
    public function run(){
        
        if (!cmsUser::isAdmin()/*проверяем если текущий пользователь НЕ Администратор*/){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        $form = $this->getForm('battle'); //выводим созданную форму form_battle

        $errors = false; //переменная для записи ошибок валидации
        $template = cmsTemplate::getInstance();
        
        $battle = array(); // переменная для сбора данных формы
        
        $template->render('form_battle', array( //рендерим шаблон и передаем в него ряд параметров
            'do' => 'add', // параметр с информацией о действии add - добавление, edit - редактирование
            'form' => $form, // обект формы form_battle
            'errors' => $errors,
            'battle' => $battle
        ));
    }

}