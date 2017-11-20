<?php
/********************************************************
	Created By	:	Deepa Varma<rdvarmaa@gmail.com>
	Created On	:	JULY 25 2014
	Subject		:	Validator class
	Description	:	class file containing different validation functions	
************************************************************/


class DataValidator
{
      
    //Test if input is null or not.	 
    function ValidateNotNull($inputData)
	{
		if(trim($inputData) == "" )
		{
			return false;
		}
		return true;
	}

	function ValidateName($inputData)
	{
		if(!ereg("^[[:alpha:]\' ]*$", $inputData))
		{
			return false;
		}
		return true;
	}


    //Test if input is alphanumeric. Accepts only alphabets and numbers without space	 
    function ValidateAlphanumeric($inputData)
	{
		if(!$inputData||!preg_match("/^[a-zA-Z0-9]+$/",$inputData))
		{
			return false;
		}
			return true;
	}

	//Test if input is alphanumeric. Accepts only alphabets and numbers with space	
	function ValidateAlphanumericSpace($inputData)
	{
		if(!$inputData||!preg_match("/^[a-zA-Z0-9 ]+$/",$inputData))
		{
			return false;
		}
			return true;
	}

	//Test if input is alphanumeric. Accepts only alphabets and numbers with .(dot)
	//$specialCharacter : exclude list	
	function ValidateAlphanumericSpecial($inputData,$specialCharacter)
	{
		if(!$inputData||!preg_match("/^[a-zA-Z0-9$specialCharacter]+$/",$inputData))
		{
			return false;
		}
			return true;
	}


	//Test if input is numeric. Accepts only numeric input.	
	function ValidateNumeric($inputData)
	{
		if($inputData === "0")
		{	
			return true;
		}		
		if(!$inputData||!preg_match("/^[0-9.]+$/",$inputData))
		{
			return false;
		}
			return true;
	}

	//Test if input is numeric. Accepts only numeric input.	
	function ValidateInteger($inputData)
	{	
		if($inputData === "0")
		{	
			return true;
		}
		if(!$inputData||!preg_match("/^[0-9]*$/",$inputData))
		{	
			return false;
		}
		return true;
	}


	//Test if input is alphabets alone
	function ValidateAlpha($inputData)
	{
		if(!$inputData||!preg_match("/^[a-zA-Z]+$/",$inputData))
		{
			return false;
		}
			return true;
	}

	//Test if input is alphabets alone. Accepts only alphabets with space	
	function ValidateAlphaSpace($inputData)
	{
		if(!$inputData||!preg_match("/^[a-zA-Z ]+$/",$inputData))
		{
			return false;
		}
			return true;
	}

	// Email validation. Only alphabets,numeric,_,- ,period and @ are accepted.
	function ValidateEmail($inputData)
	{
		if (preg_match('/^[A-z0-9_\-.]+\@([A-z0-9_-]+\.)+[A-z]{2,4}$/',$inputData)) 
		{
			return true;
		} 
		else 
		{
		
			return false;
		}
	}
	
	//Test if input is alphanumeric. Accepts only alphabets and numbers with .(dot)
	//$specialCharacter : exclude list	
	function ValidateDynamic($inputData,$specialCharacter)
	{
		if(!$inputData||!preg_match("/^[$specialCharacter]+$/",$inputData))
		{
			return false;
		}
			return true;
	}

	//validate  US phone.Acceptable input format  are  (555)321-1234 ,(555) 321-1234 , 555-321-1234 , 555 321-1234 ,5553211234. Phone number should be 10 digits.
	function ValidateUsPhone($inputData)
	{
	 	 $data =  str_replace(" ", "", $inputData);
	 	 $data =  str_replace("(", "", $data);
	 	 $data =  str_replace(")", "", $data);
	 	 $data =  str_replace("-", "", $data);
	 	 $data =  str_replace(".", "", $data);
	 
	 	if (preg_match('/^[\d\.\s\-]+$/',$data))
	 	{ 
	  		 return true;
		 }
		 else
		 {
	 		return false;
	 	} 
	
	}

