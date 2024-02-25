<?php
if(session_status() === 1 ){
    session_start();
}
require_once "configdb.php";
require_once "alternatif.php";

class Kriteria {

    private $db;
    private $dbh;

    public function __construct(){
        
        $this->dbh = new Connection;
        $this->db = $this->dbh->getConnection();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function getAllKriteria(){
        $kriteria = $this->db->query('SELECT * FROM kriteria');
        return $kriteria;
    }

    public function getKriteriaById($id){
        $statement = $this->db->prepare("SELECT * FROM kriteria WHERE id_kriteria=?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $kriteria = $statement->get_result()->fetch_assoc();
        $statement->close();
        return $kriteria;
    }

    public function checkKriteria($kriteria, $id = null){
        if(isset($id)){
            $statement = $this->db->prepare("SELECT count(*) as count FROM kriteria WHERE kriteria LIKE ? AND id_kriteria != ?");
            $statement->bind_param("si", $kriteria, $_GET["id"]);
            
        }
        else{
            $statement = $this->db->prepare("SELECT count(*) as count FROM kriteria WHERE kriteria LIKE ?");
            $statement->bind_param("s", $kriteria);
        }

        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function updateKriteria($data){
        // cek kriteria sudah ada atau belum
        $count = $this->checkKriteria("%".$data["kriteria"]."%", $_GET["id"]);
        // echo $count['count']; die;

        if($count["count"] > 0){
            // jika kriteria sudah ada, maka alert
            $_SESSION["message"] = "Kriteria sudah tersedia";
            $_SESSION["old-kriteria"] = $data["kriteria"];
            header("Location: edit-kriteria.php?id=".$_GET["id"]);
            exit;
        }

        // jika kriteria belum ada, maka update
        $statement = $this->db->prepare("UPDATE kriteria SET kriteria = ?, kepentingan = ?, cost_benefit = ? WHERE id_kriteria = ?");
        $statement->bind_param("sisi", ucwords(strtolower($data["kriteria"])), $data["kepentingan"], $data["cost_benefit"], $_GET["id"]);
        $statement->execute();
        $_SESSION["success"] = "Kriteria berhasil diupdate";
        header("Location: kriteria.php"); 
    }

    public function saveKriteria($data){
        try {
            $this->db->begin_transaction();
            // cek kriteria sudah ada atau belum
            $count = $this->checkKriteria("%".$data["kriteria"]."%");

            if($count["count"] > 0){
                // jika kriteria sudah ada, maka alert
                $_SESSION["message"] = "Kriteria sudah tersedia";
                $_SESSION["old-kriteria"] = $data["kriteria"];
                $_SESSION["old-kepentingan"] = $data["kepentingan"];
                $_SESSION["old-cost-benefit"] = $data["cost_benefit"];
                header("Location: add-kriteria.php");
                exit;
            }

            // jika kriteria belum ada, maka update
            $statement = $this->db->prepare("INSERT INTO kriteria VALUES('',?,?,?)");
            $statement->bind_param("sis", ucwords(strtolower($data["kriteria"])), $data["kepentingan"], $data["cost_benefit"]);
            $statement->execute();
            $id_kriteria = $statement->insert_id;
            
            // tambahkan kriteria di alternatif
            $alternatifs = new Alternatif;
            $alternatif = $alternatifs->getAllAlternatif();
            foreach($alternatif as $alt):
                $statement = $this->db->prepare("INSERT INTO detail_alternatif VALUES(?,?,0)");
                $statement->bind_param("ii", $alt["id_alternatif"], $id_kriteria);
                $statement->execute();
            endforeach;

            if($this->db->commit() === true){
                $_SESSION["success"]="Kriteria berhasil ditambahkan";
            }
            else{
                $_SESSION["fail"]="Kriteria gagal ditambahkan";
            }
        } catch (Exception $e) {
            $this->db->rollback();
            $_SESSION["fail"]="Internal server error";
        }
        
        header("Location: kriteria.php"); 
    }

    public function deleteKriteria($id){
        $count = $this->db->query("SELECT count(*) AS count FROM alternatif");
        if($count->fetch_array()[0] > 2){
            $statement = $this->db->prepare("DELETE FROM kriteria WHERE id_kriteria = ?");
            $statement->bind_param("i", $id);
            $statement->execute();
            $_SESSION["success"] = "Kriteria berhasil dihapus";
        }
        else{
            $_SESSION["fail"] = "Minimal harus ada 2 kriteria";
        }
        
        header("Location: kriteria.php"); 
    }

}