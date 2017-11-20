<?php
namespace CustomClasses;
/**
 * This class will handle all file operations
 *
 * @author user
 */
class fileOperations {
    
    /**
     * This method will read a file
     * 
     * @param type $filePath
     * @return \CustomClasses\responseClass
     */
    public function readFile($filePath){
        $response = new responseClass();
        try{
            $content = file_get_contents($filePath);
            if(trim($content)){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = trim($content);
            }  else {
                $response->responseCode = 0;
                $response->responseMessage = "Empty file";
                $response->returnObject = null;
            }
            
        } catch (\Exception $ex) {
            
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }
    
    /**
     * This method will write condents to a file
     * 
     * @param type $filePath
     * @param type $content
     * @return \CustomClasses\responseClass
     */
    public function writeToFile($filePath , $content){
        
        $response = new responseClass();
        
        try{
            $status = file_put_contents($filePath, $content);
            if($status){
                $response->responseCode = 1;
                $response->responseMessage = "Success";
                $response->returnObject = null;
            }  else {
                $response->responseCode = 0;
                $response->responseMessage = "Could not write to file";
                $response->returnObject = null;
            }
            
        } catch (\Exception $ex) {
            
            $response->responseCode = 0;
            $response->responseMessage = $ex->getMessage();
            $response->returnObject = null;
        }
        return $response;
    }
    
}
