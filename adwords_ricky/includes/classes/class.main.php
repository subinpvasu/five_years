<?php
/********************************************************************************************************
 * @Short Description of the File	: commonly used functions
 * @version 						: 0.1
 * @author 							: Deepa Varma<rdvarmaa@gmail.com>
 * @project 						: ADWORDS RICKY
 * @Created on 						: JULY 25 2014
 * @Modified on 					: JULY 25 2014
********************************************************************************************************/

define('OBJECT','OBJECT',true);
define('ARRAY_A','ARRAY_A',true);
define('ARRAY_N','ARRAY_N',true);

/**
 * Database Class
 *
 */
class Main
{

    protected $trace           = false;  // same as $debug_all
    protected $debug_all       = false;  // same as $trace
    protected $debug_called    = false;
    protected $protecteddump_called  = false;
    protected $show_errors     = true;
    protected $num_queries     = 0;
    protected $last_query      = null;
    protected $last_error      = null;
    protected $col_info        = null;
    protected $captured_errors = array();
    protected $dbuser 		 = false;
    protected $dbpassword 	 = false;
    protected $dbname 		 = false;
    protected $dbhost 		 = false;
    protected $cache_dir 		 = false;
    protected $cache_queries 	 = false;
    protected $cache_inserts 	 = false;
    protected $use_disk_cache  = false;
    protected $cache_timeout 	 = 24; 		// hours
	/* Site related Variables*/
	public $siteId;
	public $siteCartStatus;
	public $siteStatus;
	public $siteFolder;
	
	public $queryErrorRedirectionPath ="index.html";

    /**
	 * Constructor - allow the user to perform a qucik connect at the
	 * same time as initialising the class
	 *
	 * @param string $dbuser
	 * @param string $dbpassword
	 * @param string $dbname
	 * @param string $dbhost
	 * @return DB
	 */
	function __construct($dbuser=DB_USER, $dbpassword=DB_PASSWORD, $dbname=DB_DATABASE, $dbhost=DB_HOST)
	{     
        $this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
        $this->QuickConnect();         
    }

    /**
	 * Short hand way to connect to mySQL database server
	 * and select a mySQL database at the same time
	 *
	 * @param string $dbuser
	 * @param string $dbpassword
	 * @param string $dbname
	 * @param string $dbhost
	 * @return bool
	 */
    function QuickConnect()
    {
        $return_val = false;
        if ( ! $this->Connect() ) ;
 
        else
        {
        	$return_val = true;
        } 
        return $return_val;
    }

    /**
	 * Try to connect to mySQL database server
	 *
	 * @param string $dbuser
	 * @param string $dbpassword
	 * @param string $dbhost
	 * @return bool
	 */
    function Connect()
    {
        $return_val = false;
		
		//echo "Database Connection <br>";
        // Must have a user and a password
        if ( ! $this->dbuser )
        {
            $this->RegisterError($this->GetError(1).' in '.__FILE__.' on line '.__LINE__);
            $this->show_errors ? trigger_error($this->GetError(1),E_USER_WARNING) : null;
        }
        // Try to establish the server database handle
        else if ( ! $this->mysqli=new mysqli($this->dbhost,$this->dbuser,$this->dbpassword,$this->dbname) )
        {
		    $this->RegisterError($this->GetError(2).' in '.__FILE__.' on line '.__LINE__);
            $this->show_errors ? trigger_error($this->GetError(2),E_USER_WARNING) : null;
        }
        else
        {
			
            $return_val = true;
            //define("DB_RESOURCE",$this->mysqli);
        }

        return $return_val;
    }

    /**
	 * Try to select a mySQL database
	 *
	 * @param string $dbname
	 * @return bool
	 */
    function Select($dbname='')
    {
        $return_val = false;

        // Must have a database name
        if ( ! $dbname )
        {
            $this->RegisterError($this->GetError(3).' in '.__FILE__.' on line '.__LINE__);
            $this->show_errors ? trigger_error($this->GetError(3),E_USER_WARNING) : null;
        }

        // Must have an active database connection
        else if ( ! $this->mysqli )
        {
            $this->RegisterError($this->GetError(4).' in '.__FILE__.' on line '.__LINE__);
            $this->show_errors ? trigger_error($this->GetError(4),E_USER_WARNING) : null;
        }

        // Try to connect to the database
		
       /*  else if (@$this->mysqli->select_db($dbname))
        {
			echo '2312'.$dbname ;
            // Try to get error supplied by mysql if not use our own
            if ( !$str = @$this->mysqli->error)
            $str = $this->GetError(5);
			
            $this->RegisterError($str.' in '.__FILE__.' on line '.__LINE__);
            $this->show_errors ? trigger_error($str,E_USER_WARNING) : null;
        } */
        else
        {
			//echo $dbname ;
            $this->dbname = $dbname;
            $return_val = true;
        }

        return $return_val;
    }

    /**
	 * Format a mySQL string correctly for safe mySQL insert
	 * (no mater if magic quotes are on or not)
	 *
	 * @param string $str
	 * @return string
	 */
    function Escape($str)
    {
        //return $str;
        //return mysql_escape_string(stripslashes($str));
        //echo $str."<br>";
        //return stripslashes((stripslashes($str)));
        return $str;
    }

    /**
	 * Return mySQL specific system date syntax
	 *
	 * @return string
	 */
    function Sysdate()
    {
        return 'NOW()';
    }

