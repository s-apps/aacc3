<?php

class Mod_usuario extends CI_Model {

  public function lista($nivel, $limit, $offset, $sort, $order, $search, $total = false) {
    if($nivel == 1){
      $this->db->join('curso', 'curso.curso_id = usuario.curso_id');
    }
    if ($total) {
      $this->db->where('nivel', $nivel);
      return $this->db->count_all_results('usuario');
    }
    if (!empty($search)) {
      $this->db->where("(usuario.usuario_ra LIKE '%$search%' OR usuario.nome LIKE '%$search%' OR usuario.email LIKE '%$search%' OR curso.curso LIKE '%$search%')", null, false);
    }
    $this->db->where('nivel', $nivel);
    $this->db->order_by($sort, $order);
    $usuarios = $this->db->get('usuario', $limit, $offset)->result_array();
    return $usuarios;
  }

  public function getUsuario($email, $senha){
    $this->db->where('email', $email);
    $usuario = $this->db->get('usuario')->row_array();
    return ($usuario['email'] == $email && password_verify($senha, $usuario['senha'])) ? $usuario : false;
  }

  public function getAllUsuariosByNivel($nivel){
    $this->db->where('nivel', $nivel);
    return $this->db->get('usuario')->result_array();
  }

  public function getUsuarioById($usuario_id){
    $this->db->where('usuario_id', $usuario_id);
    return $this->db->get('usuario')->row_array();
  }

  public function getHorasRealizadas($usuario_id){
    $this->db->where('usuario_id', $usuario_id);
    $atividades = $this->db->get('atividade')->result_array();
    foreach($atividades as &$atividade){
      $atividade['data'] = mysqlParaView($atividade['data']);
    }
    return $atividades;
  }

  public function salvarComoProfessor($usuario){
    $acao = $usuario['acao'];
    unset($usuario['acao']);
    $curso_ids = explode(',', $usuario['curso_ids']);
    unset($usuario['curso_ids']);
    if($acao == 'adicionando'){
      $this->db->where('email', $usuario['email']);
      $num_rows = $this->db->count_all_results('usuario');
      if($num_rows == 0){
        $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
        $this->db->trans_begin();
        if($this->db->insert('usuario', $usuario)){
          $professor_id = $this->db->insert_id();
          foreach ($curso_ids as $curso_id) {
            $this->db->set('professor_id', $professor_id);
            $this->db->set('curso_id', $curso_id);
            $this->db->insert('professor_leciona');
          }
          $this->db->trans_complete();
          if($this->db->trans_status()){
            $this->db->trans_commit();
            return '';
          }else{
            $this->db->trans_rollback();
            return 'Ocorreu um erro inserindo professor na tabela usuario';
          }
        }
      }else{
        return 'O email <strong>' . $usuario['email'] . '</strong> já existe!';
      }
    }else{
      
    }
  }

  public function salvarComoAluno($usuario){
    var_dump($usuario);
    exit;

    // if($usuario['acao'] == 'adicionando'){
    //     $this->db->where('email', $usuario['email']);
    //     $this->db->or_where('usuario_ra', $usuario['usuario_ra']);
    //     $num_rows = $this->db->count_all_results('usuario');
    //     if($num_rows == 0){
    //         unset($usuario['acao']);
    //         $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
    //         if($this->db->insert('usuario', $usuario)){
    //             return '';
    //         }else{
    //             return 'Ocorreu um erro inserindo usuário aluno';
    //         }
    //     }
    // }else{
    //     unset($usuario['acao']);
    //     if(!empty($usuario['senha'])){
    //         $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
    //     }else{
    //         unset($usuario['senha']);
    //     }
    //     $this->db->where('usuario_id', $usuario['usuario_id']);
    //     $this->db->update('usuario', $usuario);
    //     return '';
    // }
  }

  public function excluir($usuario_ids){
    $this->db->where_in('usuario_id', $usuario_ids);
    return $this->db->delete('usuario');
  }
}
