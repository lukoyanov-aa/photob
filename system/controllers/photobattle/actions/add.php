<?php

class actionPhotobattleAdd extends cmsAction{
    
    public function run(){
        
        if (!cmsUser::isAdmin()/*проверяем если текущий пользователь НЕ Администратор*/){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        $form = $this->getForm('battle'); //выводим созданную форму form_battle
        
        $errors = false; //переменная для записи ошибок валидации
        $template = cmsTemplate::getInstance();
        
        // переменная с информацией 
        $is_submitted = $this->request->has('submit'); //has - проверяет наличие переменной submit в запросе
        // переменная для сбора данных формы
        $battle = $form->parse($this->request/* данные введенные пользователем и переданные методом post*/, 
                                $is_submitted/*булевая переменная была ли отправленна форма*/
                              ); 
                              
        if ($is_submitted){
            
            $errors = $form->validate($this, $battle); //валидируем форму
        }
        
        $template->render('form_battle', array( //рендерим шаблон и передаем в него ряд параметров
            'do' => 'add', // параметр с информацией о действии add - добавление, edit - редактирование
            'form' => $form, // обект формы form_battle
            'errors' => $errors,
            'battle' => $battle
        ));
    }

}