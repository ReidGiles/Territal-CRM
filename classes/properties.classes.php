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

    public function addPropertyWithoutTenant($userID, $buildingNameStreetNo, $street, $city, $postcode, $propertyType, $bedrooms, $monthlyRent)
    {
        $query = "INSERT INTO Properties (UserID, BuildingName_StreetNo, Street, City, Postcode, PropertyType, Bedrooms, MonthlyRent) VALUES (:userID, :buildingNameStreetNo, :street, :city, :postcode, :propertyType, :bedrooms, :monthlyRent)";
        $pdo = $this->db->prepare($query);
        $pdo->bindParam(':userID', $userID);
        $pdo->bindParam(':buildingNameStreetNo', $buildingNameStreetNo);
        $pdo->bindParam(':street', $street);
        $pdo->bindParam(':city', $city);
        $pdo->bindParam(':postcode', $postcode);
        $pdo->bindParam(':propertyType', $propertyType);
        $pdo->bindParam(':bedrooms', $bedrooms);
        $pdo->bindParam(':monthlyRent', $monthlyRent);

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

    public function addPropertyWithTenant($userID, $buildingNameStreetNo, $street, $city, $postcode, $propertyType, $bedrooms, $monthlyRent, $tenantID)
    {
        $query = "INSERT INTO Properties (TenantID, UserID, BuildingName_StreetNo, Street, City, Postcode, PropertyType, Bedrooms, MonthlyRent) VALUES (:tenantID, :userID, :buildingNameStreetNo, :street, :city, :postcode, :propertyType, :bedrooms, :monthlyRent)";
        $pdo = $this->db->prepare($query);      
        $pdo->bindParam(':userID', $userID);
        $pdo->bindParam(':buildingNameStreetNo', $buildingNameStreetNo);
        $pdo->bindParam(':street', $street);
        $pdo->bindParam(':city', $city);
        $pdo->bindParam(':postcode', $postcode);
        $pdo->bindParam(':propertyType', $propertyType);
        $pdo->bindParam(':bedrooms', $bedrooms);
        $pdo->bindParam(':monthlyRent', $monthlyRent);
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

    public function updateProperty($userID, $buildingNameStreetNo, $street, $city, $postcode, $propertyType, $bedrooms, $monthlyRent, $tenantID, $propertyID)
    {
        $query = "UPDATE Properties SET TenantID = :tenantID, UserID = :userID, BuildingName_StreetNo = :buildingNameStreetNo, Street = :street, City = :city, Postcode = :postcode, PropertyType = :propertyType, Bedrooms = :bedrooms, MonthlyRent = :monthlyRent WHERE PropertyID = :propertyID";
        $pdo = $this->db->prepare($query);
        $pdo->bindParam(':userID', $userID);
        $pdo->bindParam(':buildingNameStreetNo', $buildingNameStreetNo);
        $pdo->bindParam(':street', $street);
        $pdo->bindParam(':city', $city);
        $pdo->bindParam(':postcode', $postcode);
        $pdo->bindParam(':propertyType', $propertyType);
        $pdo->bindParam(':bedrooms', $bedrooms);
        $pdo->bindParam(':monthlyRent', $monthlyRent);
        $pdo->bindParam(':tenantID', $tenantID);
        $pdo->bindParam(':propertyID', $propertyID);

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