    /**
	 * Perform mySQL query and try to detirmin result value
	 *
	 * @param string $query
	 * @return mixed
	 */
    function Query($query)
    {
        // Initialise return
        $return_val = 0;

        // Flush cached values..
        $this->Flush();

		//Format a mySQL string correctly for safe mySQL insert	
 		$query = $this->Escape($query);

        // For reg expressions
        $query = trim($query);
        // Log how the function was called
        $this->func_call = "\$db->Query(\"$query\")";

        // Keep track of the last query for debug..
        $this->last_query = $query;

        // Count how many queries there have been
        $this->num_queries++;

        // The would be cache file for this query
        $cache_file = $this->cache_dir.'/'.md5($query);
		
        // Try to get previously cached version
        if ( $this->use_disk_cache && file_exists($cache_file) )
        {
            // Only use this cache file if less than 'cache_timeout' (hours)
           
            if ( (time() - filemtime($cache_file)) > ($this->cache_timeout*3600) )
            {
                unlink($cache_file);
            }
            else
            {
                $result_cache = unserialize(file_get_contents($cache_file));

                $this->col_info = $result_cache['col_info'];
                $this->last_result = $result_cache['last_result'];
                $this->num_rows = $result_cache['num_rows'];

                // If debug ALL queries
                $this->trace || $this->debug_all ? $this->Debug() : null ;

                return $result_cache['return_value'];
            }
        }
     
        // Perform the query via std mysql_query function..
        try
        {
			$this->Connect();
			//$query = $this->mysqli->real_escape_string($query);
        	$this->result = $this->mysqli->query($query);
        	if(!$this->result)
        	{
				//echo "sddfa".$this->mysqli->error ; 
        		throw new Exception('Invalid Query');
        	}
        }
        catch (Exception $e)
        {	
        	 /**********************************************/
        	$filename = "log.txt";
			if (is_writable($filename)) 
			{
		    	if ($handle = fopen($filename, 'a')) 
			    {    			
			    	$data  = $_SERVER['HTTP_REFERER']."\n";
			    	$data .= $query."\n";
			    	if (fwrite($handle,$data ) === FALSE) 
			    	{
					
   					}
					fclose($handle);
				}
			}
			/**************************************************/
        	//header("Location:".$this->queryErrorRedirectionPath);
        	//echo $e->getMessage();
        }	
		//echo "query: ".$query."<br>";
        // If there is an error then take note of it..
        if ( $str = $this->mysqli->error)
        {
            $is_insert = true;
            $this->RegisterError($str);
            $this->show_errors ? trigger_error($str.'<br><b>Query</b>: '.$query.'<br>' ,E_USER_WARNING) : null;
            return false;
        }

        // Query was an insert, delete, update, replace
        $is_insert = false;
        if ( preg_match("/^(insert|delete|update|replace)\s+/i",$query) )
        {
			/**/
			/*$this->result = mysql_query($query,$this->dbh);
			echo "Query: ".$query."<br>";
			echo "Rows Affected: ".mysql_affected_rows()."<br>";*/
			/**/
            $this->rows_affected = $this->mysqli->affected_rows;

            // Take note of the insert_id
            if ( preg_match("/^(insert|replace)\s+/i",$query) )
            {
                $this->insert_id = $this->mysqli->insert_id;
            }
			
            // Return number fo rows affected
            $return_val = $this->rows_affected;
        }
		// OUTFILE
 		else if ( preg_match("/(outfile)\s+/i",$query) )
        {
			//echo "Deepa"; exit;
		}
		else if ( preg_match("/(infile)\s+/i",$query) )
        {
			$return_val = $this->rows_affected;
		}
        // Query was a select
        else if(preg_match("/^(select)\s+/i",$query))
        {

            // Take note of column info
            $i=0;
            while ($i < $this->result->num_rows)
            {
                $this->col_info[$i] = $this->result->fetch_field();
                $i++;
            }

            // Store Query Results
            $num_rows=0;
            while ( $row = $this->result->fetch_object())
            {
                // Store relults as an objects within main array
                $this->last_result[$num_rows] = $row;
                $num_rows++;
            }

          // $this->result->free ;

            // Log number of rows the query returned
            $this->num_rows = $num_rows;

            // Return number of rows selected
			//echo "num_rows: ".$num_rows."<br>";
          //  exit;
			$return_val = $this->num_rows;
        }

        // disk caching of queries
        if ( $this->use_disk_cache && ( $this->cache_queries && ! $is_insert ) || ( $this->cache_inserts && $is_insert ))
        {
            if ( ! is_dir($this->cache_dir) )
            {
                $this->RegisterError("Could not open cache dir: $this->cache_dir");
                $this->show_errors ? trigger_error("Could not open cache dir: $this->cache_dir",E_USER_WARNING) : null;
            }
            else
            {
                // Cache all result values
                $result_cache = array
                (
                'col_info' => $this->col_info,
                'last_result' => $this->last_result,
                'num_rows' => $this->num_rows,
                'return_value' => $this->num_rows,
                );
                error_log ( serialize($result_cache), 3, $cache_file);
            }
        }

        // If debug ALL queries
        $this->trace || $this->debug_all ? $this->Debug() : null ;
		$this->mysqli->close();
		
        return $return_val;

    }

    /**
	 * Register error class
	 *
	 * @param string $err_str
	 */
    function RegisterError($err_str)
    {
        // Keep track of last error
        $this->last_error = $err_str;

        // Capture all errors to an error array no matter what happens
        $this->captured_errors[] = array
        (
        'error_str' => $err_str,
        'query'     => $this->last_query
        );
    }

    /**
	 * Returns custom error
	 *
	 * @param int $num
	 * @return string
	 */
    function GetError($num) {
        switch($num) {
            case 1: return 'Require $dbuser and $dbpassword to connect to a database server'; break;
            case 2: return 'Error establishing mySQL database connection. Correct user/password? Correct hostname? Database server running?'; break;
            case 3: return 'Require $dbname to select a database'; break;
            case 4: return 'mySQL database connection is not active'; break;
            case 5: return 'Unexpected error while trying to select database'; break;
        }
    }

    /**
	 * To set mode to show error
	 *
	 */
    function ShowErrors()
    {
        $this->show_errors = true;
    }

    /**
	 * To hide errors
	 *
	 */
    function HideErrors()
    {
        $this->show_errors = false;
    }

    /**
	 *  Kill cached query results
	 *
	 */
    function Flush()
    {
        // Get rid of these
        $this->last_result = null;
        $this->col_info = null;
        $this->last_query = null;
        $this->from_disk_cache = false;
    }

    /**
	 * Get one variable from the DB
	 *
	 * @param string $query
	 * @param int $x
	 * @param int $y
	 * @return mixed
	 */
    function GetVar($query=null,$x=0,$y=0)
    {

        // Log how the function was called
        $this->func_call = "\$db->GetVar(\"$query\",$x,$y)";

        // If there is a query then perform it if not then use cached results..
        if ( $query )
        {
            $this->Query($query);
        }

        // Extract var out of cached results based x,y vals
        if ( $this->last_result[$y] )
        {
            $values = array_values(get_object_vars($this->last_result[$y]));
        }

        // If there is a value return it else return null
        return (isset($values[$x]) && $values[$x]!=='')?$values[$x]:null;
    }

    /**
	 * Get one row from the DB
	 *
	 * @param string $query
	 * @param mode $output
	 * @param int $y
	 * @return mixed
	 */
    function GetRow($query=null,$output=OBJECT,$y=0)
    {

        // Log how the function was called
        $this->func_call = "\$db->GetRow(\"$query\",$output,$y)";

        // If there is a query then perform it if not then use cached results..
        if ( $query )
        {
            $this->query($query);
        }

        // If the output is an object then return object using the row offset..
        if ( $output == OBJECT )
        {
            return $this->last_result[$y]?$this->last_result[$y]:null;
        }
        // If the output is an associative array then return row as such..
        elseif ( $output == ARRAY_A )
        {
            return $this->last_result[$y]?get_object_vars($this->last_result[$y]):null;
        }
        // If the output is an numerical array then return row as such..
        elseif ( $output == ARRAY_N )
        {
            return $this->last_result[$y]?array_values(get_object_vars($this->last_result[$y])):null;
        }
        // If invalid output type was specified..
        else
        {
            $this->print_error(" \$db->GetRow(string query, output type, int offset) -- Output type must be one of: OBJECT, ARRAY_A, ARRAY_N");
        }

    }

    /**
	 * Function to get 1 column from the cached result set based in X index
	 *
	 * @param string $query
	 * @param int $x
	 * @return mixed
	 */
    function GetCol($query=null,$x=0)
    {

        // If there is a query then perform it if not then use cached results..
        if ( $query )
        {
            $this->Query($query);
        }

        // Extract the column values
        for ( $i=0; $i < count($this->last_result); $i++ )
        {
            $new_array[$i] = $this->GetVar(null,$x,$i);
        }

        return $new_array;
    }
	

    /**
	 * Return the the query as a result set
	 *
	 * @param string $query
	 * @param mode $output
	 * @return mixed
	 */
    function GetResults($query=null, $output = OBJECT)
    {

        // Log how the function was called
        $this->func_call = "\$db->GetResults(\"$query\", $output)";

        // If there is a query then perform it if not then use cached results..
        if ( $query )
        {
            $this->Query($query);
        }

        // Send back array of objects. Each row is an object
        if ( $output == OBJECT )
        {
            return $this->last_result;
        }
        elseif ( $output == ARRAY_A || $output == ARRAY_N )
        {
            if ( $this->last_result )
            {
                $i=0;
                foreach( $this->last_result as $row )
                {

                    $new_array[$i] = get_object_vars($row);
                    if ( $output == ARRAY_N )
                    {
                        $new_array[$i] = stripslashes(array_values($new_array[$i]));
                    }

                    $i++;
                }

                return $new_array;
            }
            else
            {
                return null;
            }
        }
    }



