<?php

class Mod_categoria extends CI_Model {

    public function getAll(){
        $this->db->order_by('categoria', 'asc');
        return $this->db->get('categoria')->result_array();
    }

    public function getById($categoria_id){
        $this->db->where('categoria_id', $categoria_id);
        return $this->db->get('categoria')->row_array();
    }

    public function lista($limit, $offset, $sort, $order, $search, $total = false) {
        if (!empty($search)) {
            $this->db->where("(categoria LIKE '%$search%')", null, false);
        }
        if ($total) {
            return $this->db->count_all_results('categoria');
        }
        $this->db->order_by($sort, $order);
        return $this->db->get('categoria', $limit, $offset)->result_array();
    }

    public function salvar($acao, $categoria, $categoria_id){
        if($acao == 'adicionando'){
            $this->db->where('categoria', $categoria);
            $num_rows = $this->db->count_all_results('categoria');
            if($num_rows == 0){
                $this->db->set('categoria', $categoria);
                if($this->db->insert('categoria')){
                    return '';
                }else{
                    return 'Ocorreu um erro inserindo na tabela categoria';
                }
            }else{
                return 'A categoria <strong>' . $categoria . '</strong> já existe.';
            }
        }else{
            $this->db->where('categoria', $categoria);
            $categorias = $this->db->get('categoria')->row_array();
            if($categoria_id == $categorias['categoria_id'] && $categoria == $categorias['categoria']){
                return '';
            }else{
                $this->db->select('categoria');
                $this->db->where('categoria', $categoria);
                $num_rows = $this->db->count_all_results('categoria');
                if($num_rows == 0){
                    $this->db->set('categoria', $categoria);
                    $this->db->where('categoria_id', $categoria_id);
                    if($this->db->update('categoria')){
                        return '';
                    }else{
                        return 'Ocorreu um erro atualizando a tabela categoria';
                    }
                }else{
                    return 'A categoria <strong>' . $categoria . '</strong> já existe.';
                }                
            }
        } 
    }

    public function excluir($categoria_ids){
        $this->db->where_in('categoria_id', $categoria_ids);
        $categorias = $this->db->get('categoria')->result_array();
        $this->db->trans_start();
        foreach($categorias as $categoria){
            $this->db->where('categoria_id', $categoria['categoria_id']);
            $this->db->delete('categoria');
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    
}