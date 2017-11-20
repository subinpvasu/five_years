<?php

class DbexportController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionSongs()
	{
		
		$filename = Yii::getPathOfAlias('webroot')."/dbexport/songs/songs_".date('Y-m-d').".csv";
		if(file_exists($filename)) unlink($filename);
		$file = fopen($filename,"x+");
		$list = array('Title', 'Artist', 'Label', 'Year');
		fputcsv($file, $list);
		//$condition = '`royalty` = 1 ';
		$songs_list = Songs::model()->findAll();
		foreach($songs_list as $selected_song)
		{
			$str_remove = array('{','}');			
			$tags = explode(',',str_replace($str_remove,'',$selected_song->style));
			if(!in_array(16,$tags)) 
			{
				$song_name = str_replace(',','',$selected_song->name);
				$artist = str_replace(',','',$selected_song->artist);
				$label = str_replace(',','',$selected_song->publisher);
				fputcsv($file, array( $song_name, $artist, $label, date('Y',strtotime($selected_song->year))));
			}
		}
		fclose($file);
		$url = 'http://'.Yii::app()->request->getServerName().'/instore_php/dbexport/songs/songs_'.date('Y-m-d').".csv";
		
		$this->redirect($url);
		//echo $filename;
		exit;
		
	}
	public function actionCustomers()
	{
		$condition = '`status` = 1 ';
		$customers_list = Customers::model()->findAll(array('condition'=> $condition));
		$filename = Yii::getPathOfAlias('webroot')."/dbexport/customers/customers_".date('Y-m-d').".csv";
		if(file_exists($filename)) unlink($filename);
		$file = fopen($filename,"x+");
		$list = array('Ragione sociale', 'Partita IVA', 'Insegna', 'Tipologia di esercizio', 'Indirizzo', 'Località', 'CAP', 'Provincia','Start date','End date', 'Tipo di servizio');
		fputcsv($file, $list);
		echo '<pre>';
		foreach($customers_list as $customer_details)
		{
			//print_r($customer_details);
			$company_name = strtolower($customer_details->company);
			$customer_name = strtolower($customer_details->name);
			if(!preg_match("/test/", $company_name) && !preg_match("/test/", $customer_name))
			{
				
				$start_dat = $end_dat = '';
				if($customer_details->start_date != '0000-00-00') $start_dat = $customer_details->start_date;
				if($customer_details->end_date != '0000-00-00') $end_dat = $customer_details->end_date;
				$company = str_replace(',','',$customer_details->company);
				$vat = str_replace(',','',$customer_details->vat);
				$name = str_replace(',','',$customer_details->name);
				$shop_type = str_replace(',','',$customer_details->shop_type);
				$addresses = str_replace(',','',$customer_details->addresses);
				$city = str_replace(',','',$customer_details->city);
				$zip = str_replace(',','',$customer_details->zip);
				$location = str_replace(',','',$customer_details->location);
				fputcsv($file, array($company, $vat, $name, $shop_type, $addresses, $city, $zip, $location, $start_dat, $end_dat, 'AUDIO' ));
			}
		}
		
		fclose($file);
		$url = 'http://'.Yii::app()->request->getServerName().'/instore_php/dbexport/customers/customers_'.date('Y-m-d').".csv";
		
		$this->redirect($url);
		//echo $filename;
		exit;
		
	}
	public function actionStatusupdate()
	{
	echo '<pre>';
		$model = new Customers;
		$current_month_day = date('m-d');
		$customers_list = Customers::model()->findAll();
		foreach($customers_list as $customer)
		{
			$model = new Customers; 
			if($customer->start_date != '0000-00-00' && $customer->end_date != '0000-00-00')
			{
				echo $customer->start_date.' To '.$customer->end_date;
				$start_month_day = date('m-d',strtotime($customer->start_date));
				$end_month_day = date('m-d',strtotime($customer->end_date));
				if($current_month_day >= $start_month_day && $current_month_day <= $end_month_day) 
				{ 
					if($customer->status != 1) $model->updateByPk($customer->id,array('status' => 1));
					echo 'Step1 Active'.'<br />';
				}
				elseif($current_month_day >= $start_month_day && $start_month_day >= $end_month_day) 
				{ 
					if($customer->status != 1) $model->updateByPk($customer->id,array('status' => 1));
					echo 'Step2 Active'.'<br />';
				}
				elseif($current_month_day <= $start_month_day && $current_month_day <= $end_month_day && $start_month_day > $end_month_day) 
				{ 
					if($customer->status != 1) $model->updateByPk($customer->id,array('status' => 1));
					echo 'Step3 Active'.'<br />';
				}
				else 
				{
					if($customer->status != 0) $model->updateByPk($customer->id,array('status' => 0));
					echo 'Step3 Suspended'.'<br />';
				}
			}
		}
		exit;
		
	}
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}