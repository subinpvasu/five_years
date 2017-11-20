<?
// Create Customer playlist
class CreateplaylistCommand extends CConsoleCommand {
	 public function run($args) {
		$today = date('y-m-d');
		$d=strtotime("-1 year");
		$songs_from = date("Y-m-d", $d);
		$songs_to = date("Y-m-d");
		$customer_seperated_played_songs = array();
		$condition = "`played_date` BETWEEN '$songs_from' AND '$songs_to' ";
		$customers_played_lists = Yii::app()->db->createCommand()
			->select('u.*, p.name, p.artist, p.label, p.publisher, p.song_length')
			->from('tbl_playedsong u')
			->leftJoin('tbl_songs p', 'u.song=p.id')
			->where($condition)
			->order('u.id ASC')
			//->order('')
			->queryAll();
		//	echo  '<pre>';
		foreach($customers_played_lists as $customers_played_list)
		{
			if(!array_key_exists($customers_played_list['uid'], $customer_seperated_played_songs))
			{
				$customer_seperated_played_songs[$customers_played_list['uid']] = array();
			}
			array_push($customer_seperated_played_songs[$customers_played_list['uid']], $customers_played_list);
		}
		$condition = '`status` = 1 ';
		$customers_list = Customers::model()->findAll(array('condition'=> $condition));
		$filename = Yii::getPathOfAlias('webroot')."/dbexport/playlist/playlists_".date('Y-m-d').".csv";
		if(file_exists($filename)) unlink($filename);
		$file = fopen($filename,"x+");
		foreach($customers_list as $customers)
		{
			$company_name = strtolower($customers->company);
			$customer_name = strtolower($customers->name);
			if(!preg_match("/test/", $company_name) && !preg_match("/test/", $customer_name))
			{
				$list = array("Plalylist DB from $songs_from to $songs_to for customer ".$customers->uid);
				fputcsv($file, $list);
				$list = array('Title', 'Artist', 'Label', 'Play Date', 'Length','Ragione sociale','Insegna');
				fputcsv($file, $list);
				if(array_key_exists($customers->id, $customer_seperated_played_songs))
				{
					$single_user_played_songs = $customer_seperated_played_songs[$customers->id];
					foreach($single_user_played_songs as $selected_song)
					{					
						$song_name =str_replace(',','',$selected_song['name']);
						$artist =str_replace(',','',$selected_song['artist']);
						$label =str_replace(',','',$selected_song['publisher']);
						$company =str_replace(',','',$customers->company);
						$customer_name =str_replace(',','',$customers->name);
						fputcsv($file, array($song_name, $artist, $label, $selected_song['played_date'], $selected_song['song_length'], $company, $customer_name ));					
					}
				}
			}
		}
		fclose($file);
		$condition = "`created_date` = '$today'";
		
		$created_playlist = Createdplaylists::model()->findAll(array('condition'=> $condition));
		{
			$playlist_id = $created_playlist[0]->id;
			Createdplaylists::model()->updateByPk($playlist_id,array('status' => 1));
			$user_email = 'caarif123@gmail.com';
			$msg = '<body width="700px">
				<a href="http://ubi-sound.eu/instore_php"><img width="700px" src="http://ubi-sound.eu/instore_php/images/header.png" alt="Header image"></a><br><br>
				Hi  <br><br>	
				Playlist DB is created. You can click <a target="_blank" href="http://ubi-sound.eu/instore_php/index.php?r=customers/playlist">Here</a> to download playlist DB. <br>
								
		Thank you,<br><br>
		Ubi Sound<br>
		<a target="_blank" href="http://ubi-sound.eu/instore_php/index.php">Ubi Sound</a>
		</div>
		<a href="http://ubi-sound.eu/instore_php/index.php"><img width="700px" src="http://ubi-sound.eu/instore_php/images/footer.png" alt="Footer image"></a>
		</body>';
		$name='=?UTF-8?B?'.base64_encode('Instore').'?=';
		$subject='=?UTF-8?B?'.base64_encode('Playlist DB').'?=';
		$headers="From: Ubi Sound <info@ubi-sound.it>\r\n".
			"MIME-Version: 1.0\r\n".
			"Content-type: text/html; charset=iso-8859-1" . "\r\n".
			"CC:  info@ubi-sound.it";
			if(mail($user_email,$subject,$msg,$headers)) echo 'Success';
			
		}
	}
}
?>