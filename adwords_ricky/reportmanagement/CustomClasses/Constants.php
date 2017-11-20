<?php
namespace CustomClasses;

/**
 * This class contains all the constants used in report management.
 *
 * @author user
 */
class Constants {


    public static $GOOGLE_CLIENT_ID = "89739822384-6h5agapf1j1vb3p1f2i5a1fsgit7pi92.apps.googleusercontent.com";
    public static $GOOGLE_CLIENT_SECRET = "xPqgyUz3w02dz6nbNTpLrx7_";
    public static $GOOGLE_CLIENT_REDIRECT_URL = "http://localhost/googleoauth/index.php";
    public static $DIRECTORY_SEPERATOR = "/";
    public static $MAX_COLUMNS = "29";
    public static $SHEET_TITLE1 = "Daily Report";
    public static $SHEET_TITLE2 = "Summary Report";
    public static $SETUP_DIRECTORY_NAME = "setup";
    public static $MANAGER_NAME = "Manager";
    public static $CLIENT_NAME = "Client";
    public static $REPORT_NAME = "Report";
    public static $BUDGET_NAME = "Budget";
    public static $PPC_VISITORS_NAME = "PPC Visitors";
    public static $MAX_MONTH_COUNT = 5;
    public static $HEADER_SETTING_NOT_STARTED = -1;
    public static $HEADER_SETTING_ONGOING = 1;
    public static $HEADER_SETTING_FINISHED = 0;
    public static $PREVIOUS_MONTH = "";
    public static $THIS_MONTH = "";
    public static $PERCENT_AT_THIS_POINT_LAST_MONTH = "% @ This Point on Last Month";
    public static $CHANGE_IN_CPC = "Change in CPC";
    public static $REMAINING_BUDGET = "REMAINING BUDGET";
    public static $REMAINING_BUDGET_AT_PPC_SPEND = "Remaining Budget @ PPC Spend";
    public static $DAILY_BUDGET = "Daily Budget";
    public static $AVG_DAILY_SPEND_MTD = "Avg. Daily Spends MTD";
    public static $PLUS_OR_MINUS_DAILY_BUDGET_AVAILABLE = "+/-  Daily Budget Available";
    public static $YESTERDAY_SPENDS = "Yesterday Spends";
    public static $CONVERSIONS_AT_CURRENT_RATE = "Conversions @ Current Rate";
    public static $PERCENT_ON_LAST_MONTH_AT_CURRENT_RATE = "Percent On Last Month @ Current Rate";
    public static $CHANGE_IN_CPA = "Change in CPA";
    public static $LAST_UPDATED = "Last Updated";
    public static $CLIENT_ID = "Client Id";
    public static $FIRST = 1;
    public static $INT_NO = 0;
    public static $INT_YES = 1;
    public static $DAILY_REPORT_TABLE_NAME = "management_daily_report";
    public static $SUMMERY_REPORT_TABLE_NAME = "management_summery_report";
    public static $TOP_5_WITH_BIGGEST_INCREASE_IN_VISITORS = "Top 5 with Biggest Increase in visitors";
    public static $BIGGEST_INCREASE_IN_CPC = "Biggest Increases in CPC";
    public static $BIGGEST_UNDERSPENDS = "Biggest Underspends";
    public static $WORST_5_WITH_BIGGEST_DECREASE_IN_VISITORS = "Worst 5 with biggest decrease in visitors";
    public static $BEST_DECREASE_IN_CPC = "Best Decreases in CPC";
    public static $BIGGEST_OVERSPENDS = "Biggest Overspends";
    public static $BIGGEST_GAIN_IN_EXPECTED_CONVERSIONS = "Biggest Gain in Expected Conversions";
    public static $BIGGEST_CHANGE_IN_CPA = "Biggest Change in CPA";
    public static $WORST_DROP_IN_EXPECTED_CONVERSIONS = "Worst drop in expected conversions";
    public static $BEST_CHANGE_IN_CPA = "Best Change in CPA";
    public static $PERCENT_VISITORS_TO_LAST_MONTH = "% Visitors to Last Month";
    public static $CPC_DIFF = "CPC Diff";
    public static $REMAINING_SPENDS = "Remaining Spends";
    public static $PERCENT_CONVERSIONS_TO_LAST_MONTH = "% Conversions to Last Month";
    public static $CPC_CHANGE = "CPC Change";
    public static $CPA_CHANGE = "CPA Change";
    public static $ZERO_FILL = array(
        '[value-5]',
        '[value-6]',
        '[value-7]',
        '[value-8]',
        '[value-9]',
        '[value-10]',
        '[value-11]',
        '[value-12]',
        '[value-13]',
        '[value-14]'
    );
    public static $EMPTY_FILL = array(
        '[value-15]',
        '[value-16]',
        '[value-17]',
        '[value-18]',
        '[value-19]',
        '[value-20]'
    );
    public static $USER_ID_REPLACER = '[value-2]';
    public static $USER_REPLACER = '[value-3]';
    public static $CLIENT_REPLACER = '[value-4]';
    public static $PERCENT_VISITORS_TO_LAST_MONTH_REPLACER = '[value-15]';
    public static $CPC_DIFF_REPLACER = '[value-16]';
    public static $REMAINING_SPENDS_REPLACER = '[value-17]';
    public static $PERCENT_CONVERSIONS_TO_LAST_MONTH_REPLACER = '[value-18]';
    public static $CPC_CHANGE_REPLACER = '[value-19]';
    public static $CPA_CHANGE_REPLACER = '[value-20]';
    public static $TOP_5_WITH_BIGGEST_INCREASE_IN_VISITORS_REPLACER = '[value-5]';
    public static $BIGGEST_INCREASE_IN_CPC_REPLACER = '[value-6]';
    public static $BIGGEST_UNDERSPENDS_REPLACER = '[value-7]';
    public static $WORST_5_WITH_BIGGEST_DECREASE_IN_VISITORS_REPLACER = '[value-8]';
    public static $BEST_DECREASES_IN_CPC_REPLACER = '[value-9]';
    public static $BIGGEST_OVERSPENDS_REPLACER = '[value-10]';
    public static $BIGGEST_GAIN_IN_EXPECTED_CONVERSIONS_REPLACER = '[value-11]';
    public static $BIGGEST_CHANGE_IN_CPA_REPLACER = '[value-12]';
    public static $WORST_DROP_IN_EXPECTED_CONVERSIONS_REPLACER = '[value-13]';
    public static $BEST_CHANGE_IN_CPA_REPLACER = '[value-14]';

