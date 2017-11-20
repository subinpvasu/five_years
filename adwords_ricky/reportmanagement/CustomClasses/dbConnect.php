<?php
namespace CustomClasses;
include_once dirname(dirname(__FILE__)).'/../includes/config.php';


/**
 * This class contains database connector and close connector methods.
 *
 * @author user
 */
class dbConnect {
    //put your code here
    
    /**
     * This method will create a database connection
     * 
     * @return type
     */
    public function connectToDb(){
        
        try{
            $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
            return $con;
        }  catch (Exception $ex){
            
        }
    }
    
    
    /**
     * This method will close the database connection
     * 
     * @param type $con
     */
    public function closeConnection($con){
        mysqli_close($con);
    }
}
