<?php
if(session_status() === 1 ){
    session_start();
}
require_once "configdb.php";
require_once "kriteria.php";

class Alternatif {

    private $db;
    private $dbh;

    public function __construct(){
        
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConnection();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function getAllAlternatif(){
        $alternatif = $this->db->query("SELECT * FROM alternatif");
        return $alternatif;
    }

    public function getDetailAlternatifById($id){
        $statement = $this->db->prepare("SELECT id_alternatif, k.id_kriteria, kriteria, nilai FROM detail_alternatif RIGHT JOIN kriteria AS k ON k.id_kriteria = detail_alternatif.id_kriteria WHERE id_alternatif = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result;
    }

    public function getAlternatifById($id){
        $statement = $this->db->prepare("SELECT * FROM alternatif WHERE id_alternatif=?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $kriteria = $statement->get_result()->fetch_assoc();
        $statement->close();
        return $kriteria;
    }

    public function checkAlternatif($alternatif, $id = null){
        if(isset($id)){
            $statement = $this->db->prepare("SELECT count(*) as count FROM alternatif WHERE alternatif LIKE ? AND id_alternatif != ?");
            $statement->bind_param("si", $alternatif, $_GET["id"]);
            
        }
        else{
            $statement = $this->db->prepare("SELECT count(*) as count FROM alternatif WHERE alternatif LIKE ?");
            $statement->bind_param("s", $alternatif);
        }

        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function updateAlternatif($data){
        try {
            $this->db->begin_transaction();
            // cek kriteria sudah ada atau belum
            $count = $this->checkAlternatif("%".$data["alternatif"]."%", $_GET["id"]);
            // echo $count['count']; die;

            if($count["count"] > 0){
                // jika kriteria sudah ada, maka alert
                $_SESSION["message"] = "Alternatif sudah tersedia";
                $_SESSION["old-alternatif"] = $data["alternatif"];

                header("Location: edit-alternatif.php?id=".$_GET["id"]);
                exit;
            }

            // jika kriteria belum ada, maka update
            $alternatif = ucwords(strtolower($data["alternatif"]));
            $statement = $this->db->prepare("UPDATE alternatif SET alternatif = ? WHERE id_alternatif = ?");
            $statement->bind_param("si", $alternatif, $_GET["id"]);
            $statement->execute();

            // update nilai
            $i=0;
            $detailAlternatif = $this->getDetailAlternatifById($_GET["id"]);
            foreach($detailAlternatif as $dalt):
                $statement = $this->db->prepare("UPDATE detail_alternatif SET nilai = ? WHERE id_alternatif = ? AND id_kriteria = ?");
                $statement->bind_param("iii", $data["nilai"][$i++], $dalt["id_alternatif"], $dalt["id_kriteria"]);
                $statement->execute();
            endforeach;

            if($this->db->commit() === true){
                $_SESSION["success"]="Alternatif berhasil diupdate";
            }
            else{
                $_SESSION["fail"]="Alternatif gagal diupdate";
            }
        } catch (Exception $e) {
            $this->db->rollback();
            $_SESSION["fail"]="Internal server error";
        }

        $statement->close();
        header("Location: alternatif.php"); 
    }

    public function saveAlternatif($data){
        try {
            $this->db->begin_transaction();
            // cek kriteria sudah ada atau belum
            $count = $this->checkAlternatif("%".$data["alternatif"]."%");

            if($count["count"] > 0){
                // jika kriteria sudah ada, maka alert
                $_SESSION["message"] = "Alternatif sudah tersedia";
                $_SESSION["old-alternatif"] = $data["alternatif"];
                for($index=0; $index<=count(array_values($data["nilai"])); $index++):
                    $_SESSION["old-nilai-".$index] = $data["nilai"][$index];
                endfor;

                header("Location: add-alternatif.php");
                exit;
            }

            // jika kriteria belum ada, maka save alternatif
            $alternatif = ucwords(strtolower($data["alternatif"]));
            $statement = $this->db->prepare("INSERT INTO alternatif VALUES('',?)");
            $statement->bind_param("s", $alternatif);
            $statement->execute();
            $id_alternatif = $statement->insert_id;

            $kriterias = new Kriteria;
            $kriteria = $kriterias->getAllKriteria();

            $i = 0;
            foreach($kriteria as $krt):
                $statement = $this->db->prepare("INSERT INTO detail_alternatif VALUES(?,?,?)");
                $statement->bind_param("iii", $id_alternatif, $krt["id_kriteria"], $data["nilai"][$i++]);
                $statement->execute();
            endforeach;

            if($this->db->commit() === true){
                $_SESSION["success"]="Alternatif berhasil ditambahkan";
            }
            else{
                $_SESSION["fail"]="Alternatif gagal ditambahkan";
            }
        } catch (Exception $e) {
            $this->db->rollback();
            $_SESSION["fail"]="Internal server error";
        }
        
        $statement->close();
        header("Location: alternatif.php"); 
    }

    public function deleteAlternatif($id){
        $count = $this->db->query("SELECT count(*) AS count FROM alternatif");
        if($count->fetch_array()[0] > 2){
            $statement = $this->db->prepare("DELETE FROM alternatif WHERE id_alternatif = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $_SESSION["success"] = "Alternatif berhasil dihapus";
        }
        else{
            $_SESSION["fail"] = "Minimal harus ada 2 alternatif";
        }

        header("Location: alternatif.php"); 
    }

    public function checkAlternatifKriteria(){
        $count = $this->db->query("SELECT count(*) FROM detail_alternatif RIGHT JOIN kriteria AS k ON k.id_kriteria = detail_alternatif.id_kriteria WHERE nilai=0");
        return $count->fetch_array()[0];
    }

}