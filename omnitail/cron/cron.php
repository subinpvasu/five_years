<?php
/* try{
/* $cron_file = 'cron_filename';
// Create the file
touch($cron_file);
// Make it writable
chmod($cron_file, 0777);
// Save the cron
file_put_contents($cron_file, '05 * * * * /usr/bin/curl http://omnitailtools.com/cron/sendmail.php');
// Install the cron
exec('crontab cron_file'); */
/*echo 'subin';
//exec('echo -e "crontab -l\n05 * * * * /usr/bin/curl http://omnitailtools.com/cron/sendmail.php" | crontab -');
}
catch (Exception $e)
{
    echo $e->getMessage();
} */

exec('echo -e "`crontab -l`\n05 * * * * /usr/bin/curl http://omnitailtools.com/cron/sendmail.php" | crontab -');