    /**
	 * Function to get column meta data info pertaining to the last query
	 *
	 * @param string $info_type
	 * @param int $col_offset
	 * @return mixed
	 */
    function GetColInfo($info_type="name",$col_offset=-1)
    {

        if ( $this->col_info )
        {
            if ( $col_offset == -1 )
            {
                $i=0;
                foreach($this->col_info as $col )
                {
                    $new_array[$i] = $col->{$info_type};
                    $i++;
                }
                return $new_array;
            }
            else
            {
                return $this->col_info[$col_offset]->{$info_type};
            }

        }

    }

    /**
	 * Dumps the contents of any input variable to screen in a nicely
	 * formatted and easy to understand way - any type: Object, Var or Array
	 *
	 * @param mixed $mixed
	 */
    function VarDump($mixed='')
    {

        echo "<p><table><tr><td bgcolor=ffffff><blockquote><font color=000090>";
        echo "<pre><font face=arial>";

        if ( ! $this->vardump_called )
        {
            echo "<font color=800080><b>Variable Dump..</b></font>\n\n";
        }

        $var_type = gettype ($mixed);
        print_r(($mixed?$mixed:"<font color=red>No Value / False</font>"));
        echo "\n\n<b>Type:</b> " . ucfirst($var_type) . "\n";
        echo "<b>Last Query</b> [$this->num_queries]<b>:</b> ".($this->last_query?$this->last_query:"NULL")."\n";
        echo "<b>Last Function Call:</b> " . ($this->func_call?$this->func_call:"None")."\n";
        echo "<b>Last Rows Returned:</b> ".count($this->last_result)."\n";
        echo "</font></pre></font></blockquote></td></tr></table>";
        echo "\n<hr size=1 noshade color=dddddd>";

        $this->vardump_called = true;

    }

    /**
	 * Dumps the contents of any input variable to screen in a nicely
	 * formatted and easy to understand way - any type: Object, Var or Array
	 *
	 * @param mixed $mixed
	 */
    function DumpVar($mixed)
    {
        $this->VarDump($mixed);
    }

    /**
	 * Displays the last query string that was sent to the database & a
	 * table listing results (if there were any).
	 * (abstracted into a seperate file to save server overhead).
	 *
	 */
    function Debug()
    {

        echo "<blockquote>";

        // Only show credits once..
        if ( ! $this->debug_called )
        {
            echo "<font color=800080 face=arial size=2><b>Debug..</b></font><p>\n";
        }

        if ( $this->last_error )
        {
            echo "<font face=arial size=2 color=000099><b>Last Error --</b> [<font color=000000><b>$this->last_error</b></font>]<p>";
        }

        if ( $this->from_disk_cache )
        {
            echo "<font face=arial size=2 color=000099><b>Results retrieved from disk cache</b></font><p>";
        }


        echo "<font face=arial size=2 color=000099><b>Query</b> [$this->num_queries] <b>--</b> ";
        echo "[<font color=000000><b>$this->last_query</b></font>]</font><p>";

        echo "<font face=arial size=2 color=000099><b>Query Result..</b></font>";
        echo "<blockquote>";

        if ( $this->col_info )
        {

            // =====================================================
            // Results top rows

            echo "<table cellpadding=5 cellspacing=1 bgcolor=555555>";
            echo "<tr bgcolor=eeeeee><td nowrap valign=bottom><font color=555599 face=arial size=2><b>(row)</b></font></td>";


            for ( $i=0; $i < count($this->col_info); $i++ )
            {
                echo "<td nowrap align=left valign=top><font size=1 color=555599 face=arial>{$this->col_info[$i]->type} {$this->col_info[$i]->max_length}</font><br><span style='font-family: arial; font-size: 10pt; font-weight: bold;'>{$this->col_info[$i]->name}</span></td>";
            }

            echo "</tr>";

            // ======================================================
            // print main results

            if ( $this->last_result )
            {

                $i=0;
                foreach ( $this->GetResults(null,ARRAY_N) as $one_row )
                {
                    $i++;
                    echo "<tr bgcolor=ffffff><td bgcolor=eeeeee nowrap align=middle><font size=2 color=555599 face=arial>$i</font></td>";

                    foreach ( $one_row as $item )
                    {
                        echo "<td nowrap><font face=arial size=2>$item</font></td>";
                    }

                    echo "</tr>";
                }

            } // if last result
            else
            {
                echo "<tr bgcolor=ffffff><td colspan=".(count($this->col_info)+1)."><font face=arial size=2>No Results</font></td></tr>";
            }

            echo "</table>";

        } // if col_info
        else
        {
            echo "<font face=arial size=2>No Results</font>";
        }

        echo "</blockquote></blockquote><hr noshade color=dddddd size=1>";


        $this->debug_called = true;
    }

    /**
	 * To execute an insert query
	 *
	 * @param string $tableName
	 * @param mixed $fieldArray
	 * @return integer
	 */
    function Insert($tableName, $fieldArray)
	{
		
		$splCases = $this -> splCases();
	
        $str = "INSERT INTO `$tableName` SET ";
        if( is_array($fieldArray) ) {
            foreach ($fieldArray as $field=>$value) {
				if(in_array($value,$splCases)){$str .= "`$field` = ".$value." ,";}
				else{
                 $str .= "`$field` = '".addslashes($value)."',";
				 
				 }
            }
            $str = substr($str, 0, -1);
			if (!get_magic_quotes_gpc()) 
			{
				$str = ($str);
			}  
            $this->Query($str);
            return $this->insert_id;
        } else {
            return false;
        }
    }


    /**
	 * To execute an insert query
	 *
	 * @param string $tableName
	 * @param mixed $fieldArray
	 * @param string $condition
	 * @return integer
	 */
    function Update($tableName, $fieldArray, $condition="") {
        
		$splCases = $this -> splCases();
		$str = "UPDATE `$tableName` SET ";
        if( is_array($fieldArray) ) {
            foreach ($fieldArray as $field=>$value) {
                if(in_array($value,$splCases)){$str .= "`$field` = ".$value." ,";}
				else{
                 $str .= "`$field` = '".addslashes($value)."',";
				 
				 }
            }
            $str = substr($str, 0, -1);
            if( $condition ) 
            {
            	$str .= " WHERE " . $condition;
            }	
            /*
			if (!get_magic_quotes_gpc()) 
			{
				//$str = addslashes($str);
			}
			 echo $str;exit;	*/
            $affected = $this->Query($str); //echo "affected ".$affected; exit;
			//echo "affected: ".$affected."<br>";
            return $affected;
        } else {
            return false;
        }
    }

	/* Function delete record
	 *
	 * @param1		:	$table			: table name
	 * @param2		:	$condition		: condition for query 
	 * 		
	 * return 		:	true/false 
	 * description	:	Handles record deletion
	 * */

	function Delete($table, $condition)
	{
		$sqlDelete  = "DELETE FROM $table WHERE $condition"; 
		if($this->Query($sqlDelete))
		{
			return true;	
		}
		else
		{
			return false;			
		}		
	}
	
	function splCases(){
	
		return array("NOW()");
	
	}
	
	/* Function change status
	 *
	 * @param1		:	$table			: table name
	 * @param2		:	$currentStatus	: Current status
	 * @param3		:	$condition		: condition for query 
	 * 		
	 * return 		:	true/false 
	 * description	:	Handles change in status
	 * */
	 
