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
        $query = "SELECT * FROM Properties WHERE TenantID = :tenantID AND UserID = :userID";
		$pdo = $this->db->prepare($query);
        $pdo->bindParam(':tenantID', $tenantID);
        $pdo->bindParam(':userID', $userID);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
    }

    public function addPropertyWithoutTenant($userID, $address, $rent)
    {
        $query = "INSERT INTO Properties (UserID, PropertyAddress, PropertyRent) VALUES (:userID, :propertyAddress, :rent)";
        $pdo = $this->db->prepare($query);
        $pdo->bindParam(':userID', $userID);
        $pdo->bindParam(':propertyAddress', $address);
        $pdo->bindParam(':rent', $rent);

        if($pdo->execute())
		{
			return true;
		}
		else
		{
			$pdo->error_log();
			return false;
		}
    }

    public function addPropertyWithTenant($userID, $address, $rent, $tenantID)
    {
        $query = "INSERT INTO Properties (TenantID, UserID, PropertyAddress, PropertyRent) VALUES (:tenantID, :userID, :propertyAddress, :rent)";
        $pdo = $this->db->prepare($query);
        $pdo->bindParam(':userID', $userID);
        $pdo->bindParam(':propertyAddress', $address);
        $pdo->bindParam(':rent', $rent);
        $pdo->bindParam(':tenantID', $tenantID);

        if($pdo->execute())
		{
			return true;
		}
		else
		{
			$pdo->error_log();
			return false;
		}
    }
}
?>