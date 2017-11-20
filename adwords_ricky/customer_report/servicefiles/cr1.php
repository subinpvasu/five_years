<?php
/*

 *
 * Service file for showing customer report

 * Exicutive Summery. Last month compared with current month
 *

 */

require_once dirname(__FILE__) . '/../../includes/includes.php';
$id = $_REQUEST['id'];
$month = $_SESSION['monthTxt']=  $_REQUEST['month'];
$type = $_REQUEST['type'];



if ($type == 0) {
    $startDate = date("Y-m-d", strtotime('first day of this month', strtotime($month)));
    if ($month == date('Y-m')) {
        $endDate = date('Y-m-d');
    } else {
        $endDate = date("Y-m-d", strtotime('last day of this month', strtotime($month)));
    }

    $thispart = "'$month'";

    $datestring = $startDate . ' first day of last month';
    $dt = date_create($datestring);
    $last_month = $dt->format('Y-m');
    $lastpart = "'$last_month'";
} elseif ($type == 1) {

    $e = explode("-", $month);

    $quarter = substr($e[0], -1);

    $year = $e[1];
    $lyear = $year - 1;

    switch ($quarter) {

        case 1 : $startDate = "$year-01-01";
            $endDate = "$year-03-31";
            $thispart = "'$year-01','$year-02','$year-03'";
            $lastpart = "'$lyear-10','$lyear-11','$lyear-12'";
            break;

        case 2 : $startDate = "$year-04-01";
            $endDate = "$year-06-30";
            $thispart = "'$year-04','$year-05','$year-06'";
            $lastpart = "'$year-01','$year-02','$year-03'";
            break;

        case 3 : $startDate = "$year-07-01";
            $endDate = "$year-09-30";
            $thispart = "'$year-07','$year-08','$year-09'";
            $lastpart = "'$year-04','$year-05','$year-06'";
            break;

        case 4 : $startDate = "$year-10-01";
            $endDate = "$year-12-31";
            $thispart = "'$year-10','$year-11','$year-12'";
            $lastpart = "'$year-07','$year-08','$year-09'";
            break;

        default : break;
    }
}

$_SESSION['account_id'] = $id;
$_SESSION['startDate'] = $startDate;
$_SESSION['endDate'] = $endDate;
$_SESSION['report_select_type'] = $type ;

$sql = "SELECT `ad_account_adword_id`,SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`)ad_Impressions ,ROUND((SUM(`ad_Cost`)/1000000),2) as ad_Cost , ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ad_Ctr,ROUND((AVG(`ad_AverageCpc`)/1000000),2) as ad_AverageCpc,ROUND(AVG(`ad_ConversionRate`),2) ad_ConversionRate,SUM(`ad_Conversions`) ad_Conversions,ROUND((SUM(`ad_CostPerConversion`)/1000000),2) as ad_CostPerConversion,SUM(`ad_ConversionValue`) ad_ConversionValue,AVG(`ad_SearchImpressionShare`) ad_SearchImpressionShare ,SUM(`ad_EstimatedTotalConversions`) ad_EstimatedTotalConversions ,ROUND((SUM(`ad_Cost`)/(SUM(`ad_EstimatedTotalConversions`)*1000000)),2) as ad_CostPerEstConv FROM  adword_monthly_report WHERE ad_account_adword_id='$id' and ad_month IN ($thispart) ";

$mntData = $main->getRow($sql);

$sql = "SELECT `ad_account_adword_id`,SUM(`ad_Clicks`) ad_Clicks,SUM(`ad_Impressions`)ad_Impressions ,ROUND((SUM(`ad_Cost`)/1000000),2) as ad_Cost , ROUND(((SUM(ad_Clicks)/SUM(ad_Impressions)) * 100),2) ad_Ctr,ROUND((AVG(`ad_AverageCpc`)/1000000),2) as ad_AverageCpc,ROUND(AVG(`ad_ConversionRate`),2) ad_ConversionRate,SUM(`ad_Conversions`) ad_Conversions,ROUND((SUM(`ad_CostPerConversion`)/1000000),2) as ad_CostPerConversion,SUM(`ad_ConversionValue`) ad_ConversionValue,AVG(`ad_SearchImpressionShare`) ad_SearchImpressionShare ,SUM(`ad_EstimatedTotalConversions`) ad_EstimatedTotalConversions ,ROUND((SUM(`ad_Cost`)/(SUM(`ad_EstimatedTotalConversions`)*1000000)),2) as ad_CostPerEstConv FROM  adword_monthly_report WHERE ad_account_adword_id='$id' and ad_month IN ($lastpart) ";

