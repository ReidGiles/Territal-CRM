<?php
class properties
{
    protected $db = null;

	public function __construct($db){
		$this->db = $db;
    }
    
    public function getProperties($userID)
    {
        $query = "SELECT * FROM Properties WHERE UserID = :userID";
        $pdo = $this->db->prepare($query);
        $pdo->bindParam(':userID', $userID);
		$pdo->execute();
	
		return $pdo->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProperty($userID, $propertyID)
    {
        $query = "SELECT * FROM Properties WHERE PropertyID = :propertyID AND UserID = :userID";
		$pdo = $this->db->prepare($query);
        $pdo->bindParam(':propertyID', $propertyID);
        $pdo->bindParam(':userID', $userID);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
    }

    public function getPropertyByTenant($userID, $tenantID)
    {
        $query = "SELECT * FROM Properties WHERE TenantID = :tenantID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':tenantID', $tenantID);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
    }
}
?>