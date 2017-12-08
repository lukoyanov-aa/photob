<?php 

class formPhotobattleJoin extends cmsForm{
    
    public function init(){
        
        return array(
            
            array(
            
            'type' => 'fieldset',
            'childs' => array(
                             
                new fieldImage/* Image - картинка */('image', array(
                    'title' => LANG_PHOTOBATTLE_JOIN_PHOTO,
                    'options' => array(            //опции поля
                        'sizes' => array('small', 'normal', 'big') //ограничиваем размер загружаемой картинки
                    ),
                    'rules' => array(
                                    array('required')
                    )
                ))
                )
            )
        );
    }
}