$lmntData = $main->getRow($sql);



$type = array();

$sql = "SELECT ad_ConversionTypeName,SUM(ad_Conversions) ad_Conversions FROM  adword_convtype_report WHERE ad_account_adword_id='" . $id . "' and ad_month in($thispart) GROUP BY ad_ConversionTypeName ";
$result = $main->getResults($sql);

foreach ($result as $val) {

    $mntConv[$val->ad_ConversionTypeName] = $val->ad_Conversions;

    if (!in_array($val->ad_ConversionTypeName, $type)) {
        $type[] = $val->ad_ConversionTypeName;
    }
}
$sql = "SELECT ad_ConversionTypeName,SUM(ad_Conversions) ad_Conversions FROM  adword_convtype_report WHERE ad_account_adword_id='" . $id . "' and ad_month in($lastpart) GROUP BY ad_ConversionTypeName";
$result = $main->getResults($sql);

foreach ($result as $val) {

    $lmntConv[$val->ad_ConversionTypeName] = $val->ad_Conversions;
    if (!in_array($val->ad_ConversionTypeName, $type)) {
        $type[] = $val->ad_ConversionTypeName;
    }
}
$typeCount = count($type);

// impression variation

$imp_var = round($mntData->ad_Impressions / $lmntData->ad_Impressions * 100, 2);
if ($imp_var > 100) {
    $imp_span = "<div class='green_span'>  <img src=" . SITE_URL . "images/gu.png />" . ($imp_var - 100) . " %</div>";
} else if ($imp_var < 100) {
    $imp_span = "<div class='red_span'>  <img src=" . SITE_URL . "images/gd.png /> " . (100 - $imp_var) . " %</div>";
} else {
    $imp_span = "<div class='zero_span'> n/a </div>";
}

// click variation

$cli_var = round($mntData->ad_Clicks / $lmntData->ad_Clicks * 100, 2);
if ($cli_var > 100) {
    $cli_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cli_var - 100) . " %</div>";
} else if ($cli_var < 100) {
    $cli_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cli_var) . " %</div>";
} else {
    $cli_span = "<div class='zero_span'> n/a </div>";
}
// ad_Conversions variation

$conv_var = round($mntData->ad_Conversions / $lmntData->ad_Conversions * 100, 2);
if ($conv_var > 100) {
    $conv_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($conv_var - 100) . " %</div>";
} else if ($conv_var < 100) {
    $conv_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $conv_var) . " %</div>";
} else {
    $conv_span = "<div class='zero_span'> n/a </div>";
}
// ad_EstimatedTotalConversions variation

$est_var = round($mntData->ad_EstimatedTotalConversions / $lmntData->ad_EstimatedTotalConversions * 100, 2);
if ($est_var > 100) {
    $est_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($est_var - 100) . " %</div>";
} else if ($est_var < 100) {
    $est_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $est_var) . " %</div>";
} else {
    $est_span = "<div class='zero_span'> n/a </div>";
}
// ad_Ctr variation

$ctr_var = round($mntData->ad_Ctr / $lmntData->ad_Ctr * 100, 2);
if ($ctr_var > 100) {
    $ctr_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($ctr_var - 100) . " %</div>";
} else if ($ctr_var < 100) {
    $ctr_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $ctr_var) . " %</div>";
} else {
    $ctr_span = "<div class='zero_span'> n/a </div>";
}
// ad_AverageCpc variation

