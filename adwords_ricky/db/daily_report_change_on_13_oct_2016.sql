DELIMITER $$

DROP PROCEDURE IF EXISTS `spad_getdailyreports` $$
CREATE  PROCEDURE `spad_getdailyreports`(refusername varchar(45), refUid int, refCustName varchar(45))
BEGIN

    if refusername='' or refusername='master' then
      if refUid<>'' then
        select * from management_daily_report where user_id_fk=refUid and client_name like CONCAT('%', refCustName, '%') order by (round(TRIM(TRAILING '%' FROM percent_on_last_month_at_current_rate))) asc;
      else
        select * from management_daily_report order by (round(TRIM(TRAILING '%' FROM percent_on_last_month_at_current_rate))) asc;
      end if;
    else
      select * from management_daily_report where user_name = refusername order by (round(TRIM(TRAILING '%' FROM percent_on_last_month_at_current_rate))) asc;
    end if;


END $$

DELIMITER ;