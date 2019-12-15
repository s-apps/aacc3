<?php

class Mod_comprovante extends CI_Model {

    public function getAll(){
        $this->db->order_by('comprovante');
        return $this->db->get('comprovante')->result_array();
    }

    public function getComprovanteByAtividade($atividade_id){
        $this->db->join('comprovante', 'comprovante.comprovante_id = atividade.comprovante_id');
        $this->db->where('atividade_id', $atividade_id);
        $comprovante = $this->db->get('atividade')->row_array();
        return $comprovante;
    }

    public function lista($limit, $offset, $sort, $order, $search, $total = false) {
        if (!empty($search)) {
            $this->db->where("(comprovante LIKE '%$search%')", null, false);
        }
        if ($total) {
            return $this->db->count_all_results('comprovante');
        }
        $this->db->order_by($sort, $order);
        return $this->db->get('comprovante', $limit, $offset)->result_array();
    }

    public function salvar($acao, $comprovante, $comprovante_id){
        if($acao == 'adicionando'){
            $this->db->where('comprovante', $comprovante);
            $num_rows = $this->db->count_all_results('comprovante');
            if($num_rows == 0){
                $this->db->set('comprovante', $comprovante);
                if($this->db->insert('comprovante')){
                    return '';
                }else{
                    return 'Ocorreu um erro inserindo na tabela comprovante';
                }
            }else{
                return 'A comprovante <strong>' . $comprovante . '</strong> já existe.';
            }
        }else{
            $this->db->where('comprovante', $comprovante);
            $comprovantes = $this->db->get('comprovante')->row_array();
            if($comprovante_id == $comprovantes['comprovante_id'] && $comprovante == $comprovantes['comprovante']){
                return '';
            }else{
                $this->db->select('comprovante');
                $this->db->where('comprovante', $comprovante);
                $num_rows = $this->db->count_all_results('comprovante');
                if($num_rows == 0){
                    $this->db->set('comprovante', $comprovante);
                    $this->db->where('comprovante_id', $comprovante_id);
                    if($this->db->update('comprovante')){
                        return '';
                    }else{
                        return 'Ocorreu um erro atualizando a tabela comprovante';
                    }
                }else{
                    return 'A comprovante <strong>' . $comprovante . '</strong> já existe.';
                }                
            }
        } 
    }

    public function getById($comprovante_id){
        $this->db->where('comprovante_id', $comprovante_id);
        return $this->db->get('comprovante')->row_array();
    }

    public function excluir($comprovante_ids){
        $this->db->where_in('comprovante_id', $comprovante_ids);
        $comprovantes = $this->db->get('comprovante')->result_array();
        $this->db->trans_start();
        foreach($comprovantes as $comprovante){
            $this->db->where('comprovante_id', $comprovante['comprovante_id']);
            $this->db->delete('comprovante');
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    
}