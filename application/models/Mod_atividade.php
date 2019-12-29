<?php

class Mod_atividade extends CI_Model {

    public function lista($limit, $offset, $sort, $order, $search, $total = false) {
        $this->db->join('usuario', 'usuario.usuario_id = atividade.usuario_id');
        $this->db->join('modalidade', 'modalidade.modalidade_id = atividade.modalidade_id');
        if (!empty($search)) {
            $this->db->where("(usuario.usuario_ra LIKE '%$search%' OR usuario.nome LIKE '%$search%' OR usuario.email LIKE '%$search%')", null, false);
        }
        if ($total) {
            return $this->db->count_all_results('atividade');
        }
        $this->db->order_by($sort, $order);
        $atividades = $this->db->get('atividade', $limit, $offset)->result_array();
        foreach($atividades as &$atividade){
            $atividade['data'] = mysqlParaView($atividade['data']);
        }
        return $atividades;
    }
    
    public function salvar($atividade){
        $carga_horaria = getCargaHoraria($atividade['horas_inicio'], $atividade['horas_termino']);
        if($atividade['acao'] == 'adicionando'){
            $this->db->where('atividade', $atividade['atividade']);
            $num_rows = $this->db->count_all_results('atividade');
            if($num_rows == 0){
                unset($atividade['acao']);
                $atividade = array_merge($atividade, array('carga_horaria' => $carga_horaria)); 
                if($this->db->insert('atividade', $atividade)){
                    return '';
                }else{
                    return 'Ocorreu um erro inserindo atividade';
                }           
            }else{
                return 'Atividade já existe';
            }
        }else{
            unset($atividade['acao']);
            $atividade = array_merge($atividade, array('carga_horaria' => $carga_horaria)); 
            $this->db->where('atividade_id', $atividade['atividade_id']);
            if($this->db->update('atividade', $atividade)){
                return '';
            }else{
                return 'Ocorreu um erro atualizando atividade';
            }
        }
    }

    public function getById($atividade_id){
        $this->db->where('atividade_id', $atividade_id);
        $atividade = $this->db->get('atividade')->row_array();
        $atividade['data'] = mysqlParaView($atividade['data']);
        return $atividade;
    }

    public function excluir($atividade_ids){
        $this->db->where_in('atividade_id', $atividade_ids);
        $atividades = $this->db->get('atividade')->result_array();
        $this->db->trans_start();
        foreach($atividades as $atividade){
            $this->db->where('atividade_id', $atividade['atividade_id']);
            $this->db->delete('atividade');
        }
        $this->db->trans_complete();
        $sucesso = $this->db->trans_status();
        if($sucesso){
            foreach($atividades as $atividade){
                unlink('./assets/img/comprovantes/' . $atividade['imagem_comprovante']);
            }
        }
        return $sucesso;
    }
}