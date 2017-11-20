<?
// Create Customer playlist
class CustomerstatusCommand extends CConsoleCommand {

	public function run($args) {
			$model = new Customers;
		$current_month_day = date('m-d');
		echo $current_month_day;
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
	}

}
?>