<?php

class actionPhotobattleJoin extends cmsAction{
    
    public function run($battle_id){
        
        if (!$battle_id){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        $battle = $this->model->getBattle($battle_id);
        
        if (!$battle || $battle['status'] != photobattle::STATUS_PENDING){
            
            
        }
        
        $errors = false; //переменная для записи ошибок валидации
        $template = cmsTemplate::getInstance();
        $user = cmsUser::getInstance();
        
        $is_user_in_battle = $this->model->isUserInBattle($user->id, $battle_id);
        
        if ($is_user_in_battle && !cmsUser::isAdmin()){
            cmsCore::error404();
        }
        
        $form = $this->getForm('join'); //выводим созданную форму
             
        // переменная с информацией 
        $is_submitted = $this->request->has('submit'); //has - проверяет наличие переменной submit в запросе
        // переменная для сбора данных формы
        $photo = $form->parse($this->request/* данные введенные пользователем и переданные методом post*/, 
                                $is_submitted/*булевая переменная была ли отправленна форма*/
                              ); 
                              
        if ($is_submitted){
            
            $errors = $form->validate($this, $photo); //валидируем форму
            
            if (!$errors){
                $photo['battle_id'] = $battle_id;
                $photo['user_id'] = $user->id;
                $this->model->addPhoto($photo);
                
                $battle = $this->model->getBattle($battle_id);
                
                if ($battle['users_count'] >= $battle['min_users']){
					
					$this->model->setBattleStatus($battle_id, photobattle::STATUS_MODERATION);
                    
                    $messenger = cmsCore::getController('messages');//подключаем другой компонент "Личные сообщения", т.е. мы говорим что 
                                                                    // нам нужен этот контроллер
					
					$messenger->addRecipient( 2/*$this->options['admin_id']*/ );//добавляем получателя сообщения
                    
                    //создаем уведомление
                    $notice = array(
						'content' => sprintf(LANG_PHOTOBATTLE_MODERATION_NOTICE, $battle['title']), //текст уведомления
						'actions' => array( //массив с кнопками
							'view' => array( // кнопка просмотра
								'title' => LANG_SHOW, //заголовк
								'href' => href_to($this->name, 'battle', $battle_id) //ссылка
							)
						)
					);
                    
                    $messenger->sendNoticePM($notice); //отправить уведомление
                }
                
                //после добавлению битвы делаем редирект на экшен созданной битвы
                $this->redirectToAction('battle' //имя экшена
                                        ,array($battle_id) //массив передаваемых параметров
                                        );
            }
            
            if ($errors){
                cmsUser::addSessionMessage(LANG_FORM_ERRORS//стандартная переменная с текстом ошибки
                                            , 'error'// css класс который будет добалвен к сообщению может быть success info error 
                                           );
            }
        }
        
        $template->render('form_join', array( //рендерим шаблон и передаем в него ряд параметров
            'form' => $form, // обект формы form_battle
            'errors' => $errors,
            'photo' => $photo,
            'battle' => $battle
        ));
    }

}