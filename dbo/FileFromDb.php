<?php

class FileFromDb {
    private $_pdo;
    private $_nomFichier = "";
    private $_id = 0;
    
    public function __construct(DataAccess $db) {
        $this->_pdo = $db->getDb();
    }
    
    public function setNomFichier($nom) {
        $this->_nomFichier = $nom;
    }
    
    public function setIdFichier($id) {
        $this->_id = $id;
    }
    
    /**
     *
     * @return type retourne le flux du fichier
     */
    public function writeOutput() {
        if ($this->_id != 0) {
            $request = "SELECT type,file FROM attachment where id = ?";
            echo $request.$this->_id;
            $stmt = $this->_pdo->prepare($request);
            $stmt->bindParam(1, $this->_id);
            $stmt->execute();
            $stmt->bindColumn(1, $type, PDO::PARAM_STR);
            $stmt->bindColumn(2, $data, PDO::PARAM_LOB);
            var_dump($stmt->fetch(PDO::FETCH_BOUND));
            echo $type;
            header("Content-Type: {$type}");
            //header("Content-Disposition: inline; filename=pj_{$this->_id}");
            return print($data);
        }
    }
    
    /* Si on souhaite un jour afficher le fichier differement
    public function createReadFileRequest($typeLecture) {
        
        $flux = "";
        
        switch ($typeLecture) {           
            case 1:
                $request = "SELECT type,file FROM attachment where fk_achat = ?;";
                $stmt = $this->_pdo->prepare($request);
                $stmt->execute();
                $stmt->bindColumn(1, $type, PDO::PARAM_STR, 256);
                $stmt->bindColumn(2, $data, PDO::PARAM_LOB);
                $stmt->fetch(PDO::FETCH_BOUND);
                header("Content-Type: $type");
                header("Content-Disposition: inline; filename={$this->filename}");
                $flux = $data;
                //return fpassthru($data);
                break;
        }
        
        return $flux;
    }
     * */

    
}
?>
