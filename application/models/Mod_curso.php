<?php

class Mod_curso extends CI_Model {

    public function getAll(){
        $this->db->order_by('curso', 'asc');
        return $this->db->get('curso')->result_array();
    }

    public function getById($curso_id){
        $this->db->where('curso_id', $curso_id);
        return $this->db->get('curso')->row_array();
    }

    public function lista($limit, $offset, $sort, $order, $search, $total = false) {
        if (!empty($search)) {
            $this->db->where("(curso LIKE '%$search%')", null, false);
        }
        if ($total) {
            return $this->db->count_all_results('curso');
        }
        $this->db->order_by($sort, $order);
        return $this->db->get('curso', $limit, $offset)->result_array();
    }

    public function salvar($acao, $curso, $curso_id){
        if($acao == 'adicionando'){
            $this->db->where('curso', $curso);
            $num_rows = $this->db->count_all_results('curso');
            if($num_rows == 0){
                $this->db->set('curso', $curso);
                if($this->db->insert('curso')){
                    return '';
                }else{
                    return 'Ocorreu um erro inserindo na tabela curso';
                }
            }else{
                return 'O curso <strong>' . $curso . '</strong> já existe.';
            }
        }else{
            $this->db->where('curso', $curso);
            $cursos = $this->db->get('curso')->row_array();
            if($curso_id == $cursos['curso_id'] && $curso == $cursos['curso']){
                return '';
            }else{
                $this->db->select('curso');
                $this->db->where('curso', $curso);
                $num_rows = $this->db->count_all_results('curso');
                if($num_rows == 0){
                    $this->db->set('curso', $curso);
                    $this->db->where('curso_id', $curso_id);
                    if($this->db->update('curso')){
                        return '';
                    }else{
                        return 'Ocorreu um erro atualizando a tabela curso';
                    }
                }else{
                    return 'O curso <strong>' . $curso . '</strong> já existe.';
                }
            }
        }
    }

    public function excluir($curso_ids){
        $this->db->where_in('curso_id', $curso_ids);
        $cursos = $this->db->get('curso')->result_array();
        $this->db->trans_start();
        foreach($cursos as $curso){
            $this->db->where('curso_id', $curso['curso_id']);
            $this->db->delete('curso');
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getCursosDoProfessor($usuario_id){
      $this->db->select('curso_id');
      $this->db->where('professor_id', $usuario_id);
      $resultado = $this->db->get('professor_leciona')->result_array();
      $ids = [];
      foreach ($resultado as $curso_id) {
        $ids[] = $curso_id['curso_id'];
      }
      return $ids;
    }

}
