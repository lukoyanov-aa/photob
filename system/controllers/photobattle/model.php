<?php 

class modelPhotobattle extends cmsModel {
    
    //функция добаления данных в БД
    public function addBattle($battle){
         //метод insert возвращает id вставленной записи если в таблице есть поле id
        return $this->insert('photobattles' //имя таблицы куда будем вставлять без префикса cms_
                                , $battle //массив который будем вставлять
                            );
    }
    
    //функция получения записи по id
    public function getBattle($id){
        
        return $this->getItemById('photobattles'
                                    ,$id
        );
    }
    
    //функция обновления записи
    public function updateBattle($id, $battle){
        
        return $this->update('photobattles', $id, $battle);
    }
    
    public function deleteBattle($id){
        
        $config = cmsConfig::getInstance();
        
        $battle = $this->getBattle($id);
        
        $logos = self::yamlToArray($battle['logo']);
        if (is_array($logos)){
            foreach($logos as $path){
                
                unlink( $config->upload_path . $path);
            }
        }
        
        return $this->delete('photobattles', $id);
    }
}

?>