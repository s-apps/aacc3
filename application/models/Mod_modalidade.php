<?php

class Mod_modalidade extends CI_Model {

    public function lista($limit, $offset, $sort, $order, $search, $total = false){
        if(!empty($search)){
             $this->db->where("(modalidade LIKE '%$search%')", null, false);
        }
        if($total){
            return $this->db->count_all_results('modalidade');    
        }
	    $this->db->order_by($sort, $order);
        return $this->db->get('modalidade', $limit, $offset)->result_array();
    }

    public function getModalidadesByCategoria($categoria_id){
        $this->db->where('categoria_id', $categoria_id);
        return $this->db->get('modalidade')->result_array();
    }

    public function getComprovantesByModalidade($modalidade_id){
        $this->db->join('comprovante', 'comprovante.comprovante_id = modalidade.comprovante_id');
        $this->db->where('modalidade_id', $modalidade_id);
        return $this->db->get('modalidade')->result_array();
    }

    public function getModalidadeByAtividade($atividade_id){
        $this->db->join('modalidade', 'modalidade.modalidade_id = atividade.modalidade_id');
        $this->db->where('atividade_id', $atividade_id);
        $modalidade = $this->db->get('atividade')->row_array();
        return $modalidade;
    }

    public function getById($modalidade_id){
        $this->db->where('modalidade_id', $modalidade_id);
        return $this->db->get('modalidade')->row_array();
    }

    public function excluir($modalidade_ids){
        $this->db->where_in('modalidade_id', $modalidade_ids);
        $modalidades = $this->db->get('modalidade')->result_array();
        $this->db->trans_start();
        foreach($modalidades as $modalidade){
            $this->db->where('modalidade_id', $modalidade['modalidade_id']);
            $this->db->delete('modalidade');
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function salvar($modalidade){
        $acao = $modalidade['acao'];
        $modalidade_id = $modalidade['modalidade_id'];
        unset($modalidade['acao']);
        unset($modalidade['modalidade_id']);
        if($acao == 'adicionando'){
            $this->db->where('modalidade', $modalidade['modalidade']);
            $num_rows = $this->db->count_all_results('modalidade');
            if($num_rows == 0){
                unset($modalidade['modalidade_id']);
                if($this->db->insert('modalidade', $modalidade)){
                    return '';
                }else{
                    return 'Ocorreu um erro inserindo na tabela modalidade';
                }
            }else{
                return 'A modalidade <strong>' . $modalidade['modalidade'] . '</strong> já existe!';
            }
        }else{
            $this->db->where('modalidade_id', $modalidade_id);
            $resultado = $this->db->get('modalidade')->row_array();
            if($resultado['modalidade_id'] == $modalidade_id && $resultado['modalidade'] == $modalidade['modalidade']){
                $this->db->where('modalidade_id', $modalidade_id);
                if($this->db->update('modalidade', $modalidade)){
                    return '';
                }else{
                    return 'Ocorreu um erro atualizando a tabela modalidade';
                }
            }else{
                $this->db->where('modalidade', $modalidade['modalidade']);
                $num_rows = $this->db->count_all_results('modalidade');
                if($num_rows == 0){
                    $this->db->where('modalidade_id', $modalidade_id);
                    if($this->db->update('modalidade', $modalidade)){
                        return '';
                    }else{
                        return 'Ocorreu um erro atualizando a tabela modalidade';
                    }    
                }else{
                    return 'A modalidade <strong>' . $modalidade['modalidade'] . '</strong> já existe!';
                }
            }
        }
    }
    
}