$cpc_var = round($mntData->ad_AverageCpc / $lmntData->ad_AverageCpc * 100, 2);
if ($cpc_var > 100) {
    $cpc_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gd.png />" . ($cpc_var - 100) . " %</div>";
} else if ($cpc_var < 100) {
    $cpc_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gu.png />" . (100 - $cpc_var) . " %</div>";
} else {
    $cpc_span = "<div class='zero_span'> n/a </div>";
}
// ad_ConversionRate variation

$crate_var = round($mntData->ad_ConversionRate / $lmntData->ad_ConversionRate * 100, 2);
if ($crate_var > 100) {
    $crate_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($crate_var - 100) . " %</div>";
} else if ($crate_var < 100) {
    $crate_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $crate_var) . " %</div>";
} else {
    $crate_span = "<div class='zero_span'> n/a </div>";
}
// cost variation

$cst_var = round($mntData->ad_Cost / $lmntData->ad_Cost * 100, 2);
if ($cst_var > 100) {
    $cst_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cst_var - 100) . " %</div>";
} else if ($cst_var < 100) {
    $cst_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cst_var) . " %</div>";
} else {
    $cst_span = "<div class='zero_span'> n/a </div>";
}
// cost / conv variation

$cpcon_var = round($mntData->ad_CostPerConversion / $lmntData->ad_CostPerConversion * 100, 2);
if ($cpcon_var > 100) {
    $cpcon_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cpcon_var - 100) . " %</div>";
} else if ($cpcon_var < 100) {
    $cpcon_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cpcon_var) . " %</div>";
} else {
    $cpcon_span = "<div class='zero_span'> n/a </div>";
}
// ad_CostPerEstConv variation

$cpec_var = round($mntData->ad_CostPerEstConv / $lmntData->ad_CostPerEstConv * 100, 2);
if ($cpec_var > 100) {
    $cpec_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cpec_var - 100) . " %</div>";
} else if ($cpec_var < 100) {
    $cpec_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cpec_var) . " %</div>";
} else {
    $cpec_span = "<div class='zero_span'> n/a </div>";
}


// ad_ConversionValue variation

