<?php
class properties
{
    protected $db = null;

	public function __construct($db){
		$this->db = $db;
    }
    
    public function getProperties()
    {
        $query = "SELECT * FROM Properties";
		$pdo = $this->db->prepare($query);
		$pdo->execute();
	
		return $pdo->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProperty($propertyID)
    {
        $query = "SELECT * FROM Properties WHERE PropertyID = :propertyID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':propertyID', $propertyID);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
    }

    public function getPropertyByTenant($tenantID)
    {
        $query = "SELECT * FROM Properties WHERE TenantID = :tenantID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':tenantID', $tenantID);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
    }
}
?>