<?php
class tenants
{
    protected $db = null;

	public function __construct($db){
		$this->db = $db;
    }

    public function getTenants($userID)
    {
        $query = "SELECT * FROM Tenants WHERE UserID = :userID";
        $pdo = $this->db->prepare($query);
        $pdo->bindParam(':userID', $userID);
		$pdo->execute();
	
		return $pdo->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTenant($userID, $tenantID)
    {
        $query = "SELECT * FROM Tenants WHERE TenantID = :tenantID AND UserID = :userID";
		$pdo = $this->db->prepare($query);
        $pdo->bindParam(':tenantID', $tenantID);
        $pdo->bindParam(':userID', $userID);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
    }

    public function addTenant($userID, $forename, $surname, $gender, $age)
    {
        $query = "INSERT INTO Tenants (UserID, TenantForename, TenantSurname, TenantGender, TenantAge) VALUES (:userID, :forename, :surname, :gender, :age)";
        $pdo = $this->db->prepare($query);
        $pdo->bindParam(':userID', $userID);
        $pdo->bindParam(':forename', $forename);
        $pdo->bindParam(':surname', $surname);
        $pdo->bindParam(':gender', $gender);
        $pdo->bindParam(':age', $age);

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