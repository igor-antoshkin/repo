DELIMITER $$

DROP PROCEDURE IF EXISTS `ikway`.`closest` $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `closest`(IN mylat double, IN mylon double, IN number int)
BEGIN

declare cnt int;
declare step double;

set step=0.010000;
set cnt=0;

drop temporary table if exists temp;

create temporary table temp (id_user int not null, dist double not null);

qqq:  WHILE (cnt < number) DO
      set step=step*10;
      INSERT into temp
      (SELECT id_user,dist(mylat,mylon, lat,lon) FROM tbl_online WHERE MBRContains(LINESTRING(POINT(mylat-step,mylon-step),POINT(mylat+step,mylon+step)),ll)  and dist(mylat,mylon, lat,lon)<=(step*111));
      select count(distinct id_user) into cnt from temp;

      if (step>=180) then leave qqq; end if;

  END WHILE qqq;


-- SET @s = CONCAT('select distinct * from temp order by dist limit ',number);
SET @s = CONCAT('select distinct * from temp join tbl_profiles on temp.id_user=tbl_profiles.user_id order by dist limit ',number);

PREPARE go FROM @s;
EXECUTE go;

drop temporary table temp;

END $$

DELIMITER ;