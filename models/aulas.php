<?php
class Aulas extends model {


	public function getAulasDoModulo($id) {
		$array = array();
		$aluno = $_SESSION['lgaluno'];

		$sql = "SELECT * FROM aulas WHERE id_modulo = '$id' ORDER BY ordem";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();

			foreach($array as $aulachave => $aula) {				
				if($aula['tipo'] == 'video') {
					$sql = "SELECT nome FROM videos WHERE id_aula = '".($aula['id'])."'";
					$sql = $this->db->query($sql)->fetch();
					$array[$aulachave]['nome'] = $sql['nome'];
				}
				elseif($aula['tipo'] == 'poll') {
					$array[$aulachave]['nome'] = "Questionário";
				}
			}
		}

		return $array;
	}

	public function getCursoDeAula($id_aula) {

		$sql = "SELECT id_curso FROM aulas WHERE id = '$id_aula'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$row = $sql->fetch();
			return $row['id_curso'];
		} else {
			return 0;
		}

	}

	public function getAula($id_aula) {
		$array = array();

		$id_aluno = $_SESSION['lgaluno'];

		$sql = "
		SELECT 
			tipo,
			(select count(*) from historico where historico.id_aula = aulas.id and historico.id_aluno = '$id_aluno') as assistido
		FROM 
			aulas 
		WHERE 
			id = '$id_aula'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$row = $sql->fetch();

			if($row['tipo'] == 'video') {

				$sql = "SELECT * FROM videos WHERE id_aula = '$id_aula'";
				$sql = $this->db->query($sql);
				$array = $sql->fetch();
				$array['tipo'] = 'video';

			}


		}

		return $array;
	}



}












