<?php
namespace CustomClasses;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DailyReport
 *
 * @author user
 */
class DailyReport {
    public $reportId;
    public $userId; 
    public $userName;
    public $clientName;
    public $reportStatus;
    public $budget;
    public $ppcVisitorsLastMonth;
    public $ppcVisitorsCurrentMonth;
    public $percentAtThisPointLastMonth;
    public $cpcLastMonth;
    public $cpcCurrentMonth;
    public $changeInCpc;
    public $ppcSpendLastMonth;
    public $ppcSpendCurrentMonth;
    public $remainingBudget;
    public $remainingBudgetAtPpcSpend;
    public $dailyBudget;
    public $avgDailySpendsMtd;
    public $plusOrMinusDailyBudgetAvailable;
    public $yesterdaySpends;
    public $adwordsConversionsLastMonth;
    public $adwordsConversionsCurrentMonth;
    public $conversionsAtCurrentRate;
    public $percentOnLastMonthAtCurrentRate;
    public $ppcCpaLastMonth;
    public $ppcCpaCurrentMonth;
    public $changeInCpa;
    public $lastUpdated;
    public $clientId;
    
    function getReportId() {
        return $this->reportId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getUserName() {
        return $this->userName;
    }

    function getClientName() {
        return $this->clientName;
    }

    function getReportStatus() {
        return $this->reportStatus;
    }

    function getBudget() {
        return $this->budget;
    }

    function getPpcVisitorsLastMonth() {
        return $this->ppcVisitorsLastMonth;
    }

    function getPpcVisitorsCurrentMonth() {
        return $this->ppcVisitorsCurrentMonth;
    }

    function getPercentAtThisPointLastMonth() {
        return $this->percentAtThisPointLastMonth;
    }

    function getCpcLastMonth() {
        return $this->cpcLastMonth;
    }

    function getCpcCurrentMonth() {
        return $this->cpcCurrentMonth;
    }

    function getChangeInCpc() {
        return $this->changeInCpc;
    }

    function getPpcSpendLastMonth() {
        return $this->ppcSpendLastMonth;
    }

    function getPpcSpendCurrentMonth() {
        return $this->ppcSpendCurrentMonth;
    }

    function getRemainingBudget() {
        return $this->remainingBudget;
    }

    function getRemainingBudgetAtPpcSpend() {
        return $this->remainingBudgetAtPpcSpend;
    }

    function getDailyBudget() {
        return $this->dailyBudget;
    }

    function getAvgDailySpendsMtd() {
        return $this->avgDailySpendsMtd;
    }

    function getPlusOrMinusDailyBudgetAvailable() {
        return $this->plusOrMinusDailyBudgetAvailable;
    }

    function getYesterdaySpends() {
        return $this->yesterdaySpends;
    }

    function getAdwordsConversionsLastMonth() {
        return $this->adwordsConversionsLastMonth;
    }

    function getAdwordsConversionsCurrentMonth() {
        return $this->adwordsConversionsCurrentMonth;
    }

    function getConversionsAtCurrentRate() {
        return $this->conversionsAtCurrentRate;
    }

    function getPercentOnLastMonthAtCurrentRate() {
        return $this->percentOnLastMonthAtCurrentRate;
    }

    function getPpcCpaLastMonth() {
        return $this->ppcCpaLastMonth;
    }

    function getPpcCpaCurrentMonth() {
        return $this->ppcCpaCurrentMonth;
    }

    function getChangeInCpa() {
        return $this->changeInCpa;
    }

    function getLastUpdated() {
        return $this->lastUpdated;
    }

    function getClientId() {
        return $this->clientId;
    }

    function setReportId($reportId) {
        $this->reportId = $reportId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setClientName($clientName) {
        $this->clientName = $clientName;
    }

    function setReportStatus($reportStatus) {
        $this->reportStatus = $reportStatus;
    }

    function setBudget($budget) {
        $this->budget = $budget;
    }

    function setPpcVisitorsLastMonth($ppcVisitorsLastMonth) {
        $this->ppcVisitorsLastMonth = $ppcVisitorsLastMonth;
    }

    function setPpcVisitorsCurrentMonth($ppcVisitorsCurrentMonth) {
        $this->ppcVisitorsCurrentMonth = $ppcVisitorsCurrentMonth;
    }

    function setPercentAtThisPointLastMonth($percentAtThisPointLastMonth) {
        $this->percentAtThisPointLastMonth = $percentAtThisPointLastMonth;
    }

    function setCpcLastMonth($cpcLastMonth) {
        $this->cpcLastMonth = $cpcLastMonth;
    }

    function setCpcCurrentMonth($cpcCurrentMonth) {
        $this->cpcCurrentMonth = $cpcCurrentMonth;
    }

    function setChangeInCpc($changeInCpc) {
        $this->changeInCpc = $changeInCpc;
    }

    function setPpcSpendLastMonth($ppcSpendLastMonth) {
        $this->ppcSpendLastMonth = $ppcSpendLastMonth;
    }

    function setPpcSpendCurrentMonth($ppcSpendCurrentMonth) {
        $this->ppcSpendCurrentMonth = $ppcSpendCurrentMonth;
    }

    function setRemainingBudget($remainingBudget) {
        $this->remainingBudget = $remainingBudget;
    }

    function setRemainingBudgetAtPpcSpend($remainingBudgetAtPpcSpend) {
        $this->remainingBudgetAtPpcSpend = $remainingBudgetAtPpcSpend;
    }

    function setDailyBudget($dailyBudget) {
        $this->dailyBudget = $dailyBudget;
    }

    function setAvgDailySpendsMtd($avgDailySpendsMtd) {
        $this->avgDailySpendsMtd = $avgDailySpendsMtd;
    }

    function setPlusOrMinusDailyBudgetAvailable($plusOrMinusDailyBudgetAvailable) {
        $this->plusOrMinusDailyBudgetAvailable = $plusOrMinusDailyBudgetAvailable;
    }

    function setYesterdaySpends($yesterdaySpends) {
        $this->yesterdaySpends = $yesterdaySpends;
    }

    function setAdwordsConversionsLastMonth($adwordsConversionsLastMonth) {
        $this->adwordsConversionsLastMonth = $adwordsConversionsLastMonth;
    }

    function setAdwordsConversionsCurrentMonth($adwordsConversionsCurrentMonth) {
        $this->adwordsConversionsCurrentMonth = $adwordsConversionsCurrentMonth;
    }

    function setConversionsAtCurrentRate($conversionsAtCurrentRate) {
        $this->conversionsAtCurrentRate = $conversionsAtCurrentRate;
    }

    function setPercentOnLastMonthAtCurrentRate($percentOnLastMonthAtCurrentRate) {
        $this->percentOnLastMonthAtCurrentRate = $percentOnLastMonthAtCurrentRate;
    }

    function setPpcCpaLastMonth($ppcCpaLastMonth) {
        $this->ppcCpaLastMonth = $ppcCpaLastMonth;
    }

    function setPpcCpaCurrentMonth($ppcCpaCurrentMonth) {
        $this->ppcCpaCurrentMonth = $ppcCpaCurrentMonth;
    }

    function setChangeInCpa($changeInCpa) {
        $this->changeInCpa = $changeInCpa;
    }

    function setLastUpdated($lastUpdated) {
        $this->lastUpdated = $lastUpdated;
    }

    function setClientId($clientId) {
        $this->clientId = $clientId;
    }
    function setCpaTarget($cpaTarget) {
        $this->cpaTarget = $cpaTarget;
    }
	function setBudgetCap($budgetCap) {
        $this->budgetCap = $budgetCap;
    }
    public function populateModel($mysqliObj){
        $this->adwordsConversionsCurrentMonth = $mysqliObj->adwords_conversions_current_month;
        $this->adwordsConversionsLastMonth = $mysqliObj->adwords_conversions_last_month;
        $this->avgDailySpendsMtd = $mysqliObj->avg_daily_spends_mtd;
        $this->budget = $mysqliObj->Budget;
        $this->changeInCpa = $mysqliObj->change_in_cpa;
        $this->changeInCpc = $mysqliObj->change_in_cpc;
        $this->clientId = $mysqliObj->client_id;
        $this->clientName = $mysqliObj->client_name;
        $this->conversionsAtCurrentRate = $mysqliObj->conversions_at_current_rate;
        $this->cpcCurrentMonth = $mysqliObj->cpc_current_month;
        $this->cpcLastMonth = $mysqliObj->cpc_last_month;
        $this->dailyBudget = $mysqliObj->daily_budget;
        $this->lastUpdated = $mysqliObj->last_updated;
        $this->percentAtThisPointLastMonth = $mysqliObj->percent_at_this_point_last_month;
        $this->percentOnLastMonthAtCurrentRate = $mysqliObj->percent_on_last_month_at_current_rate;
        $this->plusOrMinusDailyBudgetAvailable = $mysqliObj->plus_or_minus_daily_budget_available;
        $this->ppcCpaCurrentMonth = $mysqliObj->ppc_cpa_current_month;
        $this->ppcCpaLastMonth = $mysqliObj->ppc_cpa_last_month;
        $this->ppcSpendCurrentMonth = $mysqliObj->ppc_spend_current_month;
        $this->ppcSpendLastMonth = $mysqliObj->ppc_spend_last_month;
        $this->ppcVisitorsCurrentMonth = $mysqliObj->ppc_visitors_current_month;
        $this->ppcVisitorsLastMonth = $mysqliObj->ppc_visitors_last_month;
        $this->remainingBudget = $mysqliObj->remaining_budget;
        $this->remainingBudgetAtPpcSpend = $mysqliObj->remaining_budget_at_ppc_spend;
        $this->reportId = $mysqliObj->report_id;
        $this->reportStatus = $mysqliObj->report_status;
        $this->userId = $mysqliObj->user_id_fk;
        $this->userName = $mysqliObj->user_name;
        $this->yesterdaySpends = $mysqliObj->yesterday_spends;
        $this->cpaTrget = $mysqliObj->cpa_target;
        $this->budgetCap = $mysqliObj->budget_cap;
        return $this;
    }
    
}

