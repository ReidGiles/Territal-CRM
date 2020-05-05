<?php
class tenants
{
    protected $db = null;

	public function __construct($db){
		$this->db = $db;
    }

    public function getTenants()
    {
        $query = "SELECT * FROM Tenants";
		$pdo = $this->db->prepare($query);
		$pdo->execute();
	
		return $pdo->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTenant($tenantID)
    {
        $query = "SELECT * FROM Tenants WHERE TenantID = :tenantID";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':tenantID', $tenantID);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
    }
}
?>