	function ChangeStatus($table,$currentStatus,$condition)
	{	
		($currentStatus ? $currentStatus =0 :$currentStatus =1);
		$sqlUpdate  = "UPDATE $table SET status ='$currentStatus' WHERE $condition";
 		if($this->Query($sqlUpdate))
		{	
			return true;				
		}
		else
		{
			return false;			
		}
	}	
	
	
	/* Shows select ctrl*/
	function SelectList( $arr, $tag_name, $tag_attribs, $key, $text, $selected=NULL ) 
	{	
		$html = "\n<select name=\"$tag_name\" $tag_attribs>";
		for ($i=0, $n=count( $arr ); $i < $n; $i++ ) 
		{
			$k = $arr[$i]->$key;
			$t = $arr[$i]->$text;			
			$id = ( isset($arr[$i]->id) ? @$arr[$i]->id : null);

			$extra = '';
			$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected )) 
			{
				foreach ($selected as $obj) 
				{
					$k2 = $obj->$key;
					if ($k == $k2) 
					{
						$extra .= " selected=\"selected\"";
						break;
					}
				}
			}
			else 
			{
				$extra .= ($k == $selected ? " selected=\"selected\"" : '');
			}
			$html .= "\n\t<option value=\"".$k."\"$extra>" . $t . "</option>";
		}
		$html .= "\n</select>\n";
		return $html;
	}
	/* Creates options for select box  */
	function MakeOption( $value, $text='', $value_name='value', $text_name='text' ) 
	{
		$obj = new stdClass;
		$obj->$value_name = $value;
		$obj->$text_name = trim( $text ) ? $text : $value;
		return $obj;
	}
	/* Lists us stats*/
	function SelectUSStates($tag_name,$tag_attribs, $key, $text, $selected=NULL ) 
	{
		$arr[] = makeOption( "Wyoming","" );										
		return selectList($arr, $tag_name, $tag_attribs, $key, $text, $selected); 
	}
	
	function Redirect($page,$https='N')
	{
		
		if($https=='N')
		{
			$url = SITE_URL.$page;
			
			if(headers_sent()) 
			{
				echo "<script language=\"Javascript\">window.location.href='$url';</script>";
	        	exit;
	  		} 
	  		else 
	  		{
		        header("Location:$url");
		        exit;
	   		}	
		}	
		if($https=='Y')
		{
			$url = HTTPS_SITE_URL.$page;
			if(headers_sent()) 
			{
				echo "<script language=\"Javascript\">window.location.href='$url';</script>";
	        	exit;
	  		} 
	  		else 
	  		{
		        header("Location:$url");
		        exit;
	   		}	
		}
		exit;
		
	}
	function Paginate($query, $per_page = 10,$page = 1, $url = '?' , $type ="ARRAY_A"){ 
		 
		$countQury = "SELECT COUNT(*) as total FROM ({$query}) A";
				
		$total            =    $this->GetRow($countQury,$type);
        $totalCount       =    $total['total'];


		$adjacents = "2"; 

		$page = ($page == 0 ? 1 : $page);  
		$start = ($page - 1) * $per_page;								

		$firstPage = 1;
		$prev = $page - 1;							
		$next = $page + 1;
		$lastpage = ceil($totalCount/$per_page);
		$lpm1 = $lastpage - 1;

		$pagination = "";
		if($lastpage > 1)
		{	
			$pagination .= "<ul class='navigater'>";
					//$pagination .= "<li class='details'>Page $page of $lastpage</li>";
			$prev = ($page == 1)?1:$page - 1;
			//$pagination = '';
			if ($page == 1)
			{
			$pagination.= "<li><a class='current' title='current'>First</a></li>";
			$pagination.= "<li><a class='current' title='current'>Prev</a></li>";
			}
			else
			{
			$pagination.= "<li><a href='{$url}page=$firstPage' title='$firstPage'>First</a></li>";
			$pagination.= "<li><a href='{$url}page=$prev' title='$prev'>Prev</a></li>";
			}	
			if ($lastpage < 7 + ($adjacents * 2))
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><a class='current' title='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}page=$counter' title='$counter'>$counter</a></li>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))
			{
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li><a class='current' title='current'>$counter</a></li>";
						else
							$pagination.= "<li><a href='{$url}page=$counter' title='$counter'>$counter</a></li>";					
					}
					$pagination.= "<li class='dot'>...</li>";
					$pagination.= "<li><a href='{$url}page=$lpm1'  title='$lpm1'>$lpm1</a></li>";
					$pagination.= "<li><a href='{$url}page=$lastpage' title='$lastpage'>$lastpage</a></li>";		
				}
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<li><a href='{$url}page=1' title='1'>1</a></li>";
					$pagination.= "<li><a href='{$url}page=2' title='2'>2</a></li>";
					$pagination.= "<li class='dot'>...</li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li><a class='current' title='current'>$counter</a></li>";
						else
							$pagination.= "<li><a href='{$url}page=$counter' title='$counter'>$counter</a></li>";					
					}
					$pagination.= "<li class='dot'>..</li>";
					$pagination.= "<li><a href='{$url}page=$lpm1'  title='$lpm1'>$lpm1</a></li>";
					$pagination.= "<li><a href='{$url}page=$lastpage' title='$lastpage'>$lastpage</a></li>";		
				}
				else
				{
					$pagination.= "<li><a href='{$url}page=1' title='1'>1</a></li>";
					$pagination.= "<li><a href='{$url}page=2' title='2'>2</a></li>";
					$pagination.= "<li class='dot'>..</li>";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li><a class='current' title='current'>$counter</a></li>";
						else
							$pagination.= "<li><a href='{$url}page=$counter' title='$counter'>$counter</a></li>";					
					}
				}
			}
			
			if ($page < $counter - 1){ 
				$pagination.= "<li><a href='{$url}page=$next' title='$next'>Next</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage' title='$lastpage'>Last</a></li>";
			}else{
				$pagination.= "<li><a class='current' title='current'>Next</a></li>";
				$pagination.= "<li><a class='current' title='current'>Last</a></li>";
			}
			$pagination.= "</ul>\n";		
		}
		
		$query  		  .=  " limit $start,$per_page ";
		 
		$arr   			 = $this->GetResults($query,$type);
		
		return array($arr,$pagination);
	}
	
	
	function Pagination($qry,$countQury,$param,$type='ARRAY_A',$pageNo=1, $limit)
    {
        $limitAll    =    false;
        //Find the total number of records get_results($query=null, $output = OBJECT)
        $total            =    $this->GetRow($countQury,$type);
        $totalCount       =    $total['total'];      

        $totalPageCount   =    ceil($totalCount/$limit);
        //echo "totalPageCount".$totalPageCount."<br>";
        if($limit=="ALL")
        {
            $limit        =    $totalCount;
            $limitAll    =    true;
        }
        $startCount        =    ($pageNo-1)*$limit;
        //generate the pagination array
      
        //calculate the start and end of page list
      
        if($pageNo>=ceil($totalPageCount/2))
        {
            $variant    =    0;
            $end        =    $pageNo+PAGE_COUNT;
            if($end>$totalPageCount)
            {
                $end    =    $totalPageCount;
                $variant=    ($pageNo+PAGE_COUNT)-$end;
            }

            $start        =    $pageNo-PAGE_COUNT-$variant;
            if($start<1)
                $start    =    1;
        }
        else
        {
            $variant    =    0;
            $start        =    $pageNo-PAGE_COUNT;
            if($start<1)
            {
                $start    =    1;
                $variant=    -($pageNo-PAGE_COUNT)+$start;
            }
            $end        =    ($pageNo+PAGE_COUNT)+$variant;
            if($end>$totalPageCount)
            $end    =    $totalPageCount;
        }
        $str            =    "<table><tr><td>";
        if($start>1)
        {
            $str        .=    "<a href='".SITE_URL."$param"."pageNo=1&limit=".$limit."'><img src='".SITE_URL."images/first.gif' alt='First' title='First' border=0></a>&nbsp;</td><td>";
        }    
        else
        {
            $str        .=    "<a href='".SITE_URL."$param"."pageNo=1&limit=".$limit."'><img src='".SITE_URL."images/first.gif' alt='First' title='First' border=0></a>&nbsp;</td><td>";
        }    
        if($pageNo>1)
        {
        	$str        .=    "<a href='".SITE_URL."$param"."pageNo=". ($pageNo-1) ."&limit=".$limit."'><img src='".SITE_URL."images/back.gif' alt='Previous' title='Previous' border=0></a>&nbsp;</td><td>";
        }	
        else
        {
        	$str        .=    "<img src='".SITE_URL."images/back.gif' alt='Previous' title='Previous' border=0>&nbsp;</td><td>";
        }	

        for($k=$start;$k<=$end;$k++)
        {

        	if($pageNo==$k)
        	{
				$str	.=	"$k&nbsp;|&nbsp;";
        	}	
			else
			{
				$str	.=	"<a href='".SITE_URL."$param"."pageNo=".$k."&limit=".$limit."' style='color:#FF0000; text-decoration:none'>$k</a>&nbsp;|&nbsp;";
			}
        }
        $str			=	rtrim($str, "|&nbsp;");
		$str			.=	"</td><td>";
		
        if($pageNo<$totalPageCount)
        {
        	$str        .=    "<a href='".SITE_URL."$param"."pageNo=". ($pageNo+1) ."&limit=".$limit."'><img src='".SITE_URL."images/next.gif' alt='Next' title='Next' border=0></a>&nbsp;</td>";
        }	
        else
        {
        	$str        .=    "<img src='".SITE_URL."images/next.gif' alt='Next'  title='Next' border=0>&nbsp;</td>";
        }
        if($end<$totalPageCount)
        {
        	$str        .=    "<td><a href='".SITE_URL."$param"."pageNo=".$totalPageCount."&limit=".$limit."'><img src='".SITE_URL."images/next.gif' alt='Last'  title='Last' border=0></a>&nbsp;</td>";
        }	
        else
        {
        	$str        .=    "<td><a href='".SITE_URL."$param"."pageNo=".$totalPageCount."&limit=".$limit."'><img src='".SITE_URL."images/last.gif' alt='Last' title='Last' border=0></a>&nbsp;</td>";
        }
        $str            .=    "</tr></table>";
        //return the records as associate array
        $qry            .=  " limit $startCount,$limit ";
		
		//die($qry);
        $arr             =    $this->GetResults($qry,$type);
        //return the number of results in a page arrary 
        $pagestr        =    "<table><tr><td class='listelement'><strong>No. of results per page:</strong>&nbsp;</td><td><select  class='listelement' name='PageCount' onChange='javascript: location.href=\"".SITE_URL.$param."limit=\"+this.value' class='DrpDwnSmall'>";
        $pagecountarra    =    array("5","10","15","30");
        foreach ($pagecountarra as $item)
        {
            $pagestr    .=    "<option value='$item' ";
            if($limitAll==true && $item=="ALL")
            {
                $pagestr.=    " selected ";
            }    
            else
            {
                $pagestr.=    ($limit==$item)? " selected " : "" ;
            }    
            $pagestr    .=    ">$item</option>";
        }
        $pagestr        .=    "</select></td></tr></table>";
        if($totalPageCount==0)
        {
            $str    =    "";
        }   
        if($totalPageCount==1)
        {
           $str    =    "";
        }
         
        return array($arr,$str,$pagestr);
    }  



	function GetLatestPageNo($qry,$pageNo,$limit='10')
	{
		$resRecords = $this->GetResults($qry,"OBJECT");
		$totalRecords = $resRecords[0]->total; 
		
		if(ceil($totalRecords/$limit) < $pageNo ) 
		{
			$pageNo = $pageNo-1;
		}				
		else
		{
			return $pageNo;
		}
		if($pageNo <= 1)
		{
			return 1;
		}				
		return 	$pageNo;
	}
	
	function ShowErrorMessages($errMessages)
	{
		if(count($errMessages) == 0)
		{ 
			return ;
		}	
		$errorReport  =  "<span class='errorMsg'>".ERR_FOUND."</span>";
		$errorReport .=  "<br>";
		$errorReport .=  "<ul class='errorMsg'>";
			foreach($errMessages as $key => $val)
			{
				$errorReport .= "<li>$val</li>";
			}
		$errorReport .= "</ul>";
		return $errorReport;
	}
	
	function SetMessage($message,$status)
	{
		$newMessage = "message=$message"."&status=$status";
		return $newMessage;
	}
	
	function GetMessage($message = "", $status = 0)
	{
		
		if(isset($_GET['message']) && isset($_GET['status']))
		{
			$message = $_GET['message'];
			$status  = $_GET['status'];
		
		}
		if($message == "")
		{
			return "";
		}
		
		if($status == 1)
		{
			$retMessage = "<span class='adminMessage'>$message</span>";	
		}
		else
		{
			$retMessage = "<span class='errorMsg'>$message</span>";
		}
		return $retMessage;
	}
	
	function GetRecordCount($table,$condition="")
	{
		if($condition != "" )
		{
			$condition = " WHERE $condition";
		}	
		$sqlSelect ="SELECT count(*) as cnt FROM $table $condition ";
		
		$resSet = $this->GetResults($sqlSelect,"OBJECT");
		return $resSet[0]->cnt; 
	}

	
	
	function DateConvert($dateFormat1, $dateFormat2, $dateStr)
  	{
	  $baseStruc     = split('[:/.\ \-]', $dateFormat1);
      $dateStrParts  = split('[:/.\ \-]', $dateStr );
    
      $dateElements = array();
    
      $pKeys = array_keys( $baseStruc );
      foreach ( $pKeys as $pKey )
      {
          if ( !empty( $dateStrParts[$pKey] ))
          {
              $dateElements[$baseStruc[$pKey]] = $dateStrParts[$pKey];
          }
          else
              return false;
      }
    
     
      if (array_key_exists('M', $dateElements)) {
        $mToM=array(
          "Jan"=>"01",
          "Feb"=>"02",
          "Mar"=>"03",
          "Apr"=>"04",
          "May"=>"05",
          "Jun"=>"06",
          "Jul"=>"07",
          "Aug"=>"08",
          "Sep"=>"09",
          "Oct"=>"10",
          "Nov"=>"11",
          "Dec"=>"12",
        );
        $dateElements['m']=$mToM[$dateElements['M']];
      }
     
      $dummyTs = mktime(
        $dateElements['H'],
        $dateElements['i'],
        $dateElements['s'],
        $dateElements['m'],
        $dateElements['d'],
        $dateElements['Y']
      );
    
      return date( $dateFormat2, $dummyTs );
  }
  /* Function that returns both country and states */
  function GetCountryStates($countryId=US_COUNTRY_ID)
		{
			$Qury		= 	"
							SELECT 
									*
							FROM 	
									countries AS m
							ORDER BY m.countryName
									";
			$country	= $this->GetResults($Qury,"ARRAY_A");
			$Qury		= 	"
							SELECT 
									*
							FROM 	
									states 
							WHERE
									countryId=".$countryId."
							ORDER BY stateName		
							";
			$state	= $this->GetResults($Qury,"ARRAY_A");
		return array($country,$state);
		}
	
	/* function formats string. ie strips slash and trim spaces*/
	function FormatString(&$str,$stripslash=1,$paramReplace="",$paramReplaceWith="")
	{	
		if($paramReplace != "")
		{
			$paramReplace= trim($paramReplace,"\\");
			$str = str_replace($paramReplace,$paramReplaceWith,$str);
		}
		$str = trim($str);
		if($stripslash)
		{
			$str = stripslashes($str);
		}	
		return $str;
	}
	
	function FormatStringLength($str,$maxLength=50,$trailingString="")
	{
		if(strlen($str)>$maxLength)
		{
			$str = substr($str,0,$maxLength).$trailingString;
		}
		return $str;
	}
	/* Function returns array
	 * Fetch 
	 * 
	 * */
	function GetCurrentSite() 
	{
		/*Parsing Domain name from SERVER variable*/
		$doaminArray = parse_url($_SERVER['HTTP_HOST']);
		/*Replacing www. Since it may or maynot be in URL*/
		$doaminName = str_replace("www.","",$doaminArray['path']);
		
		$sqlSelect = "SELECT * FROM sites WHERE siteMinimumUrl = '$doaminName'";
		$currentSite = $this->GetRow($sqlSelect,"OBJECT");
		$siteUrl = $currentSite->siteUrl;
		$siteStatus = $currentSite->status;
		
		
		/*
		 * Shutdown Tpl folder . A folder defined in $shutDownFolder should be 
		 * in corresponding smarty tempalte folder
		 * */
		$shutDownFolder = "shutDown";
		
		
		/*Setinig to object variables*/
		$this->siteId 		= $currentSite->siteId;			
		$this->siteUrl 		= $currentSite->siteUrl;	
		$this->siteCartStatus 	= $currentSite->cartStatus;			
		$this->siteStatus 		= $currentSite->status;
					
		if($siteStatus == 1)
		{
			$CurrentSite['TplFolder'] = $currentSite->siteFolder;
			$this->siteFolder =	$currentSite->siteFolder;
		}
		else
		{
			$CurrentSite['TplFolder'] = $currentSite->siteFolder."/$shutDownFolder";
			$this->siteFolder =	$currentSite->siteFolder."/$shutDownFolder";
		}
		//define("SITE_URL", "http://".$siteUrl."/".SITE_PATH);
		//define("HTTPS_SITE_URL", "https://".$siteUrl."/".SITE_PATH);
		/*Returning Variables*/
		$CurrentSite['Id'] = $currentSite->siteId;
		$CurrentSite['siteUrl'] = $currentSite->siteUrl;
		$CurrentSite['siteStatus'] = $currentSite->status;
		
		return $CurrentSite;
	}
	function SendMail($toEmail,$toName,$message,$subject,$type="html",$addBcc='Y')
	{
		//$sqlSelect = "SELECT fieldValue FROM  settings WHERE fieldName = 'Admin Email'";
		//$getDetails = $this->GetResults($sqlSelect,"OBJECT");
		//$adminEmail = $getDetails[0]->fieldValue;
		//if(empty($adminEmail))
		//{
			$adminEmail = ADMIN_EMAIL;
		//}
		//echo "adminEmail: $adminEmail <br />";
		$mail = new PHPMailer();
		$mail->From     = $adminEmail;
		$mail->FromName = MAIL_FROM;
		$mail->Host     = SMTP_HOST;
		//$mail->Mailer   = MAILER;
		$mail->Subject = $subject;
		if($type == "html")
		{
			$mail->IsHTML(true);
			$mail->Body    = $message;
		}
		else
		{
			$mail->IsHTML(false);
			$formattedMessage = str_replace("&nbsp;"," ",$message);
			$formattedMessage = str_replace("<br>","\n",$formattedMessage);
			$formattedMessage = str_replace("<br />","\n",$formattedMessage);
			$formattedMessage = str_replace("<br/>","\n",$formattedMessage);
			$formattedMessage = strip_tags($formattedMessage);
			$mail->Body    = $formattedMessage;
		}
		//echo "toEmail: $toEmail <br />";
		//echo "toName: $toName <br />";
		$mail->AddAddress($toEmail, $toName);
		

		if($addBcc == "Y")
		{
			$mail->AddBCC($adminEmail,MAIL_FROM);
		}
		if($mail->Send())
		{
			$mail->ClearAddresses();	
			return $this->SetMessage(MAIL_SENT,1);
		}
		else
		{
			$mail->ClearAddresses();	
			return $this->SetMessage(MAIL_NOT_SENT,0);
		}
		//echo $mail->ErrorInfo;
		//exit;
	}
	
	function SendInvoice($toEmail,$toName,$message,$subject,$orderNumber='',$type="html",$addBcc='Y')
	{
		$sqlSelect = "SELECT fieldValue FROM  settings WHERE fieldName = 'Admin Email'";
		$getDetails = $this->GetResults($sqlSelect,"OBJECT");
		$adminEmail = $getDetails[0]->fieldValue;
		if(empty($adminEmail))
		{
			$adminEmail = ADMIN_EMAIL;
		}
		//echo "adminEmail: $adminEmail <br />";
		$mail = new PHPMailer();
		$mail->From     = $adminEmail;
		$mail->FromName = MAIL_FROM;
		$mail->Host     = SMTP_HOST;
		//$mail->Mailer   = MAILER;
		$mail->Subject = $subject;
		if($type == "html")
		{
			$mail->IsHTML(true);
			$mail->Body    = $message;
		}
		else
		{
			$mail->IsHTML(false);
			$formattedMessage = str_replace("&nbsp;"," ",$message);
			$formattedMessage = str_replace("<br>","\n",$formattedMessage);
			$formattedMessage = str_replace("<br />","\n",$formattedMessage);
			$formattedMessage = str_replace("<br/>","\n",$formattedMessage);
			$formattedMessage = strip_tags($formattedMessage);
			$mail->Body    = $formattedMessage;
		}
		$mail->AddAddress($toEmail, $toName);
		if($orderNumber)
		{
			$mail->AddAttachment("admin/invoices/".$orderNumber.".pdf",$orderNumber.".pdf","base64", "application/pdf");  //
		} 
		
		if($addBcc == "Y")
		{
			$mail->AddBCC($adminEmail,MAIL_FROM);
		}
		if($mail->Send())
		{
			$mail->ClearAddresses();	
			return $this->SetMessage(MAIL_SENT,1);
		}
		else
		{
			$mail->ClearAddresses();	
			return $this->SetMessage(MAIL_NOT_SENT,0);
		}
		//echo $mail->ErrorInfo;
		//exit;
	}
	
	function GenSearchQry($keyword='',$chkSubDescription='No',$criteria='')
	{
		if(!$criteria)
		{
			$criteria="ANY";
		}
		$conect = 'AND';
		if($criteria=='ANY')
		{
			$conect = 'OR';
		}
		if($keyword == "")
		{
			return "1"; 	
		}
		//print_r($_REQUEST);
		//echo "Search : $keyword<br>";
		//print_r($_REQUEST);
		//Exact search
		list($condition,$link,$status)=$this->Exactsearch($keyword,$chkSubDescription,$conect);
		//print "Exact result Count: ".$status."<br>";
		if($status=='0' && $criteria!='EXACT')
		{
			$condition = $this->SplittedSearch($keyword,$chkSubDescription,$conect);
		}
		return $condition;
	}
	function Exactsearch($keyword='',$chkSubDescription="No",$conect='OR')
	{
		//$exactKeyWord = str_replace("\\\"","",$keyWord);
		//echo "Exact Search : $keyword<br>";
		if($keyword)
		{
			if($chkSubDescription!='No' && $chkSubDescription!="")
			{
			$qry = " prd.title LIKE '%".$keyword."%' OR prd.sku LIKE '%".$keyword."%' OR prd.description LIKE '%".$keyword."%'";
			}
			else
			{
			$qry = " prd.title LIKE '%".$keyword."%' OR prd.sku LIKE '%".$keyword."%' ";//OR prd.description LIKE '%".$keyword."%'
			}
			$link = "keyword=".$keyword;
		}
		$list = $this->GetRow('SELECT count(*) as total FROM products AS prd WHERE '.$qry,'ARRAY_A');
		return array($qry,$link,$list['total']);
	}
	function SplittedSearch($keyword='',$chkSubDescription='No',$conect='OR')
	{
		//$exactKeyWord = str_replace("\\\"","",$keyWord);
		//echo "Splitted Search : $chkSubDescription<br>";
		if($keyword)
		{
			$pattern = array("/-/","/[.]/","/\/");
			$replace = array_fill(0,count($pattern)," ");
			$keyword = preg_replace($pattern,$replace,$keyword);
			//echo "Completed string: $keyword<br>";
			$completeKeword = str_replace(" ","",$keyword);
			$keyword = $keyword." ".$completeKeword;
			//echo "Completed string: $keyword<br>";
			if(substr_count($keyword,"\"")>1)
			{
				$arr	= explode("\"",stripslashes($keyword));
				$newKeyword =array();
				for($i=1;$i<count($arr);$i++)
				{
					if(trim($arr[$i]) =="")
					{
						continue;
					}
					if($i%2 == 1)
					{
						$newKeyword[] = $arr[$i];
					}
					else
					{
						$newArray = explode(" ",$arr[$i]);
						foreach($newArray as $key =>$val)
						{
							if($val !="")
							{	
								array_push($newKeyword,$val);
							}			
						}
						
					}	
	
				}
			}
			else
			{
				$newKeyword=explode(" ",$keyword);
			}	
		}
		
		
		//echo "New generated Array: <br><pre>";
		//print_r($newKeyword);
		//echo "</pre><br>";
		$returnedCondition = " ( ";
		if(count($newKeyword)>0) // for multipe keyword search
			{
				$newQury = " ( ";
				$returnedCondition .= " ( ";
				for($x=0;$x<count($newKeyword);$x++)
				{
					
					if($newKeyword[$x] =="")
					{
						continue;
					}
					
					if($chkSubDescription!='No' && $chkSubDescription!="")
					{
						$returnedCondition .= "  ( prd.title LIKE '%".$newKeyword[$x]."%' OR prd.sku LIKE '%".$newKeyword[$x]."%' OR prd.description LIKE '%".$newKeyword[$x]."%')  $conect ";
					}
					else
					{
						$returnedCondition .= "  ( prd.title LIKE '%".$newKeyword[$x]."%' OR prd.sku LIKE '%".$newKeyword[$x]."%')  $conect ";
					}
				}
				$returnedCondition = substr($returnedCondition,0,strlen($returnedCondition)-4)." ) ";
				$returnedCondition .=" $conect ";
				//echo "<br>FINAL STR:     $returnedCondition<br><br>";
					
				
			} 
			else
			{		
				//$returnedCondition .=  "( $sfVal LIKE '%$exactKeyWord%' ) OR ";
			}
		$returnedCondition = substr($returnedCondition,0,strlen($returnedCondition)-4)." ) ";
		//echo "Condition: $returnedCondition<br>";
		//echo "$returnedCondition<br>";
		//exit;
		return $returnedCondition;
	}
	/*Search query generator*/
	/*
	 * Param 1 $searchFields	: field names in table(Array)
	 * Param 2 $keyWord			: keyword typed
	 * return 					: Search condition 
	 * */	
	function GenerateSearchCondition($searchFields,$keyWord)
	{	
		if($keyWord == "")
		{
			return "1"; 	
		}
		
		//echo $keyWord;
		//echo "<br>";
		//echo substr_count($keyWord,"\"");
		//exit;
		$exactKeyWord = str_replace("\\\"","",$keyWord);
		//echo $exactKeyWord."<br>";
		$pattern = array("/-/","/[.]/","/[^a-zA-Z0-9]+/");
		$replace = array_fill(0,count($pattern)," ");
		$keyWord = preg_replace($pattern,$replace,$keyWord);// commented for allowing all special characters in search condition.
		//echo $keyWord."<br>";
		$completeKeword = str_replace(" ","",$keyword);
		$keyword = $keyword." ".$completeKeword;
		if(substr_count($keyWord,"\"")>1)
		{
			$arr	= explode("\"",stripslashes($keyWord));
			$newKeyword =array();
			
			for($i=1;$i<count($arr);$i++)
			{
				if(trim($arr[$i]) =="")
				{
					continue;
				}
				if($i%2 == 1)
				{
					$newKeyword[] = $arr[$i];
				}
				else
				{
					$newArray = explode(" ",$arr[$i]);
					foreach($newArray as $key =>$val)
					{
						if($val !="")
						{	
							array_push($newKeyword,$val);
						}			
					}
					
				}	

			}
		}
		else
		{
			$newKeyword=explode(" ",$keyWord);
		}
		
		$returnedCondition = " ( ";
		if(isset($_REQUEST['criteria']))
		{
			$criteria = $_REQUEST['criteria'];	
		}
		else
		{
			$criteria = "EXACT";
		}
		
		$break = false;
		//print_r($exactKeyWord);exit;
		foreach($searchFields as $shKey => $sfVal)
		{
			if(count($newKeyword)>0) // for multipe keyword search
			{
				$returnedCondition .= " ( ";
				for($x=0;$x<count($newKeyword);$x++)
				{
					
					if($newKeyword[$x] =="")
					{
						continue;
					}
					switch($criteria)
					{
						case "EXACT":
							$returnedCondition .=  "( $sfVal LIKE '%".addslashes($exactKeyWord)."%' ) AND ";	
							$break = true;
							break;
						case "ANY":
							$returnedCondition .=  "( $sfVal LIKE '%".addslashes($newKeyword[$x])."%' ) OR ";
								
							break;
						break;
						case "ALL":
							$returnedCondition .=  "( $sfVal LIKE '%".addslashes($newKeyword[$x])."%' ) AND ";
							break;
						break;
					}
					if($break)
					{
						$break = false;
						break;
					}
					
				}
				$returnedCondition = substr($returnedCondition,0,strlen($returnedCondition)-4)." ) ";
				$returnedCondition .=" OR ";
			} 
			else
			{		
				$returnedCondition .=  "( $sfVal LIKE '%$exactKeyWord%' ) OR ";
			}  
			// for multipe keyword search ends here
		}	

		$returnedCondition = substr($returnedCondition,0,strlen($returnedCondition)-3)." ) ";
		
		return $returnedCondition;
		
		/****************************************************************************************/
		/********************Code below in this function are not using***************************/
		/****************************************************************************************/
		/********************************************************************************************/
		
		
		/*$mysqlKeywordsArr 	= array("and","or");
		$mysqlSpecialChars 	= array(" (", " )", " \'", " \"", " \\", " /","( ", ") ", "\' ", "\" ", "\\ ", "/ ");*/
		
		
		/*	
		 * Intention of following array is to avoid missing search key words 
		   There may be chance of key words like AND and OR in place of search data 
		 *
		 */
		/*$mysqlKeyworUsed	= 0;*/
		
		/*Explode $keyWord with space*/
		/*$searchElementsArr = explode(" ",$keyWord);
		$changedKey = "";*/
		/*iterate each element */
		/*foreach($searchElementsArr as $key => $val)
		{	
			if(trim($val) === "")
			{*/
				/* Following line is commented by Clinton Correya*/
				/* To solve array count mismatch of $searchElementsArr and $searchElementsExtractedArr*/
				//continue;
			/*}
			$searchKey = array_search(strtolower($val),$mysqlKeywordsArr);
			if(strlen($searchKey) >0 )
			{
				if($mysqlKeyworUsed == 1)
				{
					//echo "MYSQL---------$key".$val."<br>";exit;	
				} 
				$mysqlKeyworUsed =1;
				$searchElementsExtractedArr[$key] = "";
			}
			else
			{	
				$mysqlKeyworUsed = 0;
				$val = " ".trim($val)." ";
				$val = str_replace($mysqlSpecialChars,"",$val);
				$searchElementsArr[$key] =$val;
				$searchElementsExtractedArr[$key] = $val;
			}
		}
		
		$startKey = "";
		$singleData = "";
		$searchElementsExtractedArr[count($searchElementsExtractedArr)] = "";
		
		
			foreach($searchElementsExtractedArr as $key => $val)
			{
				$generatedCondition[$key] = "" ;
				if($val == "" )
				{	
					$generatedCondition[$startKey] =  " FIELD LIKE '%".trim($singleData)."%' ";
					$startKey = "";
				}
				else
				{	
					if($startKey === "")
					{	
						$startKey = $key;
						$singleData  = "";
					}
					$singleData .= $val." ";
				}
			}


		$condStructure = "";
		$condStructure .=" ( ";
		foreach($generatedCondition as $key =>$val)
		{
			$generatedCondition[$key] = str_replace($searchElementsExtractedArr[$key],$generatedCondition[$key],$searchElementsArr[$key]);
			$condStructure .= $generatedCondition[$key]." ";
		}
		$condStructure .=" )";

		$returnedCondition = " ( ";
		foreach($searchFields as $shKey => $sfVal)
		{
			$returnedCondition .= str_replace("FIELD",$sfVal,$condStructure)." OR";
		}	
		$returnedCondition = substr($returnedCondition,0,strlen($returnedCondition)-3)." ) ";
		
		$returnedCondition = ereg_replace("[[:space:]]+"," ",$returnedCondition);
		
		return $returnedCondition;*/
	}
	/*Function GetCountryCode
	 * 
	 * This function returns the 2 digit iso country code of given country id
	 * */
	function GetCountryCode($countryId)
	{
		$sqlSelect = "SELECT countryCode FROM countries WHERE countryId = '$countryId'";
		$arr = $this->GetRow($sqlSelect,"ARRAY_A");
		return $arr['countryCode'];
	}
	/*Function GetCountryName
	 * 
	 * This function returns the Country Name of given country id
	 * */
	function GetCountryNames($countryId)
	{
		if($countryId>0)
		{
		$sqlSelect = "SELECT countryName FROM countries WHERE countryId = '$countryId'";
		$arr = $this->GetRow($sqlSelect,"ARRAY_A");
		}
		return $arr['countryName'];
	}
	/*Function GetStateCode
	 * 
	 * This function returns the stateName of given states id
	 * */
	function GetStateCode($stateId)
	{
		$sqlSelect = "SELECT stateCode FROM states WHERE stateId = '$stateId'";
		$arr = $this->GetRow($sqlSelect,"ARRAY_A");
		return $arr['stateCode'];
	}
	/*Function GetStateName
	 * 
	 * This function returns the stateName of given states id
	 * */
	function GetStateName($stateId)
	{
		if($stateId>0)
		{
		$sqlSelect = "SELECT stateName FROM states WHERE stateId = '$stateId'";
		$arr = $this->GetRow($sqlSelect,"ARRAY_A");
		}
		return $arr['stateName'];
	}
	/*Function GetCartTotal
	 * 
	 * This function returns the Cart Total Price
	 * */
	function GetCartTotal()
	{
		$total=0;
		//print_r($_SESSION[$this->siteUrl]);
		if(count($_SESSION[$this->siteUrl])>0)
		{
			foreach ($_SESSION[$this->siteUrl] as $key=>$value)
			{
				//print_r($value);
				$total += ($value['price1']*$value[$key]);
			}
		}
	return $total;
	}
	/*Function GetCartWeight
	 * 
	 * This function returns the CartWeight
	 * */
	function GetCartWeight()
	{
		$total=0;
		if(count($_SESSION[$this->siteUrl])>0)
		{
			foreach ($_SESSION[$this->siteUrl] as $key=>$value)
			{
				$total += ($value['weight']*$value[$key]);
			}
		}
	return $total;
	}
	
	function CalculateMissouriTax($prodRate)
	{
		$taxPerc=0;
		$taxAmount=0;
		$sqlSelect = "SELECT fieldValue  as taxPerc FROM settings WHERE fieldName  = 'Tax Amount'";
		$tax = $this->GetRow($sqlSelect,"ARRAY_A");
		if($tax['taxPerc']>0)
		{
			$taxPerc=$tax['taxPerc'];
			$taxAmount=($prodRate*$taxPerc)/100;
		}
		return array($taxPerc,$taxAmount);
	}
	
		/* Function checks whether duplicate record exist 
	*
	* @param1		:	$table
	* @param2		:	$condition
	* return 		:	true/false 
	* description	:	checks whether a record exist for specified conditions
	* */

	function IsDuplicateExist($table,$condition)
	{
		$sqlSelect  = "SELECT count(*) count FROM $table WHERE $condition ";
		
		$resCount = $this->GetResults($sqlSelect,"OBJECT");
		
		if($resCount[0]->count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/*Fetch mail template html from database table*/
	function FetchMailTemplate($mailType)
	{
		$sqlSelect  = "SELECT subject,mailContent FROM mailtemplatetitles mtt ";
		$sqlSelect .= "LEFT JOIN mailtemplate mt ON mt.templateTypeId = mtt.typeId ";
		$sqlSelect .= "WHERE typeName = '$mailType' AND mt.siteId =".$this->siteId;
		
		return  $this->GetResults($sqlSelect,"OBJECT");
	}
	
	/*Replace template variable */
	function FetchMailBody($content,$dataArr) 
	{
		foreach($dataArr as $key => $val)
		{
			$content = str_replace($key,$val,$content);
		}
		return $content;
	}
	/*Fetch cms template html from database table*/
	function FetchCMSTemplate($cmsType)
	{
		$cmsType = trim($cmsType);
		$sqlSelect  = "SELECT pageContent FROM cmstitles ct ";
		$sqlSelect .= "LEFT JOIN cms cm ON cm.pageTitleId  = ct.titleId ";
		$sqlSelect .= "WHERE ct.titleName = '$cmsType' AND cm.siteId =".$this->siteId;
		return  $this->GetResults($sqlSelect,"OBJECT");
	}
	 function Insert_Hisory($FromtableName, $TotableName,$str)
                {
        $str = "INSERT INTO $TotableName(Select *,'',CURRENT_TIMESTAMP from $FromtableName where $str)";
        $this->Query($str);
          return $this->insert_id;

                }

}

  
?>