    public static $SHEET_IDS = array(
        'ricky@pushgroup.co.uk' => '1LVKJ-ti1BcYktSli94Q4RPCzzCyz01fzTk4kYUaO3UI',
//        'charlie@pushgroup.co.uk' => '1LVKJ-ti1BcYktSli94Q4RPCzzCyz01fzTk4kYUaO3UI',
        'jasleen@pushgroup.co.uk' => '1M3EQ83DZXk4TIMEhYDat5F71tzV862QI14q9dmZJiu8',
        'keerat@pushgroup.co.uk' => '1NebWohgN88AGX08NFIcQZnQsZXWxEJrpVR-dn8BJy8M',
        'chandni@pushgroup.co.uk' => '1ljoIR1M6F4QxBfLl9h2yfh5DEe8KsmMyggUILStOAlA',
        'monique@pushgroup.co.uk' => '1Aqm1jiHyIo9c1CiEIR440ixLBwiDORa6FCiyAYpyY7k',
        'rob@pushgroup.co.uk' => '1upPdCeCRZKwCRdLCfeVg0zWqBRBqtBC8OJWOv0AqeQs',
        'isuru@pushgroup.co.uk' => '1RH6Dv4BNdZXZbs_qEIKPAg88ELZCmtFSSo4aFGsNHXM',
        'reece@pushgroup.co.uk' => '1LqVg0uVgceKi--LAemxV697Zpb3CT2TijGXE49qHPAM',
        'stefan@pushgroup.co.uk' => '1RqqvLaEgc-Nm39Y513h_Ir52o6I1Ge3kM8oxzPhIuhg',
        'neeraj@pushgroup.co.uk' => '1q27NIZ5kvAjnypatqOJE6FkbEXEwK3iQvyJGZRjCjjk'
    );
    public static $DEFAULT_EMAIL_TAIL = '@pushgroup.co.uk';
    public static $MASTER_NAME ='ricky@pushgroup.co.uk';



    public static $TOP_FIVE_BIGGEST_INCREASE_IN_VISITORS_INDEX = 1;
    public static $BIGGEST_INCREASE_IN_CPC_INDEX = 2;
    public static $BIGGEST_UNDERSPEND_INDEX = 3;
    public static $WORST_FIVE_WITH_BIGGEST_DECREASE_IN_VISITORS_INDEX = 4;
    public static $BEST_DECREASE_IN_CPC_INDEX = 5;
    public static $BIGGEST_OVERSPENDS_INDEX = 6;
    public static $BIGGEST_GAIN_IN_EXPECTED_CONVERSIONS_INDEX = 7;
    public static $BIGGEST_CHANGE_IN_CPA_INDEX = 8;
    public static $WORST_DROP_IN_EXPECTED_CONVERSIONS_INDEX = 9;
    public static $BEST_CHANGE_IN_CPA_INDEX = 10;
    public static $DAILY_REPORT_INDEX = 11;
    public static $CAMPAIGN_REPORT_INDEX = 12;

    public static $REPOTRS = array(
        11 => 'Daily Reports',
        1 => 'Summary Reports',
    );
    public static $NOT_ALLOWED_HERE = 'You are not allowed here.';
    public static $SESSION_USER_NAME = "user_name";
    public static $SESSION_USER_TYPE = "user_type";
    public static $SESSION_USER_USERS = "user_usernames";
    public static $POST_REQUEST_REPORT_NAME = "report";
    public static $POST_REQUEST_NAME = "POST";
    public static $MONTH_OF_DATE = 'F';
    public static $RESPONSE_CODE_OK = 1;
    public static $RESPONSE_CODE_ERROR = 0;
}
?>