$cv_var = round($mntData->ad_ConversionValue / $lmntData->ad_ConversionValue * 100, 2);
if ($cv_var > 100) {
    $cv_span = "<div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cv_var - 100) . " %</div>";
} else if ($cv_var < 100) {
    $cv_span = "<div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cv_var) . " %</div>";
} else {
    $cv_span = "<div class='zero_span'> n/a </div>";
}
?>
<div class='classb3'>

    <table class="table1" border=1>

        <tr>
            <td><div class="hone">IMPRESSIONS</div>
                <div class="htwo"><?php echo number_format($mntData->ad_Impressions); ?></div>
                <div class="hthree"><?php echo number_format($lmntData->ad_Impressions); ?></div>
                <div class="hfour"><div class="classb4"><?php echo $imp_span; ?></div></div></td>
            <td><div class="hone">CLICKS</div>
                <div class="htwo"><?php echo number_format($mntData->ad_Clicks); ?></div>
                <div class="hthree"><?php echo number_format($lmntData->ad_Clicks); ?></div>
                <div class="hfour"><div class="classb4"><?php echo $cli_span; ?></div></div></td>
            <td><div class="hone">CONVERSIONS</div>
                <div class="htwo"><?php echo $mntData->ad_Conversions; ?></div>
                <div class="hthree"><?php echo $lmntData->ad_Conversions; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $conv_span; ?></div></div></td>
            <td><div class="hone">ESTIMATE CONVERSIONS</div>
                <div class="htwo"><?php echo $mntData->ad_EstimatedTotalConversions; ?></div>
                <div class="hthree"><?php echo $lmntData->ad_EstimatedTotalConversions; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $est_span; ?></div></div></td>
            <td><div class="hone">CTR</div>
                <div class="htwo"><?php echo $mntData->ad_Ctr; ?>%</div>
                <div class="hthree"><?php echo $lmntData->ad_Ctr; ?>%</div>
                <div class="hfour"><div class="classb4"><?php echo $ctr_span; ?></div></div></td>
            <td><div class="hone">CPC</div>
                <div class="htwo"><?php echo $mntData->ad_AverageCpc; ?></div>
                <div class="hthree"><?php echo $lmntData->ad_AverageCpc; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $cpc_span; ?></div></div></td></tr>
        <tr>
            <td><div class="hone">CONVERSION RATE</div>
                <div class="htwo"><?php echo $mntData->ad_ConversionRate; ?></div>
                <div class="hthree"><?php echo $lmntData->ad_ConversionRate; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $crate_span; ?></div></div></td>
            <td><div class="hone">COST</div>
                <div class="htwo"><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $mntData->ad_Cost; ?></div>
                <div class="hthree"><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $lmntData->ad_Cost; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $cst_span; ?></div></div></td>
            <td><div class="hone">COST / CONVERSION </div>
                <div class="htwo"><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $mntData->ad_CostPerConversion; ?></div>
                <div class="hthree"><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $lmntData->ad_CostPerConversion; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $cpcon_span; ?></div></div></td>
            <td><div class="hone">COST / EST CONVERSIONS</div>
                <div class="htwo"><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $mntData->ad_CostPerEstConv; ?></div>
                <div class="hthree"><?php echo $_SESSION['ad_account_currencyCode']; ?><?php echo $lmntData->ad_CostPerEstConv; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $cpec_span; ?></div></div></td>
            <td><div class="hone">CONVERSION VALUE</div>

                <div class="htwo"><?php echo $mntData->ad_ConversionValue; /* echo "round( ".$mntData->ad_ConversionValue." / ".$lmntData->ad_ConversionValue."  * 100 ,2)";  */ ?></div>
                <div class="hthree"><?php echo $lmntData->ad_ConversionValue; ?></div>
                <div class="hfour"><div class="classb4"><?php echo $cv_span; ?></div></div></td>
            <td><div class="hone">&nbsp;</div>
                <div class="htwo">&nbsp;</div>
                <div class="hthree">&nbsp;</div>
                <div class="hfour"><div>&nbsp;</div></div></td></tr>					


        <tr>

            <?php
            if ($type[0] == "") {
                $type_name = $this_month = $last_month = "&nbsp";
                $pdiv = "&nbsp;";
            }

            $type_name = $type[0];
            $this_month = $mntConv[$type[0]];
            $last_month = $lmntConv[$type[0]];

            $cv_var = round(( $this_month / $last_month ) * 100, 2);
            if ($cv_var > 100) {
                $pdiv = "<div class='classb4'><div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cv_var - 100) . " %</div></div>";
            } else if ($cv_var < 100) {
                $pdiv = "<div class='classb4'><div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cv_var) . " %</div></div>";
            } else {
                $pdiv = "<div class='classb4'><div class='zero_span'> n/a </div></div>";
            }
            ?>

            <td colspan=2 ><div class="hone"><?php echo $type_name; ?></div>
                <div class="htwo"><?php echo $this_month; ?></div>
                <div class="hthree"><?php echo $last_month; ?></div>
                <div class="hfour"><?php echo $pdiv; ?></div></td>

            <?php
            if ($type[1] == "") {
                $type_name = $this_month = $last_month = "&nbsp";
                $pdiv = "&nbsp;";
            }

            $type_name = $type[1];
            $this_month = $mntConv[$type[1]];
            $last_month = $lmntConv[$type[1]];

            $cv_var = round(( $this_month / $last_month ) * 100, 2);
            if ($cv_var > 100) {
                $pdiv = "<div class='classb4'><div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cv_var - 100) . " %</div></div>";
            } else if ($cv_var < 100) {
                $pdiv = "<div class='classb4'><div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cv_var) . " %</div></div>";
            } else {
                $pdiv = "<div class='classb4'><div class='zero_span'> n/a </div></div>";
            }
            ?>

            <td colspan=2 ><div class="hone"><?php echo $type_name; ?></div>
                <div class="htwo"><?php echo $this_month; ?></div>
                <div class="hthree"><?php echo $last_month; ?></div>
                <div class="hfour"><?php echo $pdiv; ?></div></td>

            <?php
            if ($type[2] == "") {
                $type_name = $this_month = $last_month = "&nbsp";
                $pdiv = "&nbsp;";
            } else {
                $type_name = $type[2];
                $this_month = $mntConv[$type[2]];
                $last_month = $lmntConv[$type[2]];

                $cv_var = round(( $this_month / $last_month ) * 100, 2);
                if ($cv_var > 100) {
                    $pdiv = "<div class='classb4'><div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cv_var - 100) . " %</div></div>";
                } else if ($cv_var < 100) {
                    $pdiv = "<div class='classb4'><div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cv_var) . " %</div></div>";
                } else {
                    $pdiv = "<div class='classb4'><div class='zero_span'> n/a </div></div>";
                }
            }
            ?>

            <td colspan=2 ><div class="hone"><?php echo $type_name; ?></div>
                <div class="htwo"><?php echo $this_month; ?></div>
                <div class="hthree"><?php echo $last_month; ?></div>
                <div class="hfour"><?php echo $pdiv; ?></div></td>


        </tr>					

<?php if (count($type) > 3) { ?>
            <tr>

            <?php
            if ($type[3] == "") {
                $type_name = $this_month = $last_month = "&nbsp";
                $pdiv = "&nbsp;";
            }

            $type_name = $type[3];
            $this_month = $mntConv[$type[3]];
            $last_month = $lmntConv[$type[3]];

            $cv_var = round(( $this_month / $last_month ) * 100, 2);
            if ($cv_var > 100) {
                $pdiv = "<div class='classb4'><div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cv_var - 100) . " %</div></div>";
            } else if ($cv_var < 100) {
                $pdiv = "<div class='classb4'><div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cv_var) . " %</div></div>";
            } else {
                $pdiv = "<div class='classb4'><div class='zero_span'> n/a </div></div>";
            }
            ?>

                <td colspan=2 ><div class="hone"><?php echo $type_name; ?></div>
                    <div class="htwo"><?php echo $this_month; ?></div>
                    <div class="hthree"><?php echo $last_month; ?></div>
                    <div class="hfour"><?php echo $pdiv; ?></div></td>

    <?php
    if ($type[4] == "") {
        $type_name = $this_month = $last_month = "&nbsp";
        $pdiv = "&nbsp;";
    }

    $type_name = $type[4];
    $this_month = $mntConv[$type[4]];
    $last_month = $lmntConv[$type[4]];

    $cv_var = round(( $this_month / $last_month ) * 100, 2);
    if ($cv_var > 100) {
        $pdiv = "<div class='classb4'><div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cv_var - 100) . " %</div></div>";
    } else if ($cv_var < 100) {
        $pdiv = "<div class='classb4'><div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cv_var) . " %</div></div>";
    } else {
        $pdiv = "<div class='classb4'><div class='zero_span'> n/a </div></div>";
    }
    ?>

                <td colspan=2 ><div class="hone"><?php echo $type_name; ?></div>
                    <div class="htwo"><?php echo $this_month; ?></div>
                    <div class="hthree"><?php echo $last_month; ?></div>
                    <div class="hfour"><?php echo $pdiv; ?></div></td>

    <?php
    if ($type[5] == "") {
        $type_name = $this_month = $last_month = "&nbsp";
        $pdiv = "&nbsp;";
    }

    $type_name = $type[5];
    $this_month = $mntConv[$type[5]];
    $last_month = $lmntConv[$type[5]];

    if ($cv_var > 100) {
        $pdiv = "<div class='classb4'><div class='green_span'> <img src=" . SITE_URL . "images/gu.png />" . ($cv_var - 100) . " %</div></div>";
    } else if ($cv_var < 100) {
        $pdiv = "<div class='classb4'><div class='red_span'> <img src=" . SITE_URL . "images/gd.png />" . (100 - $cv_var) . " %</div></div>";
    } else {
        $pdiv = "<div class='classb4'><div class='zero_span'> n/a </div></div>";
    }
    ?>

                <td colspan=2 ><div class="hone"><?php echo $type_name; ?></div>
                    <div class="htwo"><?php echo $this_month; ?></div>
                    <div class="hthree"><?php echo $last_month; ?></div>
                    <div class="hfour"><?php echo $pdiv; ?></div></td>


            </tr>					

<?php } ?>
    </table>

</div>