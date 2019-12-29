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
    $this->db->where('email', $usuario['email']);
    $resultado = $this->db->get('usuario')->row_array();
    if($acao == 'adicionando'){
      if(empty($resultado)){
        $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
        $this->db->trans_begin();
        if($this->db->insert('usuario', $usuario)){
          $usuario_id = $this->db->insert_id();
          foreach ($curso_ids as $curso_id) {
            $this->db->set('professor_id', $usuario_id);
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
      }
    }else{
      if(empty($resultado) || $resultado['usuario_id'] == $usuario['usuario_id']){
        if($this->atualizarProfessor($usuario, $curso_ids)){
          return '';
        }else{
          return 'Ocorreu um erro atualizando professor na tabela usuario';
        }
      }
    }
    return 'O email <strong>' . $usuario['email'] . '</strong> já existe!';
  }

  public function atualizarProfessor($usuario, $curso_ids){
    if(!empty($usuario['senha'])){
      $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
    }else{
      unset($usuario['senha']);
    }
    $this->db->trans_begin();
    $this->db->where('usuario_id', $usuario['usuario_id']);
    if($this->db->update('usuario', $usuario)){
      $this->db->where('professor_id', $usuario['usuario_id']);
      $this->db->delete('professor_leciona');
      if(! empty($curso_ids[0])){
        foreach ($curso_ids as $curso_id) {
          $this->db->set('professor_id', $usuario['usuario_id']);
          $this->db->set('curso_id', $curso_id);
          $this->db->insert('professor_leciona');
        }
      }
      $this->db->trans_complete();
      if($this->db->trans_status()){
        $this->db->trans_commit();
        return true;
      }else{
        $this->db->trans_rollback();
      }
    }
    return false;
  }

  public function salvarComoAluno($usuario){
  }

  public function excluir($usuario_ids){
    $this->db->where_in('usuario_id', $usuario_ids);
    return $this->db->delete('usuario');
  }
}