	//format US phone in the form   (555)321-1234.
	function FormatUsPhone($inputData)
	{
	  	 $data1 = substr($inputData, 0, 3);
	   	$data2 = substr($inputData, 3, 3);
	   	$data3 = substr($inputData, 6, 4);
	   	$phone = "(".$data1.") ".$data2."-".$data3;
	   	return $phone;
	
	}

	//check for  US phone  formats eg:-  (555)321-1234 ,(555) 321-1234 , 555-321-1234 , 555 321-1234 ,5553211234.
	function CheckUsPhone($inputData)
	{
		$pattern = '/^[\(]?(\d{0,3})[\)]?[\s]?[\-]?(\d{3})[\s]?[\-]?(\d{4})[\s]?[x]?(\d*)$/';
		if (preg_match($pattern,$inputData)) 
		{
			return true;
    		}
		
		else
		{
		  	return false;
		}
	}

	// validate Indian phone number.Input value  should be numeric and no more than 8 digits.
	function ValidateIndianPhone($inputData)
	{
		$pattern = '/^\d{1,8}$/';
		if (preg_match($pattern,$inputData)) 
		{
			return true;
    		}
		
		else
		{
		 	return false;
		}
	}

        // validate Indian Zip code. Zip should be only 6 digits and cannot start with 0 or 9.
	function ValidateIndianZip($inputData)
	{
		if(ereg("^[90]", $inputData))
		{
			return false;  //echo "cannot start with 0 or 9<br>";
		}
		else if (preg_match('/^\d{6}$/', $inputData)) 
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	// validate UK zip code. postcodes are alphanumeric and between five and eight characters long.
	function ValidateUkZip($inputData)
	{
		if (preg_match('/^[A-Za-z]{1,2}[0-9]{1,3}([A-Za-z]{1})?(\s)?[0-9]{1}[A-Za-z]{2}$/', $inputData)) 
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	// Validate Canada zip code . Zip code should be six characters in the format X9X 9X9, X is a letter and 9 is a digit. 
	function ValidateCanadaZip($inputData)
	{
		if (preg_match('/^[A-Za-z]{1}[0-9]{1}[A-Za-z]{1}(\s)?[0-9]{1}[A-Za-z]{1}[0-9]{1}$/', $inputData)) 
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	// Validate US Zipcode. Us zip code is only 5 digits in length(and 4 digits extention optional) .
	function ValidateUsZip($inputData)
	{
		if (preg_match('/^[0-9]{5,5}([- ]?[0-9]{4,4})?$/', $inputData)) 
		{
			return true;
		}
		else
		{
			return false;
		}	
	}	
	
       //Test if input is in valid range. Parameters passed are input value,minimum range value,  maximum range value.
	function ValidateRange($string, $min, $max) 
	{
		$length = strlen ($string);
		if (($length < $min) || ($length > $max)) 
		{
			return false;
		} 
		else 
		{
			return true;
		}
	}

	
	function ValidateIP($inputData) 
	{
		if (preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/',$inputData)) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// Validate time in 12 hours format .  enter time in format HH:MM or HH:MM:SS or HH:MM:SS or   HH:MM:SS am(am/AM/pm/PM)
	function ValidateTime12($inputData) 
	{
		$inputData =  str_replace(" ", "", $inputData);

		if (preg_match('/^([0-9]|1[0-2]):[0-5]\d(:[0-5]\d)?\.?\s?(am|AM|pm|PM)?\s?$/',$inputData)) 
		{
			return true;
		}
		else
		{
		    	return false;
			
		}
	}

	// Validate time in 24 hours format .  enter time in format HH:MM or HH:MM:SS or HH:MM:SS .
	function ValidateTime24($inputData) 
	{
		$inputData =  str_replace(" ", "", $inputData);

		if (preg_match('/^([0-9]|1[0-9]|2[0-3]):[0-5]\d(:[0-5]\d)?\s?$/',$inputData)) 
		{
			return true;
		}
		else
		{
		    	return false;
			
		}
	}

	// Validate Username. Only alphanumeric characters,dot and underscore are allowed.Username cannot start with a dot or 		 underscore
	function ValidateUsername($inputData) 
	{

		 if(ereg("^[._]", $inputData))
		{
			return false;  
		}
		else if (preg_match('/^[a-z\d_.]+$/', $inputData)) 
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	// Validate  Social Security Number . Input should be in the format 'xxx-xx-xxxx' where 'x' is a digit.	
	function ValidateSSN($inputData) 
	{
		if (preg_match('/^\d{3}-\d{2}-\d{4}/',$inputData)) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// Validate credit card .Parameters passed to the function are credit card type and credit card number. Validated card types are 			Visa, American Express(AMAX), Discover, Mastercard, Diners Club, JCBs.
	function ValidateCreditCard($cardType,$cardNum)
	{
		 $cardNum =  str_replace(" ", "", $cardNum);
	    
		switch($cardType) 
		{
    			case 'AMEX':
        			$validCard = '/^3[47]{1}[0-9]{13}$/';
				break;
    			case 'Visa':
        			$validCard = '/^4[0-9]{15}$/';
        			break;
    			case 'Mastercard':
        			$validCard = '/^5[1-5]{1}[0-9]{14}$/';
        			break;
    			case 'Discover':
        			$validCard = '/^6011[0-9]{12}$/';
        			break;
			case 'Diners Club':
        			$validCard = '/^3(0[0-5]|[68][0-9])[0-9]{11}$/';
        			break;
			case 'JCB':
        			$validCard = '/^(3[0-9]{4}|2131|1800)[0-9]{11}$/';
        			break;		
    			default:
        			$validCard  = '/^[0-9]{15,16}$/';
		}
		
		$cardNumber = strrev($cardNum);
		$numSum 	     = 0;
		for($i = 0; $i < strlen($cardNumber); $i++)
		{
  			$currentNum = substr($cardNumber, $i, 1);

			// Double every second digit
			if($i % 2 == 1)
			{
  				$currentNum *= 2;
			}

			// Add digits of 2-digit numbers together
			if($currentNum > 9)
			{
  				$firstNum   = $currentNum % 10;
  				$secondNum  = ($currentNum - $firstNum) / 10;
  				$currentNum = $firstNum + $secondNum;
			}

			$numSum += $currentNum;
			}
			
		if (($numSum % 10 == 0) && (preg_match($validCard,$cardNum)))
 		{
			return true;
		}
		else
	 		return false;
	
	}

	// Validate website Url . Urls in the format 'www...' and http://
	function ValidateUrl($inputData)
	{
		 if (preg_match('/^w{3}\.[0-9a-z\.\?&-_=\+\/]+\.[a-z]{2,4}$/',$inputData)) 
		{
		 	return true;
		}
		else if (preg_match('/^http:\/\/[0-9a-z\.\?&-_=\+\/]+\.[a-z]{2,4}$/',$inputData)) 
		{
		 	return true;
		}
		/*else if (preg_match("#^http://(www{3}\.)?[a-z0-9-_.]+\.[a-z]{2,4}$#i",$inputData)) 
		{
		 	return true;
		}*/
		else
		{
			return false;
		}
			
	}
	function ValidatePasswordMatch($inputData1,$inputData2)
	{
		if((strcoll($inputData1, $inputData2))==0)
		{
			return true;
		}
		else
		{
		return false;
		}
	}	
	//Validate date in dd/mm/yyyy format
	function ValidateDate($date)
	{
		if((strlen($date)<10)OR(strlen($date)>10))
		{
			return false;
		}
		else
		{
			if((substr_count($date,"/"))<>2)
			{
				return false;
			}
			else
			{
				$pos=strpos($date,"/");
				$dateNew=substr($date,0,($pos));
				$result=ereg("^[0-9]+$",$dateNew,$trashed);
				if(!($result))
				{
					return false;
				}
				else
				{
					if(($dateNew<=0)OR($dateNew>31))
					{
						return false;
					}
				}
				$month=substr($date,($pos+1),($pos));
				if(($month<=0)OR($month>12))
				{
					return false;
				}
				else
				{
					$result=ereg("^[0-9]+$",$month,$trashed);
					if(!($result))
					{
						return false;
					}
				}
				$year=substr($date,($pos+4),strlen($date));
				$result=ereg("^[0-9]+$",$year,$trashed);
				if(!($result))
				{
					return false;
				}
				else
				{
					if(($year<2009)OR($year>2200))
					{
						return false;
					}
				}
				return true;
			}
		}
	}
}

?>