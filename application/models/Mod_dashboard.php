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

  public function getCargaHorariaAluno($usuario_id){
    $sql = "
      SELECT
      SEC_TO_TIME(SUM(TIME_TO_SEC(carga_horaria))) AS cargaHorariaTotal,
      SEC_TO_TIME(TIME_TO_SEC((SELECT limite_atividades FROM config WHERE config_id = 'default')) - SUM(TIME_TO_SEC(carga_horaria))) AS cargaHorariaRestante,
      SEC_TO_TIME(TIME_TO_SEC((SELECT limite_atividades FROM config WHERE config_id = 'default'))) AS cargaHorariaLimite
      FROM 
      atividade
      WHERE usuario_id = $usuario_id
    ";
    $resultado = $this->db->query($sql);
    return $resultado->result_array();
  }

  public function getLimiteAtividades(){
    $this->db->where('config_id', 'default');
    return $this->db->get('config')->row('limite_atividades');
  }

  public function salvarAviso($aviso){
    $acao = $aviso['acao'];
    $aviso_id = $aviso['aviso_id'];
    unset($aviso['acao']);
    unset($aviso['aviso_id']);
    if($acao == 'adicionar'){
      if($this->db->insert('aviso', $aviso)){
        return '';
      }else{
        return 'Ocorreu um erro inserindo na tabela aviso';
      }
    }else{
      $this->db->where('aviso_id', $aviso_id);
      if($this->db->update('aviso', $aviso)){
        return '';
      }else{
        return 'Ocorreu um erro atualizando a tabela aviso';
      }
    }
  }

  public function getAvisoById($aviso_id){
    $this->db->where('aviso_id', $aviso_id);
    return $this->db->get('aviso')->row_array();
  }

  public function atualizarLimiteAtividades($limite_atividades){
    $this->db->where('config_id', 'default');
    $this->db->set('limite_atividades', $limite_atividades);
    if($this->db->update('config')){
      return '';
    }else{
      return 'Ocorreu um erro atualizando tabela config';
    }
  }

  public function excluir($aviso_ids){
    $this->db->where_in('aviso_id', $aviso_ids);
    $avisos = $this->db->get('aviso')->result_array();
    $this->db->trans_start();
    foreach($avisos as $aviso){
      $this->db->where('aviso_id', $aviso['aviso_id']);
      $this->db->delete('aviso');
    }
    $this->db->trans_complete();
    return $this->db->trans_status();
  }



}
