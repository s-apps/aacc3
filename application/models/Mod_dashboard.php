<?php

class Mod_dashboard extends CI_Model {

    public function getAvisos($limit, $offset, $sort, $order, $search, $total = false){
        if($total){
            return $this->db->count_all_results('aviso');    
        }
	$this->db->order_by($sort, $order);
        $avisos = $this->db->get('aviso', $limit, $offset)->result_array();
        foreach($avisos as &$aviso){
            $aviso['data'] = mysqlParaView($aviso['data']);
        }
        return $avisos;
    }

    public function getCargaHorariaAluno(){

	//return horas realizadas
	//return horas a realizar
        // return atividades aguardando validação
	//return atividades limite de horas
   }

}
