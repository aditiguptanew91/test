<?php

################################################################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 #
## --------------------------------------------------------------------------- #
##  ApPHP Calendar Free version 1.0.2                                          #
##  Developed by:  addigupta91@yahoo.co.in                                     #
##  Last modified: 08.12.2013                                                  #
##  License:       GNU LGPL v.3                                                #
##  Additional modules (embedded):                                             #
##  -- (Javascript - Draggable Elements)                                       #
##     Paranoid Ferret Productions              http://www.switchonthecode.com #
##  -- overLIB v4.21 (JS library)           http://www.bosrup.com/web/overlib/ #
##  -- Google AJAX Libraries API                  http://code.google.com/apis/ #
##  -- Crystal Project Icons (icons set)               http://www.everaldo.com #
##                                                                             #
################################################################################

$_SESSION['USERTYPE_ID'];
class Calendar{
	
	
	// PUBLIC						PRIVATE
	// --------                     ---------
	// __construct()				SetDefaultParameters
	// __destruct()                 GetCurrentParameters
	// Show()                       DrawCssStyle
	// SetCalendarDimensions        DrawJsFunctions
	// SetCaption                   IncludeModules
	// SetWeekStartedDay			InitializeJsFunctions
	// SetWeekDayNameLength         DrawMessages
	// ShowWeekNumberOfYear         DrawListView
	// SetTimeZone                  DrawYear
	// GetCurrentTimeZone           DrawMonth
	// SetDefaultView               DrawMonthSmall
	// SetEventsDisplayType         DrawWeek 
	// SetSundayColor               DrawDay
	// SetTimeFormat                DrawTypesChanger 
	// SetEventsOperations          DrawDateJumper
	// SetCategoriesOperations      DrawTodayJumper
	// SetCssStyle                  DrawEventsAddForm
	// SetAddEventFormType          DrawEventsEditForm
	// SetCachingParameters         DrawEventsDetailsForm
	// SetInterfaceLang             DrawEventsStatistics
	// SetUserID                    DrawAddEventForm
	// SetCalendarViews    			DrawMonthlyDayCell
	// SetAllowedHours              ParseHour
	// Debug                        ParseMinutes 
	// EditingEventsInPast          HandleEventsOperations
	// SetDisabledDay               DrawCategoriesAddForm
	// SaveHttpRequestVars          DrawCategoriesDetailsForm
	// SetSubmissionType            DrawCategoriesEditForm
	//                              DrawColors
	//                              DrawCategoriesDDL
	//                              DrawEventsDDL
	//                              GetMessage
	//
	// STATIC                       Auxilary (PRIVATE)
	// ----------                   --------
	// Version						SetLanguage
	// GetDefaultTimeZone			StartCaching
	// GetColorsByName				FinishCaching
	// GetColorNameByValue			GetEventsListForHour
	// 								GetEventsListForWeekDay
	// 								GetEventCountForDay
	// 								GetEventsCountForMonth
	// 								GetEventsListForMonth
	// 								GetMonthlyDayEvents
	// 								IsYear
	// 								IsMonth
	// 								IsDay	
	// 								ConvertToDecimal
	// 								GetFormattedMicrotime
	//                              PrepareOption
	//                              PrepareText
	//                              PrepareFormatedText
	//                              PrepareMinutesHoures
	

	//--- PUBLIC DATA MEMBERS --------------------------------------------------
	public $error;
	
	//--- PROTECTED DATA MEMBERS -----------------------------------------------
	protected $weekDayNameLength;
	
	//--- PRIVATE DATA MEMBERS -------------------------------------------------
	private  $arrWeekDays;
	private  $arrMonths;
	private  $arrViewTypes;
	private  $defaultView;
	private  $eventsDisplayType;
	private  $defaultAction;
	private  $showControlPanel;
	
	private  $arrParameters;
	private  $arrToday;
	private  $prevYear;
	private  $nextYear;
	private  $prevMonth;
	private  $nextMonth;
	private  $currWeek;
	private  $prevWeek;
	private  $nextWeek;
	private  $prevDay;
	private  $nextDay;
	
	private  $isDrawNavigation;
	private  $isWeekNumberOfYear;
	
	private  $crLt;	
	private  $caption;		
	private  $calWidth;		
	private  $calHeight;
	private  $celHeight;
	private  $weekColWidth;
	
	private  $timezone;
	private  $timeFormat;
	private  $timeFormatSQL;
	
	private  $langName;
	private  $lang;
	
	private  $arrEventsOperations;
	private  $submissionType;

	private  $isDemo;
	private  $isShowcase;
	private  $isDebug;
	private  $allowEditingEventsInPast;
	private  $arrMessages;
	private  $arrErrors;
    private  $startTime;
	private  $endTime;
	
	private  $addEventFormType;
	
	private  $isCachingAllowed;
	private  $cacheLifetime;
	private  $cacheDir;
	private  $maxCacheFiles;
	
	private  $userID;
	private  $calDir;

	private  $fromHour;
	private  $toHour;
	
	private  $httpRequestVars;
	
	private  $arrInitJsFunction;

	static private $version = "1.0.2";
	//--------------------------------------------------------------------------
    // CLASS CONSTRUCTOR
	//--------------------------------------------------------------------------
	function __construct()
	{
		if(defined("CALENDAR_DIR")) $this->calDir = CALENDAR_DIR;
		else $this->calDir = "";
		
		$this->defaultView   = "monthly";
		$this->defaultAction = "view";
		$this->showControlPanel = true;
		$this->eventsDisplayType = array("weekly"=>"inline", "monthly"=>"inline");
	
		// possible values 1,2,....7
		$this->weekStartedDay = 1;
		$this->weekDisabledDay = "";
		
		$this->weekDayNameLength = "short"; // short|long

		$this->langName = "en";
		
		$this->timezone = self::GetDefaultTimeZone();
		date_default_timezone_set($this->timezone); 		
		$this->timeFormat = "24";
		$this->timeFormatSQL = "%H:%i";
		$this->timeBlock = "60";

		$this->arrEventsOperations = array();
		$this->arrEventsOperations['add']     = true;
		$this->arrEventsOperations['edit']    = true;
		$this->arrEventsOperations['details'] = true;
		$this->arrEventsOperations['delete']  = true;
		$this->arrEventsOperations['manage'] = true;
		$this->arrEventsOperations['events_statistics'] = true;
		$this->arrEventsOperations['printing'] = true;
		
		$this->arrWeekDays  = array();
		$this->arrMonths    = array();

		$this->arrViewTypes = array();
		$this->arrViewTypes["daily"]     = array("name"=>"Daily", "enabled"=>true);
		$this->arrViewTypes["weekly"]    = array("name"=>"Weekly", "enabled"=>true);
		$this->arrViewTypes["monthly"]   = array("name"=>"Monthly", "enabled"=>true);
		$this->arrViewTypes["yearly"]  	 = array("name"=>"Yearly", "enabled"=>true);
		$this->arrViewTypes["list_view"] = array("name"=>"List View", "enabled"=>true);		
		
		$this->arrParameters = array();
		$this->SetDefaultParameters();

		$this->arrToday  = array();
		$this->prevYear  = array();
		$this->nextYear  = array();
		$this->prevMonth = array();
		$this->nextMonth = array();
		$this->currWeek  = array();
		$this->prevWeek  = array();
		$this->nextWeek  = array();
		$this->prevDay   = array();
		$this->nextDay   = array();
		
		$this->isDrawNavigation = true;
		$this->isWeekNumberOfYear = true;
		
		$this->crLt = "\n";
		$this->caption = "";
		$this->calWidth = "800px";
		$this->calHeight = "470px";
		$this->celHeight = number_format(((int)$this->calHeight)/6, "0")."px";
		$this->weekColWidth = number_format(((int)$this->calWidth)/8, "0")."px";
		
		$this->submissionType = "post";
		
		$this->cssStyle = "blue";
		
		$this->addEventFormType = "floating";
		
		$this->userID = $_SESSION['c_id']; //$id  $_SESSION['c_id']

		$this->isCachingAllowed = true;
		$this->cacheLifetime = 5; // in minutes
		$this->cacheDir = $this->calDir."cache/";
		$this->maxCacheFiles = 100;

		$this->isDemo = false;
		$this->isShowcase = false;	
		$this->isDebug = false;
		$this->allowEditingEventsInPast = true;
		$this->arrMessages = array();
		$this->arrErrors = array();
		$this->arrSQLs = array();
	
		$this->fromHour = 0;
		$this->toHour = 24;
		
		$this->httpRequestVars = array();
		
		$this->arrInitJsFunction = array();
	}
	
	//--------------------------------------------------------------------------
    // CLASS DESTRUCTOR
	//--------------------------------------------------------------------------
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	
	//==========================================================================
    // PUBLIC DATA FUNCTIONS
	//==========================================================================			
	/**
	 *	Show Calendar 
	 *
	*/	
	function Show()
	{
        // start calculating running time of the script
        $this->startTime = 0;
        $this->endTime = 0;
        if($this->isDebug){
			error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
            $this->startTime = $this->GetFormattedMicrotime();
        }        

		$this->SetLanguage();
				
		//ob_start();
        $event_action = $this->GetParameter('hid_event_action');
        $event_id     = $this->GetParameter('hid_event_id');
		//$company_id     = $this->GetParameter('hid_company_id');
		$category_id  = $this->GetParameter('hid_category_id');
		$jump_year 	  = $this->GetParameter('jump_year'); 
		$jump_month	  = $this->GetParameter('jump_month'); 
		$jump_day 	  = $this->GetParameter('jump_day'); 
        $view_type 	  = $this->GetParameter('view_type');
        
		if($this->isDemo && !$this->isShowcase){
			$lang_id 	= isset($_REQUEST['lang_id']) ? $_REQUEST['lang_id'] : "en";
			$css_style 	= isset($_REQUEST['css_style']) ? $_REQUEST['css_style'] : "blue";			
		}
		
		$this->HandleEventsOperations();
		$this->GetCurrentParameters();
		$this->DrawCssStyle();
		$this->DrawJsFunctions();
		$this->IncludeModules();

		// prepare stored http request variables
		$http_query_string = "";
        foreach($this->httpRequestVars as $key){
			if(isset($_REQUEST[$key])){
				$http_query_string .= ((!$http_query_string) ? "?" : "&").$key."=".$_REQUEST[$key];	
			}
		}
		echo "<form name='frmCalendar' id='frmCalendar' action='".$this->arrParameters["current_file"].$http_query_string."' method='".$this->submissionType."' style='display:block; margin:0 auto;'>".$this->crLt;
		echo "<input type='hidden' id='hid_event_action' name='hid_event_action' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_event_id' name='hid_event_id' value='' />".$this->crLt;
	    echo "<input type='hidden' id='hid_action' name='hid_action' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_view_type' name='hid_view_type' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_year' name='hid_year' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_month' name='hid_month' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_day' name='hid_day' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_previous_action' name='hid_previous_action' value='".$event_action."' />".$this->crLt;
		echo "<input type='hidden' id='hid_page' name='hid_page' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_chart_type' name='hid_chart_type' value='' />".$this->crLt;
		echo "<input type='hidden' id='hid_category_id' name='hid_category_id' value='' />".$this->crLt;
		//echo "<input type='hidden' id='hid_company_id' name='hid_company_id' value='' />".$this->crLt;
		
		if($event_action == "events_add" || $event_action == "events_edit" || $event_action == "events_details" || $event_action == "events_delete" || $event_action == "events_update" || $event_action == "events_management" ||
			$event_action == "categories_add" || $event_action == "categories_update" || $event_action == "categories_details" || $event_action == "categories_delete" || $event_action == "categories_edit" || $event_action == "categories_management")
		{
			echo "<input type='hidden' id='view_type' name='view_type' value='".$view_type."' />".$this->crLt;
			echo "<input type='hidden' id='jump_year' name='jump_year' value='".$jump_year."' />".$this->crLt;
			echo "<input type='hidden' id='jump_month' name='jump_month' value='".$jump_month."' />".$this->crLt;
			echo "<input type='hidden' id='jump_day' name='jump_day' value='".$jump_day."' />".$this->crLt;			
		}
		
		echo "<div id='calendar' style='width:".$this->calWidth.";'>".$this->crLt;		
		
		// draw calendar header
		echo "<table border='0' id='calendar_header'>".$this->crLt;
		echo "<tr>";
		echo "<th class='caption_left'>".$this->DrawTodayJumper(false)."</th>";
		echo "<th class='caption'>".$this->caption."</th>";
		echo "<th class='types_changer'>";
		if($this->isDemo && !$this->isShowcase){
			echo "<select style='width:105px' name='lang_id' id='lang_id' onchange=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">
				  <option value='en' ".(($lang_id == "en") ? "selected" : "").">English</option>
				  <option value='en' ".(($lang_id == "es") ? "selected" : "")." disabled='disabled'>Spanish(blocked)</option>
				  <option value='en' ".(($lang_id == "es") ? "selected" : "")." disabled='disabled'>German(blocked)</option> 
				  </select>&nbsp;";
			echo "<select name='css_style' id='css_style' onchange=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">
				  <option value='blue' ".(($css_style == "blue") ? "selected" : "").">Blue</option>
				  <option value='green' ".(($css_style == "green") ? "selected" : "").">Green</option>
				  <option value='brown' ".(($css_style == "brown") ? "selected" : "").">Brown</option> 
				  </select>&nbsp;";			
		}
		echo $this->DrawTypesChanger(false)."</th>";
		echo "</tr>".$this->crLt;

		if($this->showControlPanel){
			echo "<tr>";			
			echo "<th class='caption_left' colspan='2' valign='bottom'>
				    <table align='left' cellpadding='0' cellspacing='1'><tr>";					
				if($this->arrEventsOperations['manage']){
					echo "<td><img src='".$this->calDir."style/".$this->cssStyle."/images/manage_events.png' border='0' /></td>";
					echo "<td>&nbsp;<a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_management')\"><strong>".$this->lang['events']."</strong></a></td>";
					if($this->arrEventsOperations['events_statistics']) echo "<td>&nbsp;|&nbsp;</td>";
				}
				if($this->arrCatOperations['manage']){
					echo "<td><img src='".$this->calDir."style/".$this->cssStyle."/images/manage_categories.png' border='0' /></td>";
					echo "<td>&nbsp;<a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'categories_management')\"><strong>".$this->lang['categories']."</strong></a></td>";
					if($this->arrEventsOperations['events_statistics']) echo "<td>&nbsp;|&nbsp;</td>";
				}
				if($this->arrEventsOperations['events_statistics']){
					echo "<td><img src='".$this->calDir."style/".$this->cssStyle."/images/events_statistics.png' border='0' /></td>";
					echo "<td>&nbsp;<a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_statistics')\"><strong>".$this->lang['statistics']."</strong></a></td>";
				}
			echo "  </tr></table></th>";
			echo "<th class='caption_right' valign='bottom'>";
				if($this->arrEventsOperations['printing']){
					echo "<a class='print' href='javascript:window.print()' title='".$this->lang['click_to_print']."'><img src='".$this->calDir."style/".$this->cssStyle."/images/print.png' border='0' />".$this->lang['print']."</a>";
				}
			echo "</th>";
			echo "</tr>".$this->crLt;			
		}		
		echo $this->DrawMessages(false);		
		echo "</table>";
		
		switch($event_action)
		{
			// Events actions
			case "events_add":
				if($this->arrEventsOperations['add']) $this->DrawEventsAddForm();
				else echo "<span class='msg_error'>".$this->lang['msg_this_operation_blocked']."</span>";
				break;			
			case "events_edit":
				if($this->arrEventsOperations['edit']) $this->DrawEventsEditForm($event_id);
				else echo "<span class='msg_error'>".$this->lang['msg_this_operation_blocked']."</span>";
				break;			
			case "events_details":
				if($this->arrEventsOperations['details']) $this->DrawEventsDetailsForm($event_id);
				else echo "<span class='msg_error'>".$this->lang['msg_this_operation_blocked']."</span>";								
				break;			
			case "events_management":
			case "events_delete":
			case "events_update":
			case "events_insert":
				if($this->arrEventsOperations['manage']) $this->DrawEventsManagement();
				break;

            // Categories actions
			case "categories_add":
				if($this->arrCatOperations['add']) $this->DrawCategoriesAddForm();
				break;						
			case "categories_edit":
				if($this->arrCatOperations['manage']) $this->DrawCategoriesEditForm($category_id);
				break;			
			case "categories_details":
				if($this->arrCatOperations['manage']) $this->DrawCategoriesDetailsForm($category_id);
				break;			
			case "categories_management":
			case "categories_delete":
			case "categories_update":
			case "categories_insert":
				if($this->arrCatOperations['manage']) $this->DrawEventsCategoriesManagement();
				break;

			// Events statistics
			case "events_statistics":
				if($this->arrEventsOperations['details']) $this->DrawEventsStatistics();
				else echo "<span class='msg_error'>".$this->lang['msg_this_operation_blocked']."</span>";
				break;
			
			default:
				switch($this->arrParameters["view_type"])
				{			
					case "daily":
						$this->DrawDay();
						break;
					case "weekly":
						$this->DrawWeek();
						break;
					case "yearly":
						$this->DrawYear();
						break;			
					case "list_view":
						$this->DrawListView();
						break;			
					default:
					case "monthly":				
						$this->DrawMonth();
						break;
				}			
				break;
		}						
		
		echo "</div>".$this->crLt;
		echo "</form>".$this->crLt;
		$this->InitializeJsFunctions();
		
		if($this->isDebug){
			$this->endTime = $this->GetFormattedMicrotime();

			echo "<div class='debug_info' style='width:".$this->calWidth.";'>";
			echo "<b>".$this->lang['debug_info']."</b>: (".$this->lang['total_running_time'].": ".round((float)$this->endTime - (float)$this->startTime, 6)." sec.) <br />=========<br /><br />";
			echo "<b>ERRORS: (".count($this->arrErrors).")</b> <br />--------<br />";
			echo "<p class='debug_error'>".$this->DrawErrors(false)."</p>";
			echo "<b>SQL:</b> <br />--------<br />";
			echo "<p class='debug_sql'>".$this->DrawSQLs(false)."</p>";
			echo "<b>GET:</b> <br />--------<br />";
			echo "<pre class='debug_get'>";
			print_r($_GET);
			echo "</pre><br />";
			echo "<b>POST:</b> <br />--------<br />";
			echo "<pre class='debug_post'>";
			print_r($_POST);
			echo "</pre><br />";
			echo "</div>";
		}		
		
        echo $this->crLt.$this->crLt;
		
		//ob_end_flush();		
	}	
	
	/**
	 *	Set calendar dimensions
	 *  	@param $width
	 *  	@param $height
	*/	
	function SetCalendarDimensions($width = "", $height = "")
	{
		$this->calWidth = ($width != "") ? $width : "800px";
		$this->calHeight = ($height != "") ? $height : "470px";
		$this->celHeight = number_format(((int)$this->calHeight)/6, "0")."px";
	}

	/**
	 *	Check if parameters is 4-digit year
	 *  	@param $year - string to be checked if it's 4-digit year
	*/	
	function SetCaption($caption_text = "")
	{
		$this->caption = $caption_text;	
	}
	
	/**
	 *	Set week started day
	 *  	@param $started_day - started day of week 1...7
	*/	
	function SetWeekStartedDay($started_day = "1")
	{
		if(is_numeric($started_day) && (int)$started_day >= 1 && (int)$started_day <= 7){
			$this->weekStartedDay = (int)$started_day;				
		}
	}

	/**
	 *	Set week disabled day
	 *  	@param $disabled_day - disabledday of week 1...7
	*/	
	function SetDisabledDay($disabled_day = "1")
	{
		if(is_numeric($disabled_day) && (int)$disabled_day >= 1 && (int)$disabled_day <= 7){
			$this->weekDisabledDay = (int)$disabled_day;				
		}
	}

	/**
	 *	Set week day name length 
	 *  	@param $length_name - "short"|"long"
	*/	
	function SetWeekDayNameLength($length_name = "short")
	{
		if(strtolower($length_name) == "long"){
			$this->weekDayNameLength = "long";
		}
	}
	
	/**
	 *	Show week number of year
	 *  	@param $show - true|false
	*/	
	function ShowWeekNumberOfYear($show = true)
	{
		if($show == true || strtolower($show) === "true"){
			$this->isWeekNumberOfYear = true;
		}else{
			$this->isWeekNumberOfYear = false;
		}
	}
	
	/**
	 *	Set timezone
	 *		@param $timezone
	*/	
	function SetTimeZone($timezone = "")
	{
		if($timezone != ""){
			if($this->isDebug){
				if(!in_array($timezone, timezone_identifiers_list())){
					$this->arrErrors[] = str_replace("_TIME_ZONE_", $timezone, $this->lang['msg_timezone_invalid'])."<br />";	
				}
			}
			$this->timezone = $timezone;
			@date_default_timezone_set($this->timezone); 
		}
	}

	/**
	 *	Get current timezone 
	*/	
	function GetCurrentTimeZone()
	{
		return $this->timezone;
	}
	
	/**
	 *	Set displaying type of events
	 *		@param $events_display_type - array
	*/	
	function SetEventsDisplayType($events_display_type = array())
	{
		$this->eventsDisplayType['weekly'] = isset($events_display_type['weekly']) ? $events_display_type['weekly'] : "inline";
		$this->eventsDisplayType['monthly'] = isset($events_display_type['monthly']) ? $events_display_type['monthly'] : "inline";
	}

	/**
	 *	Set calendar Views
	 *		@param $views - array
	*/	
	function SetCalendarViews($views = array())
	{
		$this->arrViewTypes["daily"]["enabled"]     = (isset($views["daily"]) && ($views["daily"] === true || strtolower($views["daily"]) == "true")) ? true : false;
		$this->arrViewTypes["weekly"]["enabled"]    = (isset($views["weekly"]) && ($views["weekly"] === true || strtolower($views["weekly"]) == "true")) ? true : false;
		$this->arrViewTypes["monthly"]["enabled"]   = (isset($views["monthly"]) && ($views["monthly"] === true || strtolower($views["monthly"]) == "true")) ? true : false;
		$this->arrViewTypes["yearly"]["enabled"]    = (isset($views["yearly"]) && ($views["yearly"] === true || strtolower($views["yearly"]) == "true")) ? true : false;
		$this->arrViewTypes["list_view"]["enabled"] = (isset($views["list_view"]) && ($views["list_view"] === true || strtolower($views["list_view"]) == "true")) ? true : false;
		
		if(!$this->arrViewTypes[$this->defaultView]['enabled']){
			foreach($this->arrViewTypes as $key => $val){
				if($val['enabled']){					
					$this->defaultView = $key;
					$this->arrErrors[] = str_replace("_DEFAULT_VIEW_", $this->defaultView, $this->lang['msg_view_type_invalid'])."<br />";	
					break;
				}
			}
		}
	}
	
	/**
	 *	Set allowed hours
	 *		@param $hour_from - started hour
	 *		@param $hour_to - ended hour
	*/	
	function SetAllowedHours($from_hour, $to_hour)
	{
		$this->fromHour = (!is_numeric($from_hour) || $from_hour < 0) ? 0 : (int)$from_hour;
		$this->toHour = (!is_numeric($to_hour) || $to_hour > 24) ? 24 : (int)$to_hour;
		if(($this->fromHour > $this->toHour) && $this->isDebug){
			$this->arrErrors[] = $this->lang['error_from_to_hour']."<br />";
		}
	}
	

	/**
	 *	Set default calendar view
	 *		@param $default_view
	*/	
	function SetDefaultView($default_view = "monthly")
	{
		if(isset($this->arrViewTypes[$default_view]["enabled"]) && $this->arrViewTypes[$default_view]["enabled"] == true){
			$this->defaultView = $default_view;
		}
	}
	
	/**
	 *	Set Sunday color
	 *		@param $default_view
	*/	
	function SetSundayColor($color = false)
	{
		$this->sundayColor = ($color == true || $color === "true") ? true : false;
	}
	
	/**
	 *	Set time format
	 *		@param $time_format
	*/	
	function SetTimeFormat($time_format = "24")
	{
		$this->timeFormat = (strtoupper($time_format) == "AM/PM") ? "AP/PM" : "24";
		if($this->timeFormat == "24"){
			$this->timeFormatSQL = "%H:%i";
		}else{
			$this->timeFormatSQL = "%h:%i %p";
		}
	}	

	/**
	 *	Set time block
	 *		@param $time_format
	*/	
	function SetTimeBlock($time_block = "60")
	{
		$time_block = (int)$time_block;
		if($time_block == "15"){
			$this->timeBlock = "15";	
		}else if($time_block == "30"){
			$this->timeBlock = "30";	
		}else{
			$this->timeBlock = "60";	
		}		
	}	

	/**
	 *	Set (allow) calendar categories operations
	 *		@param $operations
	*/	
	function SetCategoriesOperations($operations = array())
	{
		$this->arrCatOperations['add']     = (isset($operations['add']) && ($operations['add'] === true || strtolower($operations['add']) == "true")) ? true : false;
		$this->arrCatOperations['edit']    = (isset($operations['edit']) && ($operations['edit'] === true || strtolower($operations['edit']) == "true")) ? true : false;
		$this->arrCatOperations['details'] = (isset($operations['details']) && ($operations['details'] === true || strtolower($operations['details']) == "true")) ? true : false;
		$this->arrCatOperations['delete']  = (isset($operations['delete']) && ($operations['delete'] === true || strtolower($operations['delete']) == "true")) ? true : false;
		$this->arrCatOperations['manage']  = (isset($operations['manage']) && ($operations['manage'] === true || strtolower($operations['manage']) == "true")) ? true : false;
		$this->arrCatOperations['allow_colors'] = (isset($operations['allow_colors']) && ($operations['allow_colors'] === true || strtolower($operations['allow_colors']) == "true")) ? true : false;
	}

	/**
	 *	Set (allow) calendar events operations
	 *		@param $operations
	*/	
	function SetEventsOperations($operations = array())
	{
		$this->arrEventsOperations['add']      = (isset($operations['add']) && ($operations['add'] === true || strtolower($operations['add']) == "true")) ? true : false;
		$this->arrEventsOperations['edit']     = (isset($operations['edit']) && ($operations['edit'] === true || strtolower($operations['edit']) == "true")) ? true : false;
		$this->arrEventsOperations['details']  = (isset($operations['details']) && ($operations['details'] === true || strtolower($operations['details']) == "true")) ? true : false;
		$this->arrEventsOperations['delete']   = (isset($operations['delete']) && ($operations['delete'] === true || strtolower($operations['delete']) == "true")) ? true : false;
		$this->arrEventsOperations['manage']   = (isset($operations['manage']) && ($operations['manage'] === true || strtolower($operations['manage']) == "true")) ? true : false;
		$this->arrEventsOperations['events_statistics'] = (isset($operations['events_statistics']) && ($operations['events_statistics'] === true || strtolower($operations['events_statistics']) == "true")) ? true : false;
		$this->arrEventsOperations['printing'] = (isset($operations['printing']) && ($operations['printing'] === true || strtolower($operations['printing']) == "true")) ? true : false;
	}

	/**
	 *	Set form submission type
	 *		@param $submission_type
	*/	
	function SetSubmissionType($submission_type = "post")
	{
		if(strtolower($submission_type) == "get") $this->submissionType = "get";
		else $this->submissionType = "post";
	}

	/**
	 *	Set CSS style
	 *		@param $style
	*/	
	function SetCssStyle($style = "blue")
	{		
		if(strtolower($style) == "green") $this->cssStyle = "green";
		else if(strtolower($style) == "brown") $this->cssStyle = "brown";
		else $this->cssStyle = "blue";
	}
	
	/**
	 *	Set Add Event form type
	 *		@param $type
	*/	
	function SetAddEventFormType($type = "blue")
	{		
		if(strtolower($type) == "floating") $this->addEventFormType = "floating";
		else $this->addEventFormType = "popup";
	}
	
	/**
	 *	Set Caching Parameters
	 *		@param $allowed
	 *		@param $lifetime
	*/	
	function SetCachingParameters($allowed, $lifetime = "5")
	{		
		if(strtolower($allowed) === "true" || $allowed == true) $this->isCachingAllowed = true;
		else $this->isCachingAllowed = false;
		// timeout in minutes
		if(is_numeric($lifetime) && $lifetime < 24*60){			
			$this->cacheLifetime = $lifetime;
		}else{
			$this->cacheLifetime = 5; 
		}
	}	
	
	/**
	 *	Set interface language 
	 *		@param $lang
	*/	
	function SetInterfaceLang($lang = "en")
	{
		if($lang != "") $this->langName = $lang;
		$this->SetLanguage();		
	}
	
	/**
	 *	Set user ID
	 *		@param $user_id
	*/	
	function SetUserID($user_id = "0")
	{
		if($user_id != "" and is_numeric($user_id)) $this->userID = (int)$user_id;
	}
	

	/**
	 *	Set debug mode
	 *		@param $mode
	*/	
	function Debug($mode = false)
	{
		if($mode == true || strtolower($mode) === "true") $this->isDebug = true;
	}
	
	/**
	 *	Set allow editing events in past
	 *		@param $mode
	*/	
	function EditingEventsInPast($mode = false)
	{
		if($mode == false || strtolower($mode) === "false") $this->allowEditingEventsInPast = false;
	}
	
	
	//==========================================================================
    // STATIC
	//==========================================================================		
	/**
	 *	Return current version
	*/	
	static function Version()
	{
		return self::$version;
	}
	
	/**
	 *	Return default time zone
	*/	
	static function GetDefaultTimeZone()
	{
		return @date_default_timezone_get();  
	}

	
	//==========================================================================
    // PRIVATE DATA FUNCTIONS
	//==========================================================================		
	/**
	 *	Set default parameters
	 *
	*/	
	function SetDefaultParameters()
	{
		$this->arrParameters["year"]  = date("Y");
		$this->arrParameters["month"] = date("m");
		$this->arrParameters["month_full_name"] = date("F");
		//$t=date('d-m-Y');
		//echo date("d",strtotime($t));
		$this->arrParameters["day"]   = date("d");
		$this->arrParameters["view_type"] = $this->defaultView;
		$this->arrParameters["action"] = "display";
		$this->arrParameters["page"] = "1";
		$this->arrParameters["chart_type"] = "columnchart";
		$this->arrParameters["event_action"] = "";
		$this->arrToday = getdate();

		// get current file
		$this->arrParameters["current_file"] = $_SERVER["SCRIPT_NAME"];
		$parts = explode('/', $this->arrParameters["current_file"]);
		$this->arrParameters["current_file"] = $parts[count($parts) - 1];		
	}

	/**
	 *	Get current parameters - read them from URL
	 *
	*/	
	function GetCurrentParameters()
	{		
		$year 		= (isset($_REQUEST['hid_year']) && $this->IsYear($_REQUEST['hid_year'])) ? $_REQUEST['hid_year'] : date("Y");
		$month 		= (isset($_REQUEST['hid_month']) && $this->IsMonth($_REQUEST['hid_month'])) ? $_REQUEST['hid_month'] : date("m");
		$day 		= (isset($_REQUEST['hid_day']) && $this->IsDay($_REQUEST['hid_day'])) ? $_REQUEST['hid_day'] : date("d");
		$view_type 	= (isset($_REQUEST['hid_view_type']) && array_key_exists($_REQUEST['hid_view_type'], $this->arrViewTypes)) ? $_REQUEST['hid_view_type'] : $this->defaultView;
        $previous_action = (isset($_REQUEST['hid_previous_action']) ? $this->RemoveBadChars($_REQUEST['hid_previous_action']) : '');
		$page 	    	 = isset($_REQUEST['hid_page']) ? (int)$_REQUEST['hid_page'] : 1;
        $chart_type 	 = $this->GetParameter('hid_chart_type', 'columnchart'); 
		$event_action 	 = isset($_REQUEST['hid_event_action']) ? $_REQUEST['hid_event_action'] : "";

		$cur_date = getdate(mktime(0,0,0,$month,$day,$year));
		
		$this->arrParameters["year"]  = $cur_date['year'];
		$this->arrParameters["month"] = $this->ConvertToDecimal($cur_date['mon']);
		$this->arrParameters["month_full_name"] = $this->lang['months'][$cur_date['mon']]; //$cur_date['month'];
		$this->arrParameters["day"]   	  = $day;
		$this->arrParameters["wday"]      = $cur_date['wday'];
		$this->arrParameters["weekday"]   = $this->lang[strtolower($cur_date['weekday'])];
		$this->arrParameters["view_type"] = $view_type;
		$this->arrParameters["action"] = "view";
		$this->arrParameters["previous_action"] = $previous_action;
		$this->arrParameters["page"] = $page;
		$this->arrParameters["chart_type"] = $chart_type;
		$this->arrParameters["event_action"] = $event_action;

		// find starting day for current day
		if($view_type == "weekly"){
			$sign = 1;
			for($i=0; $i<7; $i++){
				$week_day = date("w", mktime(0,0,0,$this->arrParameters["month"],$this->arrParameters["day"]+($sign*$i)-($this->weekStartedDay-1),$this->arrParameters["year"]));
				if(($i == 0) && ($week_day != "0")) $sign = -1;
				if($week_day == "0"){
					$parts = explode("-", date("d-n-Y", mktime(0,0,0,$this->arrParameters["month"],$this->arrParameters["day"]+($sign*$i),$this->arrParameters["year"])));
					$this->currWeek["year"]  = $parts[2];
					$this->currWeek["month"] = $this->ConvertToDecimal($parts[1]);
					$this->currWeek["month_full_name"] = $this->lang['months'][$parts[1]]; 
					$this->currWeek["day"]   = $parts[0];					
					break;
				}					
			}				
		}else{
			$this->currWeek["year"]  = $this->arrParameters["year"];
			$this->currWeek["month"] = $this->arrParameters["month"];
			$this->currWeek["month_full_name"] = $this->arrParameters["month_full_name"]; 
			$this->currWeek["day"]   = $this->arrParameters["day"];
		}
		
		$this->arrToday = getdate();		

		$this->prevYear = getdate(mktime(0,0,0,$this->arrParameters['month'],$this->arrParameters["day"],$this->arrParameters['year']-1));
		$this->prevYear['month'] = $this->lang['months'][$this->prevYear['mon']];
		$this->prevYear['weekday'] = $this->lang[strtolower($this->prevYear['weekday'])];
		$this->nextYear = getdate(mktime(0,0,0,$this->arrParameters['month'],$this->arrParameters["day"],$this->arrParameters['year']+1));
		$this->nextYear['month'] = $this->lang['months'][$this->nextYear['mon']];
		$this->nextYear['weekday'] = $this->lang[strtolower($this->nextYear['weekday'])];

		$this->prevMonth = getdate(mktime(0,0,0,$this->arrParameters['month']-1,$this->GetDayForMonth($this->arrParameters['month']-1,$this->arrParameters["day"]),$this->arrParameters['year']));
		$this->prevMonth['month'] = $this->lang['months'][$this->prevMonth['mon']];
		$this->prevMonth['weekday'] = $this->lang[strtolower($this->prevMonth['weekday'])];
		$this->nextMonth = getdate(mktime(0,0,0,$this->arrParameters['month']+1,$this->GetDayForMonth($this->arrParameters['month']+1,$this->arrParameters["day"]),$this->arrParameters['year']));
		$this->nextMonth['month'] = $this->lang['months'][$this->nextMonth['mon']];
		$this->nextMonth['weekday'] = $this->lang[strtolower($this->nextMonth['weekday'])];

		$this->prevWeek = getdate(mktime(0,0,0,$this->currWeek['month'],$this->currWeek["day"]-7,$this->currWeek['year']));
		$this->prevWeek['month'] = $this->lang['months'][$this->prevWeek['mon']];
		$this->prevWeek['weekday'] = $this->lang[strtolower($this->prevWeek['weekday'])];
		$this->nextWeek = getdate(mktime(0,0,0,$this->currWeek['month'],$this->currWeek["day"]+7,$this->currWeek['year']));
		$this->nextWeek['month'] = $this->lang['months'][$this->nextWeek['mon']];
		$this->nextWeek['weekday'] = $this->lang[strtolower($this->nextWeek['weekday'])];

        $this->prevDay = getdate(mktime(0,0,0,$this->arrParameters['month'],$this->arrParameters["day"]-1,$this->arrParameters['year']));
		$this->prevDay['month'] = $this->lang['months'][$this->prevDay['mon']];
		$this->prevDay['weekday'] = $this->lang[strtolower($this->prevDay['weekday'])];
		$this->nextDay = getdate(mktime(0,0,0,$this->arrParameters['month'],$this->arrParameters["day"]+1,$this->arrParameters['year']));
		$this->nextDay['month'] = $this->lang['months'][$this->nextDay['mon']];
		$this->nextDay['weekday'] = $this->lang[strtolower($this->nextDay['weekday'])];
	}

	/**
	 *	Handle events - proccess events: insert, edit or delete
	 *
	*/	
	private function HandleEventsOperations()
	{
		$event_action 		= isset($_REQUEST['hid_event_action']) ? $_REQUEST['hid_event_action'] : "";
		$event_id 		    = isset($_REQUEST['hid_event_id']) ? $_REQUEST['hid_event_id'] : "";
		$company_id          = isset($_REQUEST['hid_company_id']) ? $_REQUEST['hid_company_id'] : "";
		
		$sel_event 			= isset($_REQUEST['sel_event']) ? $_REQUEST['sel_event'] : "";
		$event_name 		= isset($_REQUEST['event_name']) ? $_REQUEST['event_name'] : "";
		$sel_event_name		= isset($_REQUEST['sel_event_name']) ? $_REQUEST['sel_event_name'] : "";
		$event_description 	= isset($_REQUEST['event_description']) ? $_REQUEST['event_description'] : "";
		$event_insertion_type = isset($_REQUEST['event_insertion_type']) ? $_REQUEST['event_insertion_type'] : "";
		$sel_category_id	= isset($_REQUEST['sel_category_name']) ? $_REQUEST['sel_category_name'] : "";

		$event_from_hour 	= isset($_REQUEST['event_from_hour']) ? $_REQUEST['event_from_hour'] : "";
		$event_from_day 	= isset($_REQUEST['event_from_day']) ? $_REQUEST['event_from_day'] : "";
		$event_from_month 	= isset($_REQUEST['event_from_month']) ? $_REQUEST['event_from_month'] : "";
		$event_from_year 	= isset($_REQUEST['event_from_year']) ? $_REQUEST['event_from_year'] : "";
		$start_date         = $event_from_year."-".$event_from_month."-".$event_from_day." ".$event_from_hour;
		
		$event_to_hour 		= isset($_REQUEST['event_to_hour']) ? $_REQUEST['event_to_hour'] : "";
		$event_to_day 		= isset($_REQUEST['event_to_day']) ? $_REQUEST['event_to_day'] : "";
		$event_to_month 	= isset($_REQUEST['event_to_month']) ? $_REQUEST['event_to_month'] : "";
		$event_to_year 		= isset($_REQUEST['event_to_year']) ? $_REQUEST['event_to_year'] : "";
		$finish_date        = $event_to_year."-".$event_to_month."-".$event_to_day." ".$event_to_hour;
		
		$category_id        = isset($_REQUEST['hid_category_id']) ? $_REQUEST['hid_category_id'] : "";
		$category_name 		= isset($_REQUEST['category_name']) ? $_REQUEST['category_name'] : "";
		$category_description = isset($_REQUEST['category_description']) ? $_REQUEST['category_description'] : "";
		$category_color     = isset($_REQUEST['category_color']) ? $_REQUEST['category_color'] : "";
		//$company_id		 = $_SESSION['c_id'];
		
		$sql			    = "";

		if($this->isDemo && $event_action != "" &&
			(
				$event_action != "events_statistics" &&
				$event_action != "events_management" &&
				$event_action != "events_add" &&
				$event_action != "events_edit" &&
				$event_action != "categories_management" &&
				$event_action != "categories_add" &&
				$event_action != "categories_edit"
			)
		){ 
			$this->arrMessages[] = $this->GetMessage("error", $this->lang['msg_this_operation_blocked_demo']);
			return false;
		}
			
		if($event_action == "add"){
			// insert single event
			$insert_id = false;
			if($sel_event == "new"){
				$sql = "SELECT COUNT(*) as cnt FROM ".DB_PREFIX."events WHERE name = '".$this->PrepareText($event_name)."' AND company_id = '".$_SESSION['c_id']."'";
				$event_exists = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
				if($event_exists['cnt'] > 0){
					$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_event_exists']);
					return false;
				}else{ // AND company_id = '".$_SESSION['c_id']."'
					$sql = "INSERT INTO ".DB_PREFIX."events (id, name, description, category_id, company_id, usertype_id, user_id) VALUES (NULL, '".$this->PrepareText($event_name)."', '".$this->PrepareText($event_description)."', '".(int)$sel_category_id."','".$_SESSION['c_id']."','".$_SESSION['USERTYPE_ID']."','".$_SESSION['c_id']."')";
					$insert_id = database_void_query($sql);	
				}				
			}else if($sel_event == "current"){
				$insert_id = $sel_event_name;
			}
			if($insert_id != false){
				$result = $this->InsertEventsOccurrences($insert_id, $start_date, $finish_date, $event_from_hour, $event_from_day, $event_from_month, $event_from_year);
				if($result) $this->arrMessages[] = $this->GetMessage("success", $this->lang['success_new_event_was_added']);
			}else{
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_inserting_new_events']);
			}
		}else if($event_action == "delete"){
			// delete single event
			$sql = "SELECT ".DB_PREFIX."events.name
					FROM ".DB_PREFIX."calendar
						INNER JOIN ".DB_PREFIX."events ON ".DB_PREFIX."calendar.event_id = (".DB_PREFIX."events.id 
						AND ".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."')
					WHERE (".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."' )  AND ".DB_PREFIX."calendar.id = ".(int)$event_id;
			$event_name = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			$sql = "DELETE FROM ".DB_PREFIX."calendar WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$event_id;			
			if(!database_void_query($sql)){
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_deleting_event']);
			}else{
				$this->arrMessages[] = $this->GetMessage("success", str_replace("_EVENT_NAME_", $event_name['name'], $this->lang['success_event_was_deleted']));
				$this->DeleteCache();
			}
		}else if($event_action == "events_insert"){
			// insert new event
			$sql = "SELECT COUNT(*) as cnt FROM ".DB_PREFIX."events WHERE company_id = '".$_SESSION['c_id']."' AND name = '".$this->PrepareText($event_name)."'";
			$event_exists = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			if($event_exists['cnt'] > 0){
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_event_exists']);
			}else{ 
				$sql = "INSERT INTO ".DB_PREFIX."events (id, name, description, category_id,company_id,user_id,usertype_id) VALUES (NULL, '".$this->PrepareText($event_name)."', '".$this->PrepareText($event_description)."', '".(int)$sel_category_id."','".$_SESSION['c_id']."','".$_SESSION['c_id']."','".$_SESSION['USERTYPE_ID']."')";
				$insert_id = database_void_query($sql);	
				if($insert_id != false){
					// if add event occurrences selected
					$result = true;
					if($event_insertion_type == 2) $result = $this->InsertEventsOccurrences($insert_id, $start_date, $finish_date, $event_from_hour, $event_from_day, $event_from_month, $event_from_year, false);
					$this->arrMessages[] = $this->GetMessage("success", $this->lang['success_new_event_was_added']);
				}else{
					$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_inserting_new_events']);
				}				
			}			
		}else if($event_action == "events_update"){
			// update events 
			$sql = "UPDATE ".DB_PREFIX."events SET name='".$this->PrepareText($event_name)."', description='".$this->PrepareText($event_description)."', category_id = '".(int)$sel_category_id."' WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$event_id;
			if(database_void_query($sql)){
				$this->arrMessages[] = $this->GetMessage("success", $this->lang['success_event_was_updated']);
			}else{
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_updating_event']);
			}			
		}else if($event_action == "events_delete"){
			// delete event from Events table //AND company_id = '".$_SESSION['c_id']."'
			$sql = "SELECT name FROM ".DB_PREFIX."events WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$event_id;
			$event_name = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			if(isset($event_name['name'])){				
				$sql_1 = "DELETE FROM ".DB_PREFIX."events WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$event_id;			
				$sql_2 = "DELETE FROM ".DB_PREFIX."calendar WHERE company_id = '".$_SESSION['c_id']."' AND event_id = ".(int)$event_id;			
				if(!database_void_query($sql_1) && (database_void_query($sql_2) >= 0)){
					if($this->isDebug) $this->arrSQLs[] = $sql."<br /><br />";
					$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_deleting_event']);
				}else{				
					$this->arrMessages[] = $this->GetMessage("success", str_replace("_EVENT_NAME_", $event_name['name'], $this->lang['success_event_was_deleted']));
					$this->DeleteCache();									
				}
				if($this->isDebug) $this->arrSQLs[] = $sql_1."<br /><br />";
				if($this->isDebug) $this->arrSQLs[] = $sql_2."<br /><br />";
			}else{
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_deleting_event']);
			}
		}else if($event_action == "categories_insert"){
			// insert new category
			$sql = "SELECT COUNT(*) as cnt FROM ".DB_PREFIX."events_categories WHERE company_id = '".$_SESSION['c_id']."' AND name = '".$this->PrepareText($category_name)."'";
			$category_exists = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			if($category_exists['cnt'] > 0){
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_category_exists']);
			}else{ 
				$sql = "INSERT INTO ".DB_PREFIX."events_categories (id, name, description, color, company_id, usertype_id, user_id) VALUES (NULL, '".$this->PrepareText($category_name)."', '".$this->PrepareText($category_description)."', '".$category_color."', '".$_SESSION['c_id']."', '".$_SESSION['USERTYPE_ID']."', '".$_SESSION['c_id']."')";
				$insert_id = database_void_query($sql);	
				if($insert_id != false){
					$this->arrMessages[] = $this->GetMessage("success", $this->lang['success_new_category_added']);
				}else{
					$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_inserting_new_category']);
				}				
			}			
		}else if($event_action == "categories_update"){
			// update categories 
			$sql = "UPDATE ".DB_PREFIX."events_categories SET name='".$this->PrepareText($category_name)."', description='".$this->PrepareText($category_description)."', color='".$category_color."' WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$category_id;
			if(database_void_query($sql)){
				$this->arrMessages[] = $this->GetMessage("success", $this->lang['success_category_was_updated']);
			}else{
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_updating_category']);
			}			
		}else if($event_action == "categories_delete"){
			// delete category 
			$sql = "DELETE FROM ".DB_PREFIX."events_categories WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$category_id;			
			if(!database_void_query($sql)){
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_deleting_category']);
			}else{				
				$this->arrMessages[] = $this->GetMessage("success", $this->lang['success_category_was_deleted']);
				$this->DeleteCache();									
			}
		}
		if($this->isDebug && $sql != "") $this->arrSQLs[] = $sql."<br /><br />";
	}	

	/**
	 *	Draw CSS style
	 *
	*/	
	private function DrawCssStyle()
	{
		if($this->isDemo && !$this->isShowcase){
			$css_style 	= isset($_REQUEST['css_style']) ? $_REQUEST['css_style'] : "blue";			
		}else{
			$css_style = $this->cssStyle;
		}
		echo "<link href='".$this->calDir."style/".$css_style."/style.css' rel='stylesheet' type='text/css' />".$this->crLt;					
	}

	/**
	 *	Draw javascript functions
	 *
	*/	
	private function DrawJsFunctions()
	{
		
		echo "<script type='text/javascript'>".$this->crLt;
		echo "<!--\n
			GL_jump_day   = '".$this->arrToday["mday"]."';
			GL_jump_month = '".$this->ConvertToDecimal($this->arrToday["mon"])."';
			GL_jump_year  = '".$this->arrToday["year"]."';
			GL_view_type  = '".$this->defaultView."';
			GL_today_year = '".$this->arrToday["year"]."';
			GL_today_mon  = '".$this->ConvertToDecimal($this->arrToday["mon"])."';
			GL_today_mday = '".$this->arrToday["mday"]."';
		\n//-->".$this->crLt;
		echo "</script>".$this->crLt;
		echo "<script type='text/javascript' src='".$this->calDir."js/lang/".$this->langName.".js'></script>".$this->crLt;
		echo "<script type='text/javascript' src='".$this->calDir."js/calendar.js'></script>".$this->crLt;
		if($this->addEventFormType == "floating"){
			echo "<script type='text/javascript' src='".$this->calDir."js/draggable.js'></script>".$this->crLt;
			$this->arrInitJsFunction[] = "function initialize(){ addEventDragObject = new dragObject('divAddEvent', 'divAddEvent_Header'); } initialize();";
		}
		//if($this->arrEventsOperations['events_statistics'] && $this->arrParameters["event_action"] == "events_statistics"){}
		if($this->arrEventsOperations['events_statistics'] && $this->arrParameters["event_action"] == "events_statistics"){
			echo "<script type='text/javascript' src='".$this->calDir."modules/google_api/jsapi.js'></script>".$this->crLt;
			echo "<script type='text/javascript'>function drawVisualization(){
					// Create and populate the data table.
					var data = new google.visualization.DataTable();
					data.addColumn('string', '".$this->lang['event_name']."');
					data.addColumn('number', '".$this->lang['occurrences']."');";
			
					$sql = "SELECT
								".DB_PREFIX."events.id,
								".DB_PREFIX."events.name,
								".DB_PREFIX."events.description,
								COUNT(".DB_PREFIX."calendar.id) as cnt
							FROM ".DB_PREFIX."events
								LEFT OUTER JOIN ".DB_PREFIX."calendar 
								ON ".DB_PREFIX."calendar.event_id = ".DB_PREFIX."events.id
							WHERE (".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."' OR
							".DB_PREFIX."calendar.company_id = '".$_SESSION['c_id']."')
							GROUP BY ".DB_PREFIX."events.id							
							ORDER BY cnt DESC
							LIMIT 0, 10";
							//".(($this->userID) ? " AND ".DB_PREFIX."calendar.user_id = ".(int)$this->userID : "")."
					$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
					$content = file_get_contents($this->calDir."template/events_management_row.tpl");			   			   
			
					echo "data.addRows(".$result[1].");".$this->crLt;
					$events_count = "0";
					foreach($result[0] as $key => $val){
						echo "data.setCell(".$events_count.", 0, '".$this->PrepareFormatedText($val['name'])." (".$val['cnt'].")');".$this->crLt;
						echo "data.setCell(".$events_count.", 1, ".$val['cnt'].");".$this->crLt;
						$events_count++;
					}
				 
					// Create and draw the visualization
					if($this->arrParameters["chart_type"] == "barchart"){
						 echo "new google.visualization.BarChart(document.getElementById('div_visualization')).draw(data, {is3D: true, min:0, title:'".$this->lang['top_10_events']."'});".$this->crLt; 
					}else if($this->arrParameters["chart_type"] == "piechart"){
						 echo "new google.visualization.PieChart(document.getElementById('div_visualization')).draw(data, {is3D: true, min:0, title:'".$this->lang['top_10_events']."'});".$this->crLt;
					}else{ // columnchart
						 echo "new google.visualization.ColumnChart(document.getElementById('div_visualization')).draw(data, {is3D: true, min:0, title:'".$this->lang['top_10_events']."'});".$this->crLt;
					}			   
				   
				echo " }	   
			  </script>".$this->crLt;

			$this->arrInitJsFunction[] = "google.load('visualization', '1', {packages: ['".$this->arrParameters["chart_type"]."']});";
			$this->arrInitJsFunction[] = "google.setOnLoadCallback(drawVisualization);";
		}
	}
	
	/**
	 *	Include Modules
	 *
	*/	
	private function IncludeModules()
	{
		if(($this->eventsDisplayType['monthly'] == "tooltip") || ($this->eventsDisplayType['weekly'] == "tooltip")){
			echo "<script type='text/javascript' src='".$this->calDir."modules/overlib/overlib.js'></script>".$this->crLt;					
		}
	}

	/**
	 *	Initialize javascript functions
	 *
	*/	
	private function InitializeJsFunctions()
	{
		if(count($this->arrInitJsFunction) > 0){
			echo "<script type='text/javascript'>\n";
			echo "<!--\n";
			foreach($this->arrInitJsFunction as $key => $val){
				echo $val."\n";
			}
			echo "//-->\n";
			echo "</script>\n";			
		}
	}	
	
	/**
	 *	Draw system messages
	 *
	*/	
	private function DrawMessages($draw = true)
	{		
		$output = "";
		if(count($this->arrMessages) > 0){
			echo "<tr>";
			foreach($this->arrMessages as $key){
				$output .= "<th colspan='3'>".$key."</th>".$this->crLt;
			}
			echo "</tr>";
		}
		if($draw) echo $output;
		else return $output;		
	}
	
	/**
	 *	Draw system errors
	 *
	*/	
	private function DrawErrors($draw = true)
	{
		$output = "";
		if(count($this->arrErrors) > 0){
			foreach($this->arrErrors as $key){
				$output .= "<span>".$key."</span><br />".$this->crLt;
			}
		}
		if($draw) echo $output;
		else return $output;		
	}

	/**
	 *	Draw system errors
	 *
	*/	
	private function DrawSQLs($draw = true)
	{		
		$output = "";
		if(count($this->arrSQLs) > 0){
			foreach($this->arrSQLs as $key){
				$output .= "<span>".$key."</span><br />".$this->crLt;
			}
		}
		if($draw) echo $output;
		else return $output;		
	}

	/**
	 *	Draw yearly calendar
	 *
	*/	
	private function DrawYear()
	{
		// start caching
		$cachefile = $this->cacheDir."yearly-".$this->arrParameters['year'].".cch";
		if($this->isCachingAllowed){
			if($this->StartCaching($cachefile)) return true;
		}

		$this->celHeight = "20px";
		echo "<table class='year_container'>".$this->crLt;
		echo "<tr>".$this->crLt;
			echo "<th colspan='3'>";
				echo "<table class='table_navbar'>".$this->crLt;
				echo "<tr>";
				echo "<th class='tr_navbar_left' valign='middle'>
					  ".$this->DrawDateJumper(false, false, false)."
					  </th>".$this->crLt;
				echo "<th class='tr_navbar'></th>".$this->crLt;
				echo "<th class='tr_navbar_right'>				
					  <a href=\"javascript:__doPostBack('view', 'yearly', '".$this->prevYear['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">".$this->prevYear['year']."</a> |
					  <a href=\"javascript:__doPostBack('view', 'yearly', '".$this->nextYear['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">".$this->nextYear['year']."</a>
					  </th>".$this->crLt;
				echo "</tr>".$this->crLt;
				echo "</table>".$this->crLt;
			echo "</td>".$this->crLt;
		echo "</tr>".$this->crLt;

		echo "<tr>";
		for($i = 1; $i <= 12; $i++){
			echo "<td align='center' valign='top'>";
			if($this->arrViewTypes["monthly"]["enabled"]){
				echo "<a href=\"javascript:__doPostBack('view', 'monthly', '".$this->arrParameters['year']."', '".$this->ConvertToDecimal($i)."', '".$this->arrParameters['day']."')\"><b>".$this->arrMonths["$i"]."</b></a>";				
			}else{
				echo "<b>".$this->arrMonths["$i"]."</b>";
			}			
			$this->DrawMonthSmall($this->arrParameters['year'], $this->ConvertToDecimal($i));
			echo "</td>";
			if(($i != 1) && ($i % 3 == 0)) echo "</tr><tr>";
		}
		echo "</tr>";
		echo "<tr><td nowrap='nowrap' height='5px'></td></tr>";
		echo "</table>";

		// finish caching
		if($this->isCachingAllowed) $this->FinishCaching($cachefile);			
	}


	/**
	 *	Draw list view calendar
	 *
	*/	
	private function DrawListView()
	{
		// start caching
		$cachefile = $this->cacheDir."listview-".$this->arrParameters['year']."-".$this->arrParameters['month'].".cch";
		if($this->isCachingAllowed){
			if($this->StartCaching($cachefile)) return true;
		}
	
		// today, first day and last day in month
		$firstDay = getdate(mktime(0,0,0,$this->arrParameters['month'],1,$this->arrParameters['year']));
		$lastDay  = getdate(mktime(0,0,0,$this->arrParameters['month']+1,0,$this->arrParameters['year']));
		$actday   = 0;
		
		$arrEventsList = $this->GetEventsListForMonth($this->arrParameters['year'], $this->arrParameters['month'], true);
		//echo "<pre>";
		//print_r($arrEventsList);
		//echo "</pre>";
		
		// Create a table with the necessary header informations
		echo "<table class='month'>".$this->crLt;
		echo "<tr>".$this->crLt;
			if($this->isWeekNumberOfYear) echo "<th colspan='2'>".$this->crLt;
			else echo "<th colspan='2'>".$this->crLt;
				echo "<table class='table_navbar'>".$this->crLt;
				echo "<tr>";
				echo "<th class='tr_navbar_left'>
					  ".$this->DrawDateJumper(false)."	
					  </th>".$this->crLt;
				echo "<th class='tr_navbar'>";
				echo " <a href=\"javascript:__doPostBack('view', 'list_view', '".$this->prevMonth['year']."', '".$this->ConvertToDecimal($this->prevMonth['mon'])."', '".$this->ConvertToDecimal($this->prevMonth['mday'])."')\">&laquo;&laquo;</a> ";
				echo $this->arrParameters['month_full_name']." - ".$this->arrParameters['year'];
				echo " <a href=\"javascript:__doPostBack('view', 'list_view', '".$this->nextMonth['year']."', '".$this->ConvertToDecimal($this->nextMonth['mon'])."', '".$this->ConvertToDecimal($this->nextMonth['mday'])."')\">&raquo;&raquo;</a> ";
				echo "</th>".$this->crLt;
				echo "<th class='tr_navbar_right'>				
					  <a href=\"javascript:__doPostBack('view', 'list_view', '".$this->prevYear['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">".$this->prevYear['year']."</a> |
					  <a href=\"javascript:__doPostBack('view', 'list_view', '".$this->nextYear['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">".$this->nextYear['year']."</a>
					  </th>".$this->crLt;
				echo "</tr>".$this->crLt;
				echo "</table>".$this->crLt;
			echo "</td>".$this->crLt;
		echo "</tr>".$this->crLt;
		
		//print_r($arrEventsList);
		$displayed_count = 0;
		for($i = 0; $i < 31; $i++){
			$monthly_day_events = $this->GetMonthlyDayEvents($arrEventsList, $i);
			if($monthly_day_events != ""){
				if($displayed_count > 0) echo "<tr><td></td><td align='left'><div class='lv_separator'></div></td></tr>";
				echo "<tr>".$this->crLt;
				echo "<td width='15%' class='lv_lcolumn'>";
				echo $this->ConvertToDecimal($i)." ".$this->arrParameters["month_full_name"];
				echo "</td>";
				echo "<td width='85%' class='lv_rcolumn'>";
				echo $monthly_day_events;
				echo "</td>";
				echo "</tr>".$this->crLt;
				$displayed_count++;
			}
		}
		echo "<tr><td colspan='2' height='10px' nowrap='nowrap'></td></tr>";
		
		echo "</table>".$this->crLt;
		
		
		

		// finish caching
		if($this->isCachingAllowed) $this->FinishCaching($cachefile);			
	}

	/**
	 *	Draw monthly calendar
	 *
	*/	
	private function DrawMonth()
	{
		// start caching
		$cachefile = $this->cacheDir."monthly-".$this->arrParameters['year']."-".$this->arrParameters['month'].".cch";
		if($this->isCachingAllowed){
			if($this->StartCaching($cachefile)) return true;
		}
	
		// today, first day and last day in month
		$firstDay = getdate(mktime(0,0,0,$this->arrParameters['month'],1,$this->arrParameters['year']));
		$lastDay  = getdate(mktime(0,0,0,$this->arrParameters['month']+1,0,$this->arrParameters['year']));
		$actday   = 0;
		
		$arrEventsList = $this->GetEventsListForMonth($this->arrParameters['year'], $this->arrParameters['month']);
		
		//echo "<pre>";
		//print_r($arrEventsList);
		//echo "</pre>";
		
		// Create a table with the necessary header informations
		echo "<table class='month'>".$this->crLt;
		echo "<tr>";
			if($this->isWeekNumberOfYear) echo "<th colspan='8'>";
			else echo "<th colspan='7'>";
				echo "<table class='table_navbar'>".$this->crLt;
				echo "<tr>";
				echo "<th class='tr_navbar_left'>
					  ".$this->DrawDateJumper(false)."	
					  </th>".$this->crLt;
				echo "<th class='tr_navbar'>";
				echo " <a href=\"javascript:__doPostBack('view', 'monthly', '".$this->prevMonth['year']."', '".$this->ConvertToDecimal($this->prevMonth['mon'])."', '".$this->ConvertToDecimal($this->prevMonth['mday'])."')\">&laquo;&laquo;</a> ";
				echo $this->arrParameters['month_full_name']." - ".$this->arrParameters['year'];
				echo " <a href=\"javascript:__doPostBack('view', 'monthly', '".$this->nextMonth['year']."', '".$this->ConvertToDecimal($this->nextMonth['mon'])."', '".$this->ConvertToDecimal($this->nextMonth['mday'])."')\">&raquo;&raquo;</a> ";
				echo "</th>".$this->crLt;
				echo "<th class='tr_navbar_right'>				
					  <a href=\"javascript:__doPostBack('view', 'monthly', '".$this->prevYear['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">".$this->prevYear['year']."</a> |
					  <a href=\"javascript:__doPostBack('view', 'monthly', '".$this->nextYear['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."')\">".$this->nextYear['year']."</a>
					  </th>".$this->crLt;
				echo "</tr>".$this->crLt;
				echo "</table>".$this->crLt;
			echo "</td>".$this->crLt;
		echo "</tr>".$this->crLt;
		echo "<tr class='tr_days'>".$this->crLt;
			if($this->isWeekNumberOfYear) echo "<td class='th_wn'></td>".$this->crLt;
			for($i = $this->weekStartedDay-1; $i < $this->weekStartedDay+6; $i++){
				echo "<td class='th'>".$this->arrWeekDays[($i % 7)][$this->weekDayNameLength]."</td>".$this->crLt;
			}
		echo "</tr>".$this->crLt;		
		
		// Display the first calendar row with correct positioning
		if ($firstDay['wday'] == 0) $firstDay['wday'] = 7;
		$max_empty_days = $firstDay['wday']-($this->weekStartedDay-1);		
		if($max_empty_days < 7){
			echo "<tr class='tr' style='height:".$this->celHeight.";'>".$this->crLt;
			if($this->isWeekNumberOfYear){
				$parts = explode("-", (date("Y-m-d-W", mktime(0,0,0,$this->arrParameters["month"],1-$max_empty_days,$this->arrParameters["year"]))));
				echo "<td class='td_wn'>";
				if($this->arrViewTypes["weekly"]["enabled"]){
					echo "<a href=\"javascript:__doPostBack('view', 'weekly', '".$parts[0]."', '".$parts[1]."', '".$parts[2]."')\" title='".$this->lang['click_view_week']."'>".$parts[3]."</a>";
				}else{
					echo $parts[3];
				}
				echo "</td>".$this->crLt;
			}
			for($i = 1; $i <= $max_empty_days; $i++){
				echo "<td class='td_empty'>&nbsp;</td>".$this->crLt;
			}			
			for($i = $max_empty_days+1; $i <= 7; $i++){
				$actday++;//++
				if (($actday == $this->arrToday['mday']) && ($this->arrToday['mon'] == $this->arrParameters["month"])) {
					$class = " class='td_actday'";			
				} else if ($actday == $this->arrParameters['day']){
					$class = " class='td_selday'";
				} else if ($this->arrWeekDays[(($i+($this->weekStartedDay - 2)) % 7)]["short"] == "Sun") {
					$class = ($this->sundayColor) ? " class='td_sunday'" : " class='td'";
				} else {
					$class = " class='td'";
				} 
				echo "<td$class>";
				//$events_count = (is_array($arrEventsList[$this->ConvertToDecimal($actday)])) ? count($arrEventsList[$this->ConvertToDecimal($actday)]) : 0;				
				//$events_count_text = ($events_count > 0) ? " (".(($events_count > 1) ? $events_count." ".$this->lang['events_lc'] : $events_count." ".$this->lang['event_lc']).")" : "";
				$varYear='';$varMonth ='';$testday='';
				$varYear = $this->arrParameters["year"];
				$varMonth = $this->arrParameters["month"];
				$testday = $varYear."-".$varMonth."-".$this->ConvertToDecimal($actday);
				//echo "aditi";
				$calqryc = "SELECT count(id) as row FROM `cal_calendar` WHERE event_date='".$testday."' AND company_id = '".$_SESSION['c_id']."'";
				$calqrycTot = database_query($calqryc, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
				$calqrycM = $calqrycTot['row'];
				$events_count_text = ($calqrycM > 0) ? " (".(($calqrycM > 1) ? $calqrycM." events" : $calqrycM." event").")" : "";	
				if($this->arrViewTypes["daily"]["enabled"]){
					echo "<a href=\"javascript:__doPostBack('view', 'daily', '".$this->arrParameters["year"]."', '".$this->arrParameters["month"]."', '".$this->ConvertToDecimal($actday)."')\">".$actday." ".$events_count_text."</a>";
				}else{
					echo $actday." ".$events_count_text;
				}
				echo "<br />"; 
				// draw events for this day
				$this->DrawMonthlyDayCell($calqrycM, $arrEventsList, $actday);
				echo "</td>".$this->crLt;
			}
			echo "</tr>".$this->crLt;
		}
		
		//Get how many complete weeks are in the actual month
		$fullWeeks = floor(($lastDay['mday']-$actday)/7);
		
		for ($i=0;$i<$fullWeeks;$i++){
			echo "<tr class='tr' style='height:".$this->celHeight.";'>".$this->crLt;
			if($this->isWeekNumberOfYear){
				$parts = explode("-", (date("Y-m-d-W", mktime(0,0,0,$this->arrParameters["month"],$actday+1,$this->arrParameters["year"]))));				
				echo "<td class='td_wn'>";
				if($this->arrViewTypes["weekly"]["enabled"]){
					echo "<a href=\"javascript:__doPostBack('view', 'weekly', '".$parts[0]."', '".$parts[1]."', '".$parts[2]."')\" title='".$this->lang['click_view_week']."'>".$parts[3]."</a>";
				}else{
					echo $parts[3];
				}				
				echo "</td>".$this->crLt;
			}
			for($j=0;$j<7;$j++){
				$actday++;
				if(($actday == $this->arrToday['mday']) && ($this->arrToday['mon'] == $this->arrParameters["month"])){
					$class = " class='td_actday'";
				}else if($actday == $this->arrParameters['day']){				
					$class = " class='td_selday'";				
				}else if($this->arrWeekDays[(($j+($this->weekStartedDay - 1)) % 7)]["short"] == "Sun"){
					$class = ($this->sundayColor) ? " class='td_sunday'" : " class='td'";
				}else{
					$class = " class='td'";
				}
				echo "<td$class>"; 
				$countty = count($arrEventsList[$this->ConvertToDecimal($actday)]);				
				//$events_count = (is_array($arrEventsList[$this->ConvertToDecimal($actday)])) ? count($arrEventsList[$this->ConvertToDecimal($actday)]) : 0;	
				//$events_count_text = ($events_count > 0) ? " (".(($events_count > 1) ? $events_count." events": $events_count." event").")" : "";
				
				//DATE_FORMAT(event_date,'%d') = ab.`targetMonth` AND DATE_FORMAT(vd.`vasDate`,'%Y'
				/*$sqlcountday = "SELECT COUNT(*) as cnt1 FROM ".DB_PREFIX."calendar WHERE company_id = '".$_SESSION['c_id']."' AND DATE_FORMAT(event_date,'%d')='".$actday."'";
			$eventsqlcountday = database_query($sqlcountday, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);*/
				/*echo "<pre>";
				print_r($arrEventsList[$this->ConvertToDecimal($actday)]);
				echo "</pre>";*/
				$varYear='';$varMonth ='';$testday='';
				$varYear = $this->arrParameters["year"];
				$varMonth = $this->arrParameters["month"];
				$testday = $varYear."-".$varMonth."-".$this->ConvertToDecimal($actday);
				//echo "aditi";
				$calqryc = "SELECT count(id) as row FROM `cal_calendar` WHERE event_date='".$testday."' AND company_id = '".$_SESSION['c_id']."'";
				$calqrycTot = database_query($calqryc, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
				$calqrycM = $calqrycTot['row'];
							
	$events_count_text = ($calqrycM > 0) ? " (".(($calqrycM > 1) ? $calqrycM." events": $calqrycM." event").")" : "";
				if($this->arrViewTypes["daily"]["enabled"]){
					echo "<a href=\"javascript:__doPostBack('view', 'daily', '".$this->arrParameters["year"]."', '".$this->arrParameters["month"]."', '".$this->ConvertToDecimal($actday)."')\">".$actday." ".$events_count_text."</a>";
				}else{
					echo $actday." ".$events_count_text;
				}
				echo "<br />";
				// draw events for this day
				$this->DrawMonthlyDayCell($calqrycM, $arrEventsList, $actday);
				echo "</td>".$this->crLt;
			}
			echo "</tr>".$this->crLt;
		}
		
		//Now display the rest of the month
		if ($actday < $lastDay['mday']){
			echo "<tr class='tr' style='height:".$this->celHeight.";'>".$this->crLt;
			if($this->isWeekNumberOfYear){
				$parts = explode("-", (date("Y-m-d-W", mktime(0,0,0,$this->arrParameters["month"],$actday+1,$this->arrParameters["year"]))));
				echo "<td class='td_wn'>";
				if($this->arrViewTypes["weekly"]["enabled"]){
					echo "<a href=\"javascript:__doPostBack('view', 'weekly', '".$parts[0]."', '".$parts[1]."', '".$parts[2]."')\" title='".$this->lang['click_view_week']."'>".$parts[3]."</a>";
				}else{
					echo $parts[3];
				}
				echo "</td>".$this->crLt;
			}

			for($i=0; $i<7;$i++){
				$actday++;
				if(($actday == $this->arrToday['mday']) && ($this->arrToday['mon'] == $this->arrParameters["month"])){
					$class = " class='td_actday'";
				}else if($this->arrWeekDays[(($i+($this->weekStartedDay - 1)) % 7)]["short"] == "Sun"){					
					$class = ($this->sundayColor) ? " class='td_sunday'" : " class='td'";				
				}else{
					$class = " class='td'";
				}				
				if($actday <= $lastDay['mday']){
					echo "<td$class>";
				    //$events_count = (is_array($arrEventsList[$this->ConvertToDecimal($actday)])) ? count($arrEventsList[$this->ConvertToDecimal($actday)]) : 0;	
					$varYear='';$varMonth ='';$testday='';
					$varYear = $this->arrParameters["year"];
					$varMonth = $this->arrParameters["month"];
					$testday = $varYear."-".$varMonth."-".$this->ConvertToDecimal($actday);
					//echo "aditi";
					$calqryc = "SELECT count(id) as row FROM `cal_calendar` WHERE event_date='".$testday."' AND company_id = '".$_SESSION['c_id']."'";
					$calqrycTot = database_query($calqryc, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
					$calqrycM = $calqrycTot['row'];		
					$events_count_text = ($calqrycM > 0) ? " (".(($calqrycM > 1) ? $calqrycM." events" : $calqrycM." event").")" : "";
					if($this->arrViewTypes["daily"]["enabled"]){
						echo "<a href=\"javascript:__doPostBack('view', 'daily', '".$this->arrParameters["year"]."', '".$this->arrParameters["month"]."', '".$this->ConvertToDecimal($actday)."')\">".$actday." ".$events_count_text."</a>";
					}else{						
						echo $actday." ".$events_count_text;
					}
					echo "<br />";
					// draw events for this day
					$this->DrawMonthlyDayCell($calqrycM, $arrEventsList, $actday);
				}else{
					echo "<td class='td_empty'>&nbsp;</td>".$this->crLt;
				}
			}					
			echo "</tr>".$this->crLt;
		}		
		echo "</table>".$this->crLt;

		// finish caching
		if($this->isCachingAllowed) $this->FinishCaching($cachefile);			
	}

	/**
	 *	Draw small monthly calendar
	 *
	*/	
	private function DrawMonthSmall($year = "", $month = "")
	{
		if($month == "") $month = $this->arrParameters['month'];
		if($year == "") $year = $this->arrParameters['year'];
		$week_rows = 0;
		$actday = 0;
		
		// today, first day and last day in month
		$firstDay = getdate(mktime(0,0,0,$month,1,$year));
		$lastDay  = getdate(mktime(0,0,0,$month+1,0,$year));
		
		// create a table with the necessary header informations
		echo "<table class='month_small'>".$this->crLt;
		echo "<tr class='tr_small_days'>".$this->crLt;
			if($this->isWeekNumberOfYear) echo "<td class='th_small_wn'></td>".$this->crLt;
			for($i = $this->weekStartedDay-1; $i < $this->weekStartedDay+6; $i++){
				echo "<td class='th_small'>".$this->arrWeekDays[($i % 7)]["short"]."</td>".$this->crLt;		
			}
		echo "</tr>".$this->crLt;
		
		// display the first calendar row with correct positioning
		if ($firstDay['wday'] == 0) $firstDay['wday'] = 7;
		$max_empty_days = $firstDay['wday']-($this->weekStartedDay-1);		
		if($max_empty_days < 7){
			echo "<tr class='tr_small' style='height:".$this->celHeight.";'>".$this->crLt;
			if($this->isWeekNumberOfYear) echo "<td class='td_small_wn'>".date("W", mktime(0,0,0,$month,1-$max_empty_days,$year))."</td>".$this->crLt;			
			for($i = 1; $i <= $max_empty_days; $i++){
				echo "<td class='td_small_empty'>&nbsp;</td>".$this->crLt;
			}			
			for($i = $max_empty_days+1; $i <= 7; $i++){
				$actday++;
				if(($actday == $this->arrToday['mday']) && ($this->arrToday['mon'] == $month) && ($this->arrToday['year'] == $year)) {
					$class = " class='td_small_actday'";			
				}else{
					$class = " class='td_small'";
				} 
				echo "<td$class>$actday</td>".$this->crLt;
			}
			echo "</tr>".$this->crLt;
			$week_rows++;
		}
		
		// get how many complete weeks are in the actual month
		$fullWeeks = floor(($lastDay['mday']-$actday)/7);
		
		for($i=0;$i<$fullWeeks;$i++){
			echo "<tr class='tr_small' style='height:".$this->celHeight.";'>".$this->crLt;
			if($this->isWeekNumberOfYear) echo "<td class='td_small_wn'>".date("W", mktime(0,0,0,$month,$actday,$year))."</td>".$this->crLt;			
			for ($j=0;$j<7;$j++){
				$actday++;
				if(($actday == $this->arrToday['mday']) && ($this->arrToday['mon'] == $month) && ($this->arrToday['year'] == $year)){
					$class = " class='td_small_actday'";
				}else{
					$class = " class='td_small'";
				}
				echo "<td$class>$actday</td>".$this->crLt;
			}
			echo "</tr>".$this->crLt;
			$week_rows++;			
		}
		
		// now display the rest of the month
		if ($actday < $lastDay['mday']){
			echo "<tr class='tr_small' style='height:".$this->celHeight.";'>".$this->crLt;
			if($this->isWeekNumberOfYear) echo "<td class='td_small_wn'>".date("W", mktime(0,0,0,$month,$actday,$year))."</td>".$this->crLt;			
			for ($i=0; $i<7;$i++){
				$actday++;
				if (($actday == $this->arrToday['mday']) && ($this->arrToday['mon'] == $month) && ($this->arrToday['year'] == $year)) {
					$class = " class='td_small_actday'";
				} else {
					$class = " class='td_small'";
				}				
				if ($actday <= $lastDay['mday']){
					echo "<td$class>$actday</td>".$this->crLt;
				} else {
					echo "<td class='td_small_empty'>&nbsp;</td>".$this->crLt;
				}
			}					
			echo "</tr>".$this->crLt;
			$week_rows++;
		}
		
		// complete last line
		if($week_rows < 5){
			echo "<tr class='tr_small' style='height:".$this->celHeight.";'>".$this->crLt;
			if($this->isWeekNumberOfYear) echo "<td class='td_small_wn'></td>".$this->crLt;
			for ($i=0; $i<7;$i++){
				echo "<td class='td_small_empty'>&nbsp;</td>".$this->crLt;
			}					
			echo "</tr>".$this->crLt;
			$week_rows++;			
		}
		
		echo "</table>".$this->crLt;
		
	}	

	/**
	 *	Draw weekly calendar
	 *
	*/	
	private function DrawWeek()
	{
		// start caching
		$cachefile = $this->cacheDir."weekly-".$this->arrParameters['year']."-".$this->arrParameters["month"]."-".$this->arrParameters["day"].".cch";
		if($this->isCachingAllowed){
			if($this->StartCaching($cachefile)) return true;
		}

		// today, first day and last day in month
		$firstDay = getdate(mktime(0,0,0,$this->currWeek['month'],1,$this->currWeek['year']));
		$lastDay  = getdate(mktime(0,0,0,$this->currWeek['month']+1,0,$this->currWeek['year']));
		
		// Create a table with the necessary header informations
		echo "<table class='month' border='0'>".$this->crLt;
		echo "<tr>".$this->crLt;
		echo "<th colspan='7'>".$this->crLt;
			echo "<table border=0 width='100%'>".$this->crLt;
			echo "<tr>";
			echo "<th class='tr_navbar_left'>".$this->DrawDateJumper(false)."</th>";				  
			echo "<th class='tr_navbar'>";
            // draw Month Year - Month Year line
			if($this->currWeek['year'] != $this->nextWeek['year']){
				echo $this->prevWeek['month']." ".$this->currWeek['year']." - ".$this->nextWeek['month']." ".$this->nextWeek['year'];
			}else{
				$month = (int)$this->currWeek['month'];
				echo $this->arrMonths["$month"].(($month != $this->nextWeek['mon']) ? " - ".$this->nextWeek['month'] : "")." ".$this->currWeek['year'];
			}
			echo "</th>".$this->crLt;
			echo "<th class='tr_navbar_right'>				
				  <a href=\"javascript:__doPostBack('view', 'weekly', '".$this->prevWeek['year']."', '".$this->ConvertToDecimal($this->prevWeek['mon'])."', '".$this->ConvertToDecimal($this->prevWeek['mday'])."')\">".$this->ConvertToDecimal($this->prevWeek['mday']).$this->lang['th']." ".$this->prevWeek['month']."</a> |
				  <a href=\"javascript:__doPostBack('view', 'weekly', '".$this->nextWeek['year']."', '".$this->ConvertToDecimal($this->nextWeek['mon'])."', '".$this->ConvertToDecimal($this->nextWeek['mday'])."')\">".$this->ConvertToDecimal($this->nextWeek['mday']).$this->lang['th']." ".$this->nextWeek['month']."</a>
				  </th>".$this->crLt;
			echo "</tr>".$this->crLt;
			echo "</table>".$this->crLt;			  
		echo "</th>".$this->crLt;
		echo "</tr>".$this->crLt;
		echo "<tr class='tr_days'>".$this->crLt;
			for($i = $this->weekStartedDay-1; $i < $this->weekStartedDay+6; $i++){
				$week_day = date("w", mktime(0,0,0,$this->currWeek["month"],$this->currWeek["day"]+$i-($this->weekStartedDay-1),$this->currWeek["year"]));
				echo "<td class='th'>".$this->arrWeekDays[($week_day % 7)][$this->weekDayNameLength]."</td>";						
			}
		echo "</tr>".$this->crLt;
		
		// Display the first calendar row with correct positioning
		echo "<tr>".$this->crLt;
		if ($firstDay['wday'] == 0) $firstDay['wday'] = 7;
		$actday = 0;
		for($i = 0; $i <= 6; $i++){
			$parts = explode("-", date("d-n-Y", mktime(0,0,0,$this->currWeek["month"],$this->currWeek["day"]+$i,$this->currWeek["year"])));
			$actday = $parts[0];
			$actmon = $parts[1];
			$actyear = $parts[2];
			$week_day = date("w", mktime(0,0,0,$this->currWeek["month"],$this->currWeek["day"]+$i-($this->weekStartedDay-1),$this->currWeek["year"]));
			
			if (($actday == $this->arrToday['mday']) && ($this->arrToday['mon'] == $this->currWeek["month"])) {
				$class = " class='td_actday_w'";
			} else if ($this->arrWeekDays[(($week_day+($this->weekStartedDay - 1)) % 7)]["short"] == "Sun") {					
				$class = ($this->sundayColor) ? " class='td_sunday_w'" : " class='td_w'";				
			} else {				
				$class = " class='td_w'";
			}
			echo "<td$class>".$this->crLt;
			
				// prepare events for this day of week
				
				/*$sql = "SELECT
							".DB_PREFIX."calendar.id,
							".DB_PREFIX."calendar.event_date,
							".DB_PREFIX."calendar.event_time,
							DATE_FORMAT(".DB_PREFIX."calendar.event_time, '%H:%i') as event_time_formatted,
							".DB_PREFIX."events.name,
							".DB_PREFIX."events.description,
							".DB_PREFIX."events_categories.color
						FROM ".DB_PREFIX."calendar						
							INNER JOIN ".DB_PREFIX."events ON ".DB_PREFIX."calendar.event_id = (".DB_PREFIX."events.id AND ".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."')
							LEFT OUTER JOIN ".DB_PREFIX."events_categories ON ".DB_PREFIX."events.category_id = (".DB_PREFIX."events_categories.id AND ".DB_PREFIX."events_categories.company_id = '".$_SESSION['c_id']."')
						WHERE
							".DB_PREFIX."calendar.event_date = '".$this->currWeek['year']."-".$this->ConvertToDecimal($actmon)."-".$actday."'
							".(($this->userID) ? " AND ".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."' AND ".DB_PREFIX."calendar.company_id = '".$_SESSION['c_id']."' 
	AND ".DB_PREFIX."calendar.user_id = ".(int)$this->userID : "")."".$this->PrepareWhereClauseEventTime()."
						ORDER BY ".DB_PREFIX."calendar.id ASC";*/
				
				$sql = "SELECT
							".DB_PREFIX."calendar.id,
							".DB_PREFIX."calendar.event_date,
							".DB_PREFIX."calendar.event_time,
							DATE_FORMAT(".DB_PREFIX."calendar.event_time, '%H:%i') as event_time_formatted,
							".DB_PREFIX."events.name,
							".DB_PREFIX."events.description,
							".DB_PREFIX."events_categories.color
						FROM ".DB_PREFIX."calendar						
							INNER JOIN ".DB_PREFIX."events ON ".DB_PREFIX."calendar.event_id = (".DB_PREFIX."events.id)
							LEFT OUTER JOIN ".DB_PREFIX."events_categories ON ".DB_PREFIX."events.category_id = (".DB_PREFIX."events_categories.id)
						WHERE
							".DB_PREFIX."calendar.event_date = '".$this->currWeek['year']."-".$this->ConvertToDecimal($actmon)."-".$actday."' AND ".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."' 
							AND ".DB_PREFIX."calendar.company_id = '".$_SESSION['c_id']."' ORDER BY ".DB_PREFIX."calendar.id ASC";		
						
				$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
				if($this->isDebug) $this->arrSQLs[] =  $sql."<br /><br />";
				
				// prepare time blocks array
				$arrEvents = array();

				if($this->timeBlock == "15"){
					for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){
						for($i_block=0; $i_block<4; $i_block++){
							$hours_part = $i_hour;
							$minutes_part = ($i_block)*$this->timeBlock;
							$this->PrepareMinutesHoures($minutes_part, $hours_part);
							$ind = $this->ConvertToDecimal($hours_part).":".$minutes_part;
							$arrEvents[$ind] = array();
						}
					}
				}else if($this->timeBlock == "30"){
					for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){
						for($i_block=0; $i_block<2; $i_block++){
							$hours_part = $i_hour;
							$minutes_part = ($i_block)*$this->timeBlock;					
							$this->PrepareMinutesHoures($minutes_part, $hours_part);
							$ind = $this->ConvertToDecimal($hours_part).":".$minutes_part;
							$arrEvents[$ind] = array();
						}
					}			
				}else{
					for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){
						$ind = $this->ConvertToDecimal($i_hour).":00";
						$arrEvents[$ind] = array();
					}			
				}
				
				foreach($result[0] as $key => $val){
					$arrEvents[$val['event_time_formatted']][] = array("id"=>$val['id'], "name"=>$val['name'], "description"=>$val['description'], "color"=>$val['color']);
				}
		
				///echo "<pre>";
				///print_r($arrEvents);
				///echo "</pre>";				
			
				echo "<table width='100%' border='0' cellpadding='0' celspacing='0'>".$this->crLt;
				echo "<tr><td class='td_header' colspan='2'><b>";
				if($this->arrViewTypes["daily"]["enabled"]){
					echo "<a href=\"javascript:__doPostBack('view', 'daily', '".$this->currWeek["year"]."', '".$this->ConvertToDecimal($actmon)."', '".$actday."')\">".$this->arrMonths[$actmon]." $actday</a>";
				}else{
					echo $this->arrMonths[$actmon]." ".$actday;
				}
				echo "</b></td></tr>".$this->crLt;
				$today = date("YmdHi");
				
				if($this->weekDisabledDay != "" && $this->weekDisabledDay == ($week_day+1)){
					// do nothing - this day is disabled
				}else{
					foreach($arrEvents as $key_hour => $val_arr){
						$key_hour_parts = explode(":", $key_hour);
						$hour_part = isset($key_hour_parts[0]) ? $key_hour_parts[0] : "00";
						$minute_part = isset($key_hour_parts[1]) ? $key_hour_parts[1] : "00";
						if(($hour_part >= $this->fromHour) && ($hour_part < $this->toHour)){
							echo "<tr>";
							echo "<td align='left' valign='top' width='".(($this->timeFormat == "24") ? "45px" : "64px")."'>".$this->ConvertToHour($hour_part, $minute_part, true)." ";
							$current_date = $actyear.$this->ConvertToDecimal($actmon).$actday.str_replace(":", "", $key_hour);
							if($this->arrEventsOperations['add']){
								if($this->allowEditingEventsInPast || (!$this->allowEditingEventsInPast && ($current_date > $today))){
									echo "<a href=\"javascript:__CallAddEventForm('divAddEvent', '".$this->currWeek["year"]."', '".$this->ConvertToDecimal($actmon)."', '".$actday."', '".$key_hour."');\" title='".$this->lang["add_new_event"]."'>+</a><br />";
								}
							}
							echo $this->GetEventsListForWeekDay($arrEvents[$key_hour]);
							echo "</td>";
							echo "</tr>".$this->crLt;						
						}
					}					
				}
				echo "</table>".$this->crLt;
			echo "</td>".$this->crLt;
		}
		echo "</tr>".$this->crLt;
		echo "</table>".$this->crLt;		

		$this->DrawAddEventForm();

		// finish caching
		if($this->isCachingAllowed) $this->FinishCaching($cachefile);			
	}

	/**
	 *	Draw daily calendar
	 *
	*/	
	private function DrawDay()
	{
		// start caching
		$cachefile = $this->cacheDir."daily-".$this->arrParameters['year']."-".$this->arrParameters["month"]."-".$this->arrParameters["day"].".cch";
		if($this->isCachingAllowed){
			if($this->StartCaching($cachefile)) return true;
		}
		//".DB_PREFIX."calendar
		$sql = "SELECT
					".DB_PREFIX."calendar.id,
					".DB_PREFIX."calendar.event_date,
					".DB_PREFIX."calendar.event_time,
					DATE_FORMAT(".DB_PREFIX."calendar.event_time, '%H:%i') as event_time_formatted,					
					".DB_PREFIX."events.name,
					".DB_PREFIX."events.description,
					".DB_PREFIX."events_categories.color
				FROM ".DB_PREFIX."calendar
					INNER JOIN ".DB_PREFIX."events ON ".DB_PREFIX."calendar.event_id = ".DB_PREFIX."events.id AND ".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."'
					LEFT OUTER JOIN ".DB_PREFIX."events_categories ON ".DB_PREFIX."events.category_id = ".DB_PREFIX."events_categories.id
				WHERE
					".DB_PREFIX."calendar.event_date = '".$this->arrParameters['year']."-".$this->arrParameters['month']."-".$this->arrParameters['day']."' AND (".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."' OR ".DB_PREFIX."calendar.company_id = '".$_SESSION['c_id']."')	".$this->PrepareWhereClauseEventTime()."					
				ORDER BY ".DB_PREFIX."calendar.id ASC";
		//".(($this->userID) ? "  AND ".DB_PREFIX."calendar.user_id = ".(int)$this->userID : "")."		
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
		if($this->isDebug) $this->arrSQLs[] =  $sql."<br /><br />";
		
		// prepare time blocks array
		$arrEvents = array();

		if($this->timeBlock == "15"){
			for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){
				for($i_block=0; $i_block<4; $i_block++){
					$hours_part = $i_hour;
					$minutes_part = ($i_block)*$this->timeBlock;					
					$this->PrepareMinutesHoures($minutes_part, $hours_part);
					$ind = $this->ConvertToDecimal($hours_part).":".$minutes_part;
					$arrEvents[$ind] = array();
				}
			}
		}else if($this->timeBlock == "30"){
			for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){
				for($i_block=0; $i_block<2; $i_block++){
					$hours_part = $i_hour;
					$minutes_part = ($i_block)*$this->timeBlock;					
					$this->PrepareMinutesHoures($minutes_part, $hours_part);
					$ind = $this->ConvertToDecimal($hours_part).":".$minutes_part;
					$arrEvents[$ind] = array();
				}
			}			
		}else{
			for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){
				$ind = $this->ConvertToDecimal($i_hour).":00";
				$arrEvents[$ind] = array();
			}			
		}
		
		foreach($result[0] as $key => $val){
			$arrEvents[$val['event_time_formatted']][] = array("id"=>$val['id'], "name"=>$val['name'], "description"=>$val['description'], "color"=>$val['color']);
		}

		///echo "<pre>";
		///print_r($arrEvents);
		///echo "</pre>";	 
		
		// Create a table with the necessary header informations
		echo "<table class='day_navigation' width='100%' border='0' cellpadding='0' celspacing='0'>".$this->crLt;
		echo "<tr>";
		echo "<th class='tr_navbar_left'>
			  ".$this->DrawDateJumper(false)."	
			  </th>".$this->crLt;
		echo "<th class='tr_navbar'>";
		echo " <a href=\"javascript:__doPostBack('view', 'daily', '".$this->prevDay['year']."', '".$this->ConvertToDecimal($this->prevDay['mon'])."', '".$this->ConvertToDecimal($this->prevDay['mday'])."')\">&laquo;&laquo;</a> ";
		echo $this->arrParameters["weekday"]." - ".$this->arrParameters['month_full_name']." ".$this->arrParameters['day'].", ".$this->arrParameters['year'];
		echo " <a href=\"javascript:__doPostBack('view', 'daily', '".$this->nextDay['year']."', '".$this->ConvertToDecimal($this->nextDay['mon'])."', '".$this->ConvertToDecimal($this->nextDay['mday'])."')\">&raquo;&raquo;</a> ";
		echo "</th>".$this->crLt;
		echo "<th class='tr_navbar_right' colspan='2'>				
			  <a href=\"javascript:__doPostBack('view', 'daily', '".$this->prevWeek['year']."', '".$this->ConvertToDecimal($this->prevWeek['mon'])."', '".$this->ConvertToDecimal($this->prevWeek['mday'])."')\">".$this->ConvertToDecimal($this->prevWeek['mday'])."th ".$this->prevWeek['month']."</a> |
			  <a href=\"javascript:__doPostBack('view', 'daily', '".$this->nextWeek['year']."', '".$this->ConvertToDecimal($this->nextWeek['mon'])."', '".$this->ConvertToDecimal($this->nextWeek['mday'])."')\">".$this->ConvertToDecimal($this->nextWeek['mday'])."th ".$this->nextWeek['month']."</a>
			  </th>".$this->crLt;
		echo "</tr>".$this->crLt;
		echo "</table>".$this->crLt;

		echo "<table class='day' cellpadding='0' celspacing='0'>".$this->crLt;
		$today = date("YmdHi");				
		foreach($arrEvents as $key_hour => $val_arr){
			$key_hour_parts = explode(":", $key_hour);
			$hour_part = isset($key_hour_parts[0]) ? $key_hour_parts[0] : "00";
			$minute_part = isset($key_hour_parts[1]) ? $key_hour_parts[1] : "00";
			if(($hour_part >= $this->fromHour) && ($hour_part < $this->toHour)){
				if($this->ConvertToDecimal($key_hour) == $this->arrToday['hours']) {
					$td_acthour_d = " class='td_acthour_d_h'";
					$td_d = " class='td_acthour_d'";
				} else {
					$td_acthour_d = " class='td_d_h'";
					$td_d = " class='td_d'";
				}
				echo "<tr>";		
				echo "<td".$td_acthour_d."><b>".$this->ConvertToHour($hour_part, $minute_part, true)."</b></td>";
				echo "<td".$td_d.">";
				if($this->weekDisabledDay != "" && $this->weekDisabledDay == ($this->arrParameters["wday"]+1)){
					// do nothing - this day is disabled
				}else{
					$current_date = $this->arrParameters['year'].$this->arrParameters['month'].$this->arrParameters['day'].str_replace(":", "", $key_hour);
					if($this->arrEventsOperations['add']){
						if($this->allowEditingEventsInPast || (!$this->allowEditingEventsInPast && ($current_date > $today))){
							echo " <a href=\"javascript:__CallAddEventForm('divAddEvent', '".$this->arrParameters["year"]."', '".$this->arrParameters["month"]."', '".$this->arrParameters["day"]."', '".$key_hour."');\" title='".$this->lang['add_new_event']."'>+</a> ";					
						}
					}
					echo $this->GetEventsListForHour($arrEvents[$key_hour]);
				}
				echo "</td>";
				echo "</tr>".$this->crLt;				
			}
		}
		echo "</table>".$this->crLt;			

		$this->DrawAddEventForm();

		// finish caching
		if($this->isCachingAllowed) $this->FinishCaching($cachefile);			
	}


	////////////////////////////////////////////////////////////////////////////
	// EVENTS

	/**
	 *	Draw single event adding form
	 *	
	*/	
	private function DrawAddEventForm(){
		// draw Add Event Form from template
		$sql = "SELECT id, name, description
				FROM ".DB_PREFIX."events WHERE company_id = '".$_SESSION['c_id']."'
				ORDER BY id ASC
				LIMIT 0, 1000";
				
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);

		$content = file_get_contents($this->calDir."template/add_event_form.tpl");
		
        if($content !== false){
			$content = str_replace("{h:on_mousedown_header}", (($this->addEventFormType == "floating") ? " onmousedown='grab(this, event)'" : ""), $content);
			$content = str_replace("{h:class_move}", (($this->addEventFormType == "floating") ? " move" : ""), $content);
			$content = str_replace("{h:on_mousedown_body}", (($this->addEventFormType == "floating") ? " onmousedown='grab(false, event);'" : ""), $content);
			$content = str_replace("{h:ddl_from}", $this->DrawDateTime("from", $this->arrParameters["year"], $this->arrParameters["month"], $this->arrParameters["day"], $this->arrToday['hours'], false), $content);
			$content = str_replace("{h:ddl_to}", $this->DrawDateTime("to", $this->arrParameters["year"], $this->arrParameters["month"], $this->arrParameters["day"], $this->arrToday['hours'], false), $content);
			$content = str_replace("{h:lan_event_name}", $this->lang['event_name'], $content);
			$content = str_replace("{h:lan_event_description}", $this->lang['event_description'], $content);
			$content = str_replace("{h:lan_from}", $this->lang['from'], $content);
			$content = str_replace("{h:lan_to}", $this->lang['to'], $content); 
			$content = str_replace("{h:lan_add_event}", $this->lang['add_event'], $content);
			$content = str_replace("{h:lan_close}", $this->lang['close'], $content);
			$content = str_replace("{h:lan_add_new_event}", $this->lang['add_new_event'], $content);
			$content = str_replace("{h:select_user}", $this->lang['user_id'], $content);
			
			$content = str_replace("{h:ddl_event_name}", $this->DrawEventsDDL("", "onchange='javascript:__EventSelectedDDL(2);'"), $content);
			echo $content;
		}
	}

	/**
	 *	Draw events additing form
	 *
	*/	
	private function DrawEventsAddForm()
	{
		// draw Add Event Form from template
		$content = file_get_contents($this->calDir."template/events_add_form.tpl");

		$legend = "<legend class='cal_legend'>			  
					<strong>[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_add')\">".$this->lang['add_new_event']."</a> ]</strong>
					[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_management')\">".$this->lang['events_management']."</a> ]
			  </legend>";
		
		$content = str_replace("{h:legend}", $legend, $content);
		$content = str_replace("{h:lan_event_name}", $this->lang['event_name'], $content);		
		$content = str_replace("{h:lan_event_description}", $this->lang['event_description'], $content);
		$content = str_replace("{h:lan_or}", $this->lang['or'], $content);
		$content = str_replace("{h:lan_add_event}", "+ ".$this->lang['add_event'], $content);
		$content = str_replace("{h:lan_cancel}", $this->lang['cancel'], $content);
		$content = str_replace("{h:lan_from}", $this->lang['from'], $content);
		$content = str_replace("{h:lan_to}", $this->lang['to'], $content);
		$content = str_replace("{h:lan_or}", $this->lang['or'], $content);
		$content = str_replace("{h:lan_add_event_to_list}", $this->lang['lbl_add_event_to_list'], $content);
		$content = str_replace("{h:lan_add_event_occurrences}", $this->lang['lbl_add_event_occurrences'], $content);
		$content = str_replace("{h:ddl_from}", $this->DrawDateTime("from", $this->arrParameters["year"], $this->arrParameters["month"], $this->arrParameters["day"], $this->arrToday['hours'], false, true), $content);
		$content = str_replace("{h:ddl_to}", $this->DrawDateTime("to", $this->arrParameters["year"], $this->arrParameters["month"], $this->arrParameters["day"], $this->arrToday['hours'], false, true), $content);
		
		// display categories if allowed
		if($this->arrCatOperations['manage']){
			$content = str_replace("{h:lan_category_name}", $this->lang['category_name'].":<br />", $content);
			$content = str_replace("{h:ddl_categories}", $this->DrawCategoriesDDL("", false), $content);		
		}else{
			$content = str_replace("{h:lan_category_name}", "", $content);
			$content = str_replace("{h:ddl_categories}", "", $content);					
		}
		
        if($content !== false){
			echo $content;
		}
	}	

	/**
	 *	Draw events editing form
	 *
	*/	
	private function DrawEventsEditForm($event_id)
	{
		// draw Edit Event Form from template
		$content = file_get_contents($this->calDir."template/events_edit_form.tpl");			   			   

		$content = str_replace("{h:lan_event_name}", $this->lang['event_name'], $content);
		$content = str_replace("{h:lan_event_description}", $this->lang['event_description'], $content);
		$content = str_replace("{h:lan_or}", $this->lang['or'], $content);
		$content = str_replace("{h:lan_cancel}", $this->lang['cancel'], $content);
		$content = str_replace("{h:lan_edit_event}", $this->lang['edit_event'], $content);
		$content = str_replace("{h:lan_update_event}", $this->lang['update_event'], $content);

        if($content !== false){
			$sql = "SELECT id, name, description, category_id
					FROM ".DB_PREFIX."events
					WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$event_id;
					
			$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			if(!empty($result)){
				$content = str_replace("{h:event_id}", $result["id"], $content);
				$content = str_replace("{h:event_name}", $this->PrepareFormatedText($result["name"]), $content);
				$content = str_replace("{h:event_description}", $result["description"], $content);

				// display categories if allowed
				if($this->arrCatOperations['manage']){
					$content = str_replace("{h:lan_category_name}", $this->lang['category_name'].":<br />", $content);
					$content = str_replace("{h:ddl_categories}", $this->DrawCategoriesDDL($result["category_id"], false), $content);		
				}else{
					$content = str_replace("{h:lan_category_name}", "", $content);
					$content = str_replace("{h:ddl_categories}", "", $content);					
				}	

				echo $content;
			}
		}
	}	

	/**
	 *	Draw events details form
	 *
	*/	
	private function DrawEventsDetailsForm($event_id)
	{
		// draw Details Event Form from template
		$content = file_get_contents($this->calDir."template/events_details_form.tpl");

		$content = str_replace("{h:lan_event_name}", $this->lang['event_name'], $content);
		$content = str_replace("{h:lan_event_description}", $this->lang['event_description'], $content);
		$content = str_replace("{h:lan_event_details}", $this->lang['event_details'], $content);
		$content = str_replace("{h:lan_back}", $this->lang['back'], $content);

        if($content !== false){
			$sql = "SELECT
						".DB_PREFIX."events.id,
						".DB_PREFIX."events.name,
						".DB_PREFIX."events.description,
						".DB_PREFIX."events_categories.name as category_name
					FROM ".DB_PREFIX."events
						LEFT OUTER JOIN ".DB_PREFIX."events_categories ON ".DB_PREFIX."events.category_id = ".DB_PREFIX."events_categories.id AND ".DB_PREFIX."events_categories.company_id = '".$_SESSION['c_id']."'					
					WHERE ".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."' AND ".DB_PREFIX."events.id = ".(int)$event_id;
					
			$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			if(!empty($result)){
				/// $content = str_replace("{h:event_id}", $result["id"], $content);
				$content = str_replace("{h:event_name}", $result["name"], $content);
				$content = str_replace("{h:event_description}", $result["description"], $content);
				if($this->arrParameters["previous_action"] == "events_management"){
					$content = str_replace("{h:js_back_function}", '__EventsBack("events_management")', $content);
				}else{
					$content = str_replace("{h:js_back_function}", '__EventsBack("list_view")', $content);
				}				

				// display categories if allowed
				if($this->arrCatOperations['manage']){
					$content = str_replace("{h:lan_category_name}", $this->lang['category_name'].":", $content);
					$content = str_replace("{h:category_name}", $result['category_name'], $content);
				}else{
					$content = str_replace("{h:lan_category_name}", "", $content);
					$content = str_replace("{h:category_name}", "", $content);
				}				
			}
		}
		echo $content;
	}	

	/**
	 *	Draw events management
	 *
	*/	
	private function DrawEventsManagement()
	{	
		$sql = "SELECT COUNT(*) as cnt FROM ".DB_PREFIX."events WHERE company_id = '".$_SESSION['c_id']."'";
		$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
		$total_records = $result['cnt'];
		$page_size = 20;
		$total_pages = (int)$result['cnt']/$page_size;
		$total_pages_partualy = $result['cnt'] % $page_size;
		if($total_pages_partualy != 0) $total_pages +=1;
		
		$limit_start = ($this->arrParameters["page"]-1) * $page_size;
		if($limit_start < 0) $limit_start = "0";
		$limit_end = $page_size;
		
		$sql = "SELECT
					".DB_PREFIX."events.id,
					".DB_PREFIX."events.name,
					".DB_PREFIX."events.description,
					".DB_PREFIX."events_categories.color,
					".DB_PREFIX."events_categories.name as category_name
				FROM ".DB_PREFIX."events
					LEFT OUTER JOIN ".DB_PREFIX."events_categories ON ".DB_PREFIX."events.category_id = ".DB_PREFIX."events_categories.id WHERE ".DB_PREFIX."events.company_id = '".$_SESSION['c_id']."'
				ORDER BY
					".DB_PREFIX."events.name ASC		
				LIMIT ".$limit_start.", ".$limit_end."";
		/*$sql = "SELECT
					".DB_PREFIX."events.id,
					".DB_PREFIX."events.name,
					".DB_PREFIX."events.description,
					".DB_PREFIX."events_categories.color,
					".DB_PREFIX."events_categories.name as category_name
				FROM ".DB_PREFIX."events
					LEFT OUTER JOIN ".DB_PREFIX."events_categories ON ".DB_PREFIX."events.category_id = ".DB_PREFIX."events_categories.id
				ORDER BY
					".DB_PREFIX."events_categories.name ASC,
					".DB_PREFIX."events.name ASC
				LIMIT ".$limit_start.", ".$limit_end."";*/
				
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
		$content = file_get_contents($this->calDir."template/events_management_row.tpl");			   			   
		
		echo "<fieldset class='cal_fieldset'>
			  <legend class='cal_legend'>			  
					[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_add')\">".$this->lang['add_event']."</a> ]
					<strong>[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_management')\">".$this->lang['events_management']."</a> ]</strong>
			  </legend>
			  <table align='center' border='0' width='100%'>
			  <tr><td colspan='5' nowrap='nowrap' height='3px'></td></tr>
			  <tr>
				<th width='15px'></th>
				<th align='left' width='22%'>".$this->lang['event_name']."</th>
				<th align='left'>".$this->lang['event_description']."</th>"; 
				// display categories if allowed
				if($this->arrCatOperations['manage']){
					echo "<th align='left' width='130px'>".$this->lang['category_name']."</th>";
				}else{
					echo "<th></th>";
				}
				echo "<th align='center' width='140px'>".((!$this->arrEventsOperations['edit'] && !$this->arrEventsOperations['details'] && !$this->arrEventsOperations['delete']) ? "" : $this->lang['actions'])."</th>
			  </tr>
			  <tr><td colspan='5' nowrap='nowrap' height='2px'></td></tr>";
		$events_count = 0;
		foreach($result[0] as $key => $val){
			$temp_content = $content;
			$events_count++;
			
			$drawed_buttons = 0;
			$edit_button = "";
			$details_button = "";
			$delete_button = "";
			if($this->arrEventsOperations['edit'])   { $edit_button    = (($drawed_buttons > 0) ? " | " : "")."<a href='javascript:__EventsEdit({h:event_id});'>".$this->lang['edit']."</a>"; $drawed_buttons++; }			
			if($this->arrEventsOperations['details']){ $details_button = (($drawed_buttons > 0) ? " | " : "")."<a href='javascript:__EventsDetails({h:event_id});'>".$this->lang['details']."</a>"; $drawed_buttons++; }
			if($this->arrEventsOperations['delete']) { $delete_button  = (($drawed_buttons > 0) ? " | " : "")."<a href='javascript:void(0);' onclick='__EventsDelete({h:event_id});'>".$this->lang['delete']."</a>"; $drawed_buttons++; }

			$temp_content = str_replace("{h:edit_button}", $edit_button, $temp_content); 
			$temp_content = str_replace("{h:details_button}", $details_button, $temp_content);
			$temp_content = str_replace("{h:delete_button}", $delete_button, $temp_content);
			
			$description = (strlen($val["description"]) > 50) ? substr($val["description"], 0, 50)."..." : $val["description"];
			$temp_content = str_replace("{h:event_id}", $val["id"], $temp_content);
			$temp_content = str_replace("{h:event_num}", $limit_start+$events_count.". ", $temp_content);
			$temp_content = str_replace("{h:event_name}", "<span style='color:".$val["color"].";'>".$val["name"]."</span>", $temp_content);
			$temp_content = str_replace("{h:event_description}", $description, $temp_content);
			// display categories if allowed
			if($this->arrCatOperations['manage']){
				$temp_content = str_replace("{h:event_category}", $val["category_name"], $temp_content);
			}else{
				$temp_content = str_replace("{h:event_category}", "", $temp_content);
			}			
            echo $temp_content;
		}
		echo "<tr><td colspan='5' style='border-bottom:1px solid #eeeeee;'>&nbsp;</td></tr>";		
		echo "<tr>";
		echo "<td align='left' style='padding-left:10px' colspan='4'>".$this->lang['pages'].": ";
				for($i_pages = 1; $i_pages <= $total_pages; $i_pages++){
					if($i_pages > 1) echo ", ";
					$i_pages_a = ($i_pages == $this->arrParameters["page"]) ? "<strong>".$i_pages."</strong>" : $i_pages;
					echo "<a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_management', '', '".$i_pages."');\">".$i_pages_a."</a>";
				}
		echo "</td>";
		echo "<td align='right' style='padding-right:10px'>".$this->lang['total_events'].": ".$total_records."</td>";
		echo "</tr>";		
		echo "</table>
		      </fieldset>";
	}
	
	
	////////////////////////////////////////////////////////////////////////////
	// CATEGORIES

	/**
	 *	Draw categories additing form
	 *
	*/	
	private function DrawCategoriesAddForm()
	{
		// draw Add Event Form from template
		$content = file_get_contents($this->calDir."template/categories_add_form.tpl");
		
		$legend = "<legend class='cal_legend'>
					<strong>[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'categories_add')\">".$this->lang['add_new_category']."</a> ]</strong>
					[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'categories_management')\">".$this->lang['events_categories']."</a> ]
			  </legend>";
		
		$content = str_replace("{h:legend}", $legend, $content);		
		$content = str_replace("{h:lan_cat_name}", $this->lang['category_name'], $content);		
		$content = str_replace("{h:lan_cat_description}", $this->lang['category_description'], $content);
		$content = str_replace("{h:lan_add_category}", "+ ".$this->lang['add_category'], $content);
		$content = str_replace("{h:lan_cancel}", $this->lang['cancel'], $content);
		$content = str_replace("{h:lan_or}", $this->lang['or'], $content);
		
		if($this->arrCatOperations['allow_colors']){
			$content = str_replace("{h:lan_cat_color}", $this->lang['category_color'].":", $content);
			$content = str_replace("{h:ddl_colors}", $this->DrawColors("", true, true), $content);
		}else{
			$content = str_replace("{h:lan_cat_color}", "", $content);
			$content = str_replace("{h:ddl_colors}", "", $content);
		}
		
        if($content !== false){
			echo $content;
		}
	}	

	/**
	 *	Draw categories edit form
	 *
	*/	
	private function DrawCategoriesEditForm($category_id)
	{
		// draw Details Event Form from template
		$content = file_get_contents($this->calDir."template/categories_edit_form.tpl");

		$content = str_replace("{h:lan_edit_category}", $this->lang['edit_category'], $content);
		$content = str_replace("{h:lan_category_name}", $this->lang['category_name'], $content);		
		$content = str_replace("{h:lan_category_description}", $this->lang['category_description'], $content);
		
		$content = str_replace("{h:lan_or}", $this->lang['or'], $content);
		$content = str_replace("{h:lan_cancel}", $this->lang['cancel'], $content);
		$content = str_replace("{h:lan_update_category}", $this->lang['update_category'], $content);
		
        if($content !== false){
			$sql = "SELECT id, name, description, color
					FROM ".DB_PREFIX."events_categories
					WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$category_id;
					
			$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			if(!empty($result)){
				$content = str_replace("{h:cat_name}", $result["name"], $content);
				$content = str_replace("{h:cat_description}", $result["description"], $content);
				$content = str_replace("{h:category_id}", $result["id"], $content);

				if($this->arrCatOperations['allow_colors']){
					$content = str_replace("{h:lan_category_color}", $this->lang['category_color'].":", $content);
					$content = str_replace("{h:ddl_colors}", $this->DrawColors($result["color"], true, true), $content);
				}else{
					$content = str_replace("{h:lan_category_color}", "", $content);
					$content = str_replace("{h:ddl_colors}", "", $content);
				}
				
				echo $content;
			}
		}
	}	

	/**
	 *	Draw categories details form
	 *
	*/	
	private function DrawCategoriesDetailsForm($category_id)
	{
		// draw Details Event Form from template
		$content = file_get_contents($this->calDir."template/categories_details_form.tpl");

		$content = str_replace("{h:lan_category_name}", $this->lang['category_name'], $content);
		$content = str_replace("{h:lan_category_description}", $this->lang['category_description'], $content);
		$content = str_replace("{h:lan_category_details}", $this->lang['category_details'], $content);
		$content = str_replace("{h:lan_back}", $this->lang['back'], $content);
		
        if($content !== false){
			$sql = "SELECT id, name, description, color
					FROM ".DB_PREFIX."events_categories
					WHERE company_id = '".$_SESSION['c_id']."' AND id = ".(int)$category_id;
					
			$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
			if(!empty($result)){
				$content = str_replace("{h:category_name}", $result["name"], $content);
				$content = str_replace("{h:category_description}", $result["description"], $content);
				$content = str_replace("{h:js_back_function}", '__CategoriesBack()', $content);

				if($this->arrCatOperations['allow_colors']){
					$content = str_replace("{h:lan_cat_color}", $this->lang['category_color'].":", $content);					
					$content = str_replace("{h:ddl_colors}", $this->DrawColors($result["color"], true, false), $content);					
				}else{
					$content = str_replace("{h:lan_cat_color}", "", $content);
					$content = str_replace("{h:ddl_colors}", "", $content);
				}
				echo $content;
			}
		}
	}	

	/**
	 *	Draw events categories management
	 *
	*/	
	private function DrawEventsCategoriesManagement()
	{
		$colspan = 4;

		$sql = "SELECT COUNT(*) as cnt FROM ".DB_PREFIX."events_categories WHERE company_id = '".$_SESSION['c_id']."'";
		$result = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC);
		$total_records = $result['cnt'];
		$page_size = 20;
		$total_pages = (int)$result['cnt']/$page_size;
		$total_pages_partualy = $result['cnt'] % $page_size;
		if($total_pages_partualy != 0) $total_pages +=1;
		
		$limit_start = ($this->arrParameters["page"]-1) * $page_size;
		if($limit_start < 0) $limit_start = "0";
		$limit_end = $page_size;
		
		$sql = "SELECT id, name, description, color
				FROM ".DB_PREFIX."events_categories WHERE company_id = '".$_SESSION['c_id']."' 
				ORDER BY name ASC
				LIMIT ".$limit_start.", ".$limit_end."";
				
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
		$content = file_get_contents($this->calDir."template/categories_management_row.tpl");			   			   

		echo "<fieldset class='cal_fieldset'>";
		if($this->arrCatOperations['add'] || $this->arrCatOperations['edit']) echo "<legend class='cal_legend'>";
        if($this->arrCatOperations['add']) echo "[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'categories_add')\">".$this->lang['add_new_category']."</a> ] ";		
		if($this->arrCatOperations['edit']) echo " <strong>[ <a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'categories_management')\">".$this->lang['events_categories']."</a> ]</strong>";		
		if($this->arrCatOperations['add'] || $this->arrCatOperations['edit']) echo "</legend>";
		echo "<table align='center' border='0' width='100%'>
			  <tr><th colspan='".($colspan+1)."'></th></tr>
			  <tr>
				<th width='25px'></th>
				<th align='left' width='22%'>".$this->lang['category_name']."</th>
				<th align='left'>".$this->lang['category_description']."</th>
				<th align='left'".(($this->arrCatOperations['allow_colors']) ? " width='140px'>".$this->lang['category_color'] : " width='1px'>")."</th>
				<th align='center'".((!$this->arrCatOperations['edit'] && !$this->arrCatOperations['details'] && !$this->arrCatOperations['delete']) ? " width='1px'" : " width='140px'>".$this->lang['actions'])."</th>
			  </tr>
			  <tr><th colspan='".($colspan+1)."' nowrap='nowrap' height='2px'></th></tr>";

		$categories_count = 0;
		foreach($result[0] as $key => $val){
			$temp_content = $content;
			$categories_count++;
			
			$drawed_buttons = 0;
			$edit_button = "";
			$details_button = "";
			$delete_button = "";
			if($this->arrCatOperations['edit'])   { $edit_button    = (($drawed_buttons > 0) ? " | " : "")."<a href='javascript:__CategoriesEdit({h:category_id});'>".$this->lang['edit']."</a>"; $drawed_buttons++; }			
			if($this->arrCatOperations['details']){ $details_button = (($drawed_buttons > 0) ? " | " : "")."<a href='javascript:__CategoriesDetails({h:category_id});'>".$this->lang['details']."</a>"; $drawed_buttons++; }
			if($this->arrCatOperations['delete']) { $delete_button  = (($drawed_buttons > 0) ? " | " : "")."<a href='javascript:void(0);' onclick='javascript:__CategoriesDelete({h:category_id});'>".$this->lang['delete']."</a>"; $drawed_buttons++; }

			$temp_content = str_replace("{h:edit_button}", $edit_button, $temp_content); 
			$temp_content = str_replace("{h:details_button}", $details_button, $temp_content);
			$temp_content = str_replace("{h:delete_button}", $delete_button, $temp_content);
			
			$description = (strlen($val["description"]) > 50) ? substr($val["description"], 0, 50)."..." : $val["description"];
			$temp_content = str_replace("{h:category_id}", $val["id"], $temp_content);
			$temp_content = str_replace("{h:category_num}", $limit_start+$categories_count.". ", $temp_content);
			$temp_content = str_replace("{h:category_name}", $val["name"], $temp_content);
			$temp_content = str_replace("{h:category_description}", $description, $temp_content);
			if($this->arrCatOperations['allow_colors']){
				$temp_content = str_replace("{h:category_color}", $this->DrawColors($val["color"], true, false), $temp_content);				
			}else{
				$temp_content = str_replace("{h:category_color}", "", $temp_content);
			}
            echo $temp_content;
		}
		echo "<tr><td colspan='".($colspan+1)."' style='border-bottom:1px solid #eeeeee;'>&nbsp;</td></tr>";		
		echo "<tr>";
		if(!$this->arrCatOperations['edit'] && !$this->arrCatOperations['details'] && !$this->arrCatOperations['delete']) $colspan = 3;
		echo "<td align='left' style='padding-left:10px' colspan='".$colspan."'>".$this->lang['pages'].": ";
				for($i_pages = 1; $i_pages <= $total_pages; $i_pages++){
					if($i_pages > 1) echo ", ";
					$i_pages_a = ($i_pages == $this->arrParameters["page"]) ? "<strong>".$i_pages."</strong>" : $i_pages;
					echo "<a href=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'categories_management', '', '".$i_pages."');\">".$i_pages_a."</a>";
				}
		echo "</td>";
		echo "<td align='right' style='padding-right:10px'>".$this->lang['total_categories'].": ".$total_records."</td>";
		echo "</tr>";		
		echo "</table>
		      </fieldset>";
	}



	/**
	 *	Draw events statistics
	 *
	*/	
	private function DrawEventsStatistics()
	{	
		echo "<fieldset class='cal_fieldset' style='margin-top:20px; padding-bottom:7px;'>
			  <legend class='cal_legend bold'>".$this->lang["events_statistics"]."</legend>";
		echo "<div style='float:left;padding:7px;'>
		        ".$this->lang["select_chart_type"].": <br />
				<select onchange=\"javascript:__doPostBack('view', '".$this->arrParameters["view_type"]."', '".$this->arrParameters['year']."', '".$this->arrParameters['month']."', '".$this->arrParameters['day']."', 'events_statistics', '', '', this.value)\">
				<option value='columnchart' ".(($this->arrParameters["chart_type"] == "columnchart") ? "selected='selected'" : "").">".$this->lang["chart_column"]."</option>
				<option value='barchart' ".(($this->arrParameters["chart_type"] == "barchart") ? "selected='selected'" : "").">".$this->lang["chart_bar"]."</option>
				<option value='piechart' ".(($this->arrParameters["chart_type"] == "piechart") ? "selected='selected'" : "").">".$this->lang["chart_pie"]."</option>
		        </select></div>";
		echo "<div id='div_visualization' style='float:right; width:".(intval($this->calWidth)*0.82)."px; height:310px;'><img src='".$this->calDir."style/".$this->cssStyle."/images/loading.gif' style='margin:100px auto;' alt='loading...'></div>";
		echo "</fieldset>";
	}

	/**
	 *	Draw calendar types changer
	 *  	@param $draw - draw or return
	*/	
	private function DrawTypesChanger($draw = true)
	{
		$output = "";
		$options = "";
		foreach($this->arrViewTypes as $key => $val){
			if($val['enabled'] == true){
				$options .= "<option value='".$key."'".(($this->arrParameters['view_type'] == $key) ? " selected='selected'" : "").">".$val['name']."</option>";
			}			
		}
		if($options != ""){
			$output = "<select class='form_select' name='view_type' id='view_type' onchange=\"javascript:__doPostBack('view', this.value)\">";
			$output .= $options;
			$output .= "</select>";
		}
		
		if($draw){
			echo $output;
		}else{
			return $output;
		}
	}

	/**
	 *	Draw today jumper
	 *  	@param $draw - draw or return
	*/	
	private function DrawTodayJumper($draw = true)
	{
		$result = "<input class='form_button' type='button' value='".$this->lang["today"]."' onclick=\"javascript:__JumpTodayDate()\" />";
		if($draw){
			echo $result;
		}else{
			return $result;
		}
	}
	
	/**
	 *	Draw date jumper
	 *  	@param $draw - draw or return
	*/	
	private function DrawDateJumper($draw = true, $draw_day = true, $draw_month = true, $draw_year = true)
	{
		
		$result = "";
		
		// draw days ddl
		if($draw_day){
			$result = "<select class='form_select' name='jump_day' id='jump_day'>";
			for($i=1; $i <= 31; $i++){
				$i_converted = $this->ConvertToDecimal($i);
				$result .= "<option value='".$i_converted."'".(($this->arrParameters["day"] == $i_converted) ? " selected='selected'" : "").">".$i_converted."</option>";
			}
			$result .= "</select> ";			
		}else{
			$result .= "<input type='hidden' name='jump_day' id='jump_day' value='".$this->arrToday["mday"]."' />";			
		}

		// draw months ddl
		if($draw_month){			
			$result .= "<select class='form_select' name='jump_month' id='jump_month' onchange='javascript:__refillDaysInMonth(\"jump_\")'>";
			for($i=1; $i <= 12; $i++){
				$i_converted = $this->ConvertToDecimal($i);
				$result .= "<option value='".$i_converted."'".(($this->arrParameters["month"] == $i_converted) ? " selected='selected'" : "").">".$this->arrMonths[$i]."</option>";
			}
			$result .= "</select> ";			
		}else{
			$result .= "<input type='hidden' name='jump_month' id='jump_month' value='".$this->ConvertToDecimal($this->arrToday["mon"])."' />";			
		}

		// draw years ddl
		if($draw_year){			
			$result .= "<select class='form_select' name='jump_year' id='jump_year' ".(($draw_month) ? "onchange='javascript:__refillDaysInMonth(\"jump_\")'" : "").">";
			for($i=$this->arrParameters["year"]-10; $i <= $this->arrParameters["year"]+10; $i++){
				$result .= "<option value='".$i."'".(($this->arrParameters["year"] == $i) ? " selected='selected'" : "").">".$i."</option>";
			}
			$result .= "</select> ";
		}else{
			$result .= "<input type='hidden' name='jump_year' id='jump_year' value='".$this->arrToday["year"]."' />";			
		}
		
		$result .= "<input class='form_button' type='button' value='".$this->lang["go"]."' onclick='javascript:__JumpToDate()' />";
		
		if($draw_month){
			$this->arrInitJsFunction[] = "__refillDaysInMonth('jump_');";	
		}		

		if($draw){
			echo $result;
		}else{
			return $result;
		}
	}

	/**
	 *	Draw categories dropdown list
	 *  	@param $draw - draw or return
	 *  	@param $selected_item - selected option
	*/	
	private function DrawCategoriesDDL($selected_item = "")
	{		
		// draw Add Event Form from template
		$sql = "SELECT id, name, description, color
				FROM ".DB_PREFIX."events_categories WHERE company_id = '".$_SESSION['c_id']."'  
				ORDER BY name ASC
				LIMIT 0, 1000";
				
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);

		$output = "<select id='sel_category_name' name='sel_category_name' style='width:140px;'>";
        $output .= "<option value=''>-- ".$this->lang['select']." --</option>";            
		foreach($result[0] as $key => $val){
			$selected = ($selected_item == $val["id"]) ? " selected='selected'" : "";
			$output .= "<option value='".$val["id"]."'".$selected.">".$val["name"]."</option>";
		}
		$output .= "</select>";            
		
		return $output;
	}

	/**
	 *	Draw events dropdown list
	 *  	@param $draw - draw or return
	 *  	@param $selected_item - selected option
	*/	
	private function DrawEventsDDL($selected_item = "", $on_js_event = "")
	{		
		// draw Add Event Form from template
		$sql = "SELECT
					e.id,
					e.category_id,
					e.name,
					e.description,
					ec.name as category_name
				FROM ".DB_PREFIX."events e
					LEFT OUTER JOIN ".DB_PREFIX."events_categories ec ON e.category_id = ec.id
				WHERE e.company_id = '".$_SESSION['c_id']."' 	
				ORDER BY ec.id ASC
				LIMIT 0, 1000";
				
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);

		$output = "<select id='sel_event_name' name='sel_event_name' ".$on_js_event.">";
        $output .= "<option value=''>-- ".$this->lang['select_event']." --</option>";
		$cur_category = "";
		foreach($result[0] as $key => $val){
			if($this->arrCatOperations['manage'] && ($cur_category != $val["category_id"])){
				if($cur_category != "") $output .= "</optgroup>";
				$output .= "<optgroup label='".(($val['category_name']) ? $val['category_name'] : $this->lang['undefined']." *")."'>";
				$cur_category = $val['category_id'];
			}
			
			$selected = ($selected_item == $val["id"]) ? " selected='selected'" : "";
			$output .= "<option value='".$val["id"]."'".$selected.">".$val["name"]."</option>";
		}
		$output .= "</select>";            
		
		return $output;
	}

	/**
	 *	Draw datetime calendar
	 *  	@param $draw - draw or return
	 *  	@param $type - from|to
	*/	
	private function DrawDateTime($type = "from", $year = "", $month = "", $day = "", $hour = "", $draw = true, $disabled = false)
	{		
		$result = "";
		$disabled = ($disabled) ? " disabled='disabled'" : "";
		
		// draw days ddl
		$result = "<select class='form_select' name='event_".$type."_day' id='event_".$type."_day'".$disabled.">";
		for($i=1; $i <= 31; $i++){
			$i_converted = $this->ConvertToDecimal($i);
			$result .= "<option value='".$i_converted."'".(($day == $i_converted) ? " selected='selected'" : "").">".$i_converted."</option>";
		}
		$result .= "</select> ";			

		// draw months ddl
		$result .= "<select class='form_select' onchange='javascript:__refillDaysInMonth(\"event_".$type."_\")' name='event_".$type."_month' id='event_".$type."_month'".$disabled.">";
		for($i=1; $i <= 12; $i++){
			$i_converted = $this->ConvertToDecimal($i);
			$result .= "<option value='".$i_converted."'".(($month == $i_converted) ? " selected='selected'" : "").">".$this->arrMonths[$i]."</option>";
		}
		$result .= "</select> ";			

		// draw years ddl
		$result .= "<select class='form_select' onchange='javascript:__refillDaysInMonth(\"event_".$type."_\")' name='event_".$type."_year' id='event_".$type."_year'".$disabled.">";
		for($i=$year-10; $i <= $year+10; $i++){
			$result .= "<option value='".$i."'".(($year == $i) ? " selected='selected'" : "").">".$i."</option>";
		}
		$result .= "</select> ";		
		
		// draw hours ddl
		$result .= "<select class='form_select' name='event_".$type."_hour' id='event_".$type."_hour'".$disabled.">";
		if($this->timeBlock == "15"){
			for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){				
				for($i_block=0; $i_block<4; $i_block++){
					$result .= $this->PrepareOption($hour, $i_hour, $i_block);
				}
			}
			if($type == "to") $result .= $this->PrepareOption($hour, $i_hour, $i_block);
		}else if($this->timeBlock == "30"){
			for($i_hour=$this->fromHour; $i_hour<$this->toHour; $i_hour++){
				for($i_block=0; $i_block<2; $i_block++){
					$result .= $this->PrepareOption($hour, $i_hour, $i_block);
				}
			}
			if($type == "to") $result .= $this->PrepareOption($hour, $i_hour, $i_block);
		}else{
			for($i_hour=$this->fromHour; $i_hour < $this->toHour; $i_hour++){
				$result .= $this->PrepareOption($hour, $i_hour);
			}
			if($type == "to") $result .= $this->PrepareOption($hour, $i_hour);
		}
		$result .= "</select> ";			

		$this->arrInitJsFunction[] = "__refillDaysInMonth('event_".$type."_');";

		if($draw){
			echo $result;
		}else{
			return $result;
		}
	}
	
	/**
	 *	Delete all cache files
	*/	
	function DeleteCache(){
		if ($hdl = opendir($this->cacheDir)){
			while (false !== ($obj = @readdir($hdl))){
				if($obj == '.' || $obj == '..'){ 
					continue; 
				}
				@unlink($this->cacheDir.$obj);
			}
		}
	}
	
	/**
	 *	Save http request vars
	*/	
	function SaveHttpRequestVars($http_request_vars = array()){
		$this->httpRequestVars = $http_request_vars;
	}


	/**
	 *	Draw colors dropdown box
	 *  	@param $color - selected
	 *  	@param $return - draw or return
	*/	
	private function DrawColors($color = "", $return = false, $draw_ddl = true)
	{		
		$output = "";
	
		// draw colors ddl
		$arr_colors = self::GetColorsByName();
		$output = "<table align='left' border='0' cellpadding='0' cellspacing='0'><tr>";
		if($draw_ddl){
			$output .= "<td align='left' valign='middle' style='padding-right:5px'>";
			$output .= "<select class='form_select' name='category_color' id='category_color' onChange='javascript:__ChangeColor(\"colorBox\", this.value);'>";
			$output .= "<option value=''>-- ".$this->lang['default']." --</option>";
			foreach($arr_colors as $key => $val){
				$output .= "<optgroup label='".$key."'>";				
				foreach($val as $v_key => $v_val){
					$selected = "";
					if($color == $v_key){
						$selected = " selected='selected'";
					}
					$output .= "<option value='".$v_key."'".$selected.">".$v_val."</option>";				
				}
				$output .= "</optgroup>";
			}			
			$output .= "</select> ";
			$output .= "</td>";
		}
		if(!$draw_ddl) $width = $height = "13px";
		else $width = $height = "17px";
		$output .= "<td align='left' valign='top'>";
		$output .= "<div id='colorBox' style='border:1px solid #cecece;width:".$width.";height:".$height.";background-color:".$color.";layer-background-color:".$color.";'></div>";
		$output .= "</td>";
		
		if(!$draw_ddl){
			$output .= "<td align='left' valign='middle' style='padding-left:5px'>";
			$output .= self::GetColorNameByValue($color);
			$output .= "</td>";
		}

		$output .= "</tr></table>";
		
		if($return) return $output;
		else echo $output;
	}
	
	/**
	 *	Get colors by name
	*/
	static private function GetColorsByName()
    {
		$colors = array(
			"Reds" => array(
				"#CD5C5C" => "Indian Red",
				"#F08080" => "Light Coral",
				"#FA8072" => "Salmon",
				"#E9967A" => "Dark Salmon",
				"#FFA07A" => "Light Salmon",
				"#DC143C" => "Crimson",
				"#FF0000" => "Red",
				"#B22222" => "Fire Brick",
				"#8B0000" => "Dark Red"		
			),
			
			"Pinks" => array(
				"#FFC0CB" => "Pink",
				"#FFB6C1" => "Light Pink",
				"#FF69B4" => "Hot Pink",
				"#FF1493" => "Deep Pink",
				"#C71585" => "Medium Violet Red",
				"#DB7093" => "Pale Violet Red"
			),

			"Oranges" => array(
				"#FFA07A" => "Light Salmon",
				"#FF7F50" => "Coral",
				"#FF6347" => "Tomato",
				"#FF4500" => "Orange Red",
				"#FF8C00" => "Dark Orange",
				"#FFA500" => "Orange"			
			),
			
			"Yellows" => array(
				"#FFD700" => "Gold",
				"#FFFF00" => "Yellow",
				"#FFFFE0" => "Light Yellow",
				"#FFFACD" => "Lemon Chiffon",
				"#FAFAD2" => "Light Goldenrod Yellow",
				"#FFEFD5" => "Papaya Whip",
				"#FFE4B5" => "Moccasin",
				"#FFDAB9" => "Peach Puff",
				"#EEE8AA" => "Pale Goldenrod",
				"#F0E68C" => "Khaki",
				"#BDB76B" => "Dark Khaki"			
			),
			
			"Purples" => array(
				"#E6E6FA" => "Lavender",
				"#D8BFD8" => "Thistle",
				"#DDA0DD" => "Plum",
				"#EE82EE" => "Violet",
				"#DA70D6" => "Orchid",
				"#FF00FF" => "Fuchsia",
				"#FF00FF" => "Magenta",
				"#BA55D3" => "Medium Orchid",
				"#9370DB" => "Medium Purple",
				"#8A2BE2" => "Blue Violet",
				"#9400D3" => "Dark Violet",
				"#9932CC" => "Dark Orchid",
				"#8B008B" => "Dark Magenta",
				"#800080" => "Purple",
				"#4B0082" => "Indigo",
				"#6A5ACD" => "Slate Blue",
				"#483D8B" => "Dark Slate Blue"			
			),
			
			"Greens" => array(			
				"#ADFF2F" => "Green Yellow",
				"#7FFF00" => "Chartreuse",
				"#7CFC00" => "Lawn Green",
				"#00FF00" => "Lime",
				"#32CD32" => "Lime Green",
				"#98FB98" => "Pale Green",
				"#90EE90" => "Light	Green",
				"#00FA9A" => "Medium Spring Green",
				"#00FF7F" => "Spring Green",
				"#3CB371" => "Medium Sea Green",
				"#2E8B57" => "Sea Green",
				"#228B22" => "Forest Green",
				"#008000" => "Green",
				"#006400" => "Dark Green",
				"#9ACD32" => "Yellow Green",
				"#6B8E23" => "Olive Drab",
				"#808000" => "Olive",
				"#556B2F" => "Dark Olive Green",
				"#66CDAA" => "Medium Aquamarine",
				"#8FBC8F" => "Dark Sea Green",
				"#20B2AA" => "Light Sea Green",
				"#008B8B" => "Dark Cyan",
				"#008080" => "Teal"
			),
			
			"Blues" => array(
				"#00FFFF" => "Aqua",
				"#00FFFF" => "Cyan",
				"#E0FFFF" => "Light Cyan",
				"#AFEEEE" => "Pale Turquoise",
				"#7FFFD4" => "Aquamarine",
				"#40E0D0" => "Turquoise",
				"#48D1CC" => "Medium Turquoise",
				"#00CED1" => "Dark Turquoise",
				"#5F9EA0" => "Cadet Blue",
				"#4682B4" => "Steel Blue",
				"#B0C4DE" => "Light Steel Blue",
				"#B0E0E6" => "Powder Blue",
				"#ADD8E6" => "Light Blue",
				"#87CEEB" => "Sky Blue",
				"#87CEFA" => "Light Sky Blue",
				"#00BFFF" => "Deep Sky Blue",
				"#1E90FF" => "Dodger Blue",
				"#6495ED" => "Cornflower Blue",
				"#7B68EE" => "Medium Slate Blue",
				"#4169E1" => "Royal Blue",
				"#0000FF" => "Blue",
				"#0000CD" => "Medium Blue",
				"#00008B" => "Dark Blue",
				"#000080" => "Navy",
				"#191970" => "Midnight Blue"			
			),			
			
			"Browns" => array(
				"#FFF8DC" => "Cornsilk",
				"#FFEBCD" => "Blanched Almond",
				"#FFE4C4" => "Bisque",
				"#FFDEAD" => "Navajo White",
				"#F5DEB3" => "Wheat",
				"#DEB887" => "Burly Wood",
				"#D2B48C" => "Tan",
				"#BC8F8F" => "Rosy Brown",
				"#F4A460" => "Sandy Brown",
				"#DAA520" => "Goldenrod",
				"#B8860B" => "Dark Goldenrod",
				"#CD853F" => "Peru",
				"#D2691E" => "Chocolate",
				"#8B4513" => "Saddle Brown",
				"#A0522D" => "Sienna",
				"#A52A2A" => "Brown",
				"#800000" => "Maroon"			
			),

			"Whites" => array(
				"#FFFFFF" => "White",
				"#FFFAFA" => "Snow",
				"#F0FFF0" => "Honeydew",
				"#F5FFFA" => "Mint Cream",
				"#F0FFFF" => "Azure",
				"#F0F8FF" => "Alice Blue",
				"#F8F8FF" => "Ghost White",
				"#F5F5F5" => "White Smoke",
				"#FFF5EE" => "Seashell",
				"#F5F5DC" => "Beige",
				"#FDF5E6" => "Old Lace",
				"#FFFAF0" => "Floral White",
				"#FFFFF0" => "Ivory",
				"#FAEBD7" => "Antique White",
				"#FAF0E6" => "Linen",
				"#FFF0F5" => "Lavender Blush",
				"#FFE4E1" => "Misty Rose"			
			),
			
			"Greys" => array(
				"#DCDCDC" => "Gainsboro",
				"#D3D3D3" => "Light Grey",
				"#C0C0C0" => "Silver",
				"#A9A9A9" => "Dark Gray",
				"#808080" => "Gray",
				"#696969" => "Dim Gray",
				"#778899" => "Light Slate Gray",
				"#708090" => "Slate Gray",
				"#2F4F4F" => "Dark Slate Gray",
				"#000000" => "Black"			
			)
		);
		return $colors;
	}	

    private static function GetColorNameByValue($color_value)
    {
		$arr_colors = self::GetColorsByName();
        foreach($arr_colors as $key => $val){
			if(is_array($val)){
				foreach($val as $v_key => $v_val){
					if($v_key == $color_value) return $v_val;
				}
			}
		}		
		return "";
	}

	////////////////////////////////////////////////////////////////////////////
	// Auxilary
	////////////////////////////////////////////////////////////////////////////
	/**
	 *	Set language
	*/	
	private function SetLanguage()
	{
        if (@file_exists($this->calDir.'languages/'.$this->langName.'.php')) {
            include_once($this->calDir.'languages/'.$this->langName.'.php');
            if(@function_exists('setLanguage')){
                $this->lang = setLanguage();
            }else{									
				if($this->isDebug) $this->arrErrors[] = "Your language interface option is turned on, but the system was failed to open correctly stream: <b>'languages/".$this->langName.".php'</b>. <br />The structure of the file is corrupted or invalid. Please check it or return the language option to default value: <b>'en'</b>!";					
			}
    	}else{
			if($this->isDebug) $this->arrErrors[] = "Your language interface option is turned on, but the system was failed to open stream: <b>'languages/".$this->langName.".php'</b>. <br />No such file or directory. Please check it or return the language option to default value: <b>'en'</b>!";					
    	}
		
		$this->arrWeekDays[0] = array("short"=>$this->lang["sun"], "long"=>$this->lang["sunday"]);
		$this->arrWeekDays[1] = array("short"=>$this->lang["mon"], "long"=>$this->lang["monday"]);
		$this->arrWeekDays[2] = array("short"=>$this->lang["tue"], "long"=>$this->lang["tuesday"]);
		$this->arrWeekDays[3] = array("short"=>$this->lang["wed"], "long"=>$this->lang["wednesday"]);
		$this->arrWeekDays[4] = array("short"=>$this->lang["thu"], "long"=>$this->lang["thursday"]);
		$this->arrWeekDays[5] = array("short"=>$this->lang["fri"], "long"=>$this->lang["friday"]);
		$this->arrWeekDays[6] = array("short"=>$this->lang["sat"], "long"=>$this->lang["saturday"]);
		
		$this->arrMonths["1"] = $this->lang["months"][1];
		$this->arrMonths["2"] = $this->lang["months"][2];
		$this->arrMonths["3"] = $this->lang["months"][3];
		$this->arrMonths["4"] = $this->lang["months"][4];
		$this->arrMonths["5"] = $this->lang["months"][5];
		$this->arrMonths["6"] = $this->lang["months"][6];
		$this->arrMonths["7"] = $this->lang["months"][7];
		$this->arrMonths["8"] = $this->lang["months"][8];
		$this->arrMonths["9"] = $this->lang["months"][9];
		$this->arrMonths["10"] = $this->lang["months"][10];
		$this->arrMonths["11"] = $this->lang["months"][11];
		$this->arrMonths["12"] = $this->lang["months"][12];

		$this->arrViewTypes["daily"]["name"]     = $this->lang["daily"];
		$this->arrViewTypes["weekly"]["name"]    = $this->lang["weekly"];
		$this->arrViewTypes["monthly"]["name"] 	 = $this->lang["monthly"];
		$this->arrViewTypes["yearly"]["name"] 	 = $this->lang["yearly"];
		$this->arrViewTypes["list_view"]["name"] = $this->lang["list_view"];
	}


	/**
	 *	Check chache files
	*/	
	private function CheckCacheFiles()
	{		
		$files_count = 0;
		$oldest_file_name = "";
		$oldest_file_time = date("Y-m-d H:i:s");
		if ($hdl = opendir($this->cacheDir)){
			while (false !== ($obj = @readdir($hdl))){
				if($obj == '.' || $obj == '..'){ 
					continue; 
				}
				$file_time = date("Y-m-d H:i:s", filectime($this->cacheDir.$obj));
				if($file_time < $oldest_file_time){
					$oldest_file_time = $file_time;
					$oldest_file_name = $this->cacheDir.$obj;
				}				
				$files_count++;
			}
		}		
		if($files_count > $this->maxCacheFiles){
			@unlink($oldest_file_name);		
		}
	}

	/**
	 *	Start Caching of page
	 *  	@param $cachefile - name of file to be cached
	*/	
	private function StartCaching($cachefile)
	{
        if($cachefile != "" && file_exists($cachefile)) {        
            // minutes - how many time save the cache
            $cachetime = (int)$this->cacheLifetime * 60;     
            // Serve from the cache if it is younger than $cachetime
            if (file_exists($cachefile) && (filesize($cachefile) > 0) && ((time() - $cachetime) < filemtime($cachefile))){
                // the page has been cached from an earlier request
                // output the contents of the cache file
                include_once($cachefile); 
                echo "<!-- Generated from cache at ".date('H:i', filemtime($cachefile))." -->".$this->crLt;
                return true;
            }        
        }
        // start the output buffer
        ob_start();
	}
	
	/**
	 *	Finish Caching of page
	 *  	@param $cachefile - name of file to be cached
	*/	
	private function FinishCaching($cachefile)
	{
		if($cachefile != ""){
			// open the cache file for writing
			$fp = fopen($cachefile, 'w'); 
			// save the contents of output buffer to the file
			fwrite($fp, ob_get_contents());
			// close the file
			fclose($fp); 
			// Send the output to the browser
			ob_end_flush();
			// check if we exeeded max number of cache files
			$this->CheckCacheFiles();
		}
	}

	/**
	 *	Returns list of events for week day for certain hour
	 *  	@param $events - array of events
	*/	
	private function GetEventsListForWeekDay($events = array())
	{
		$output = "";
		$events_count = count($events);

		if($this->eventsDisplayType['weekly'] == "tooltip"){
			if($events_count > 0){
				$output .= "<div class='events_list_tooltip' style='width:".$this->weekColWidth.";' onmouseover=\"return overlib('";	
				foreach($events as $key => $cal){
					$output .= "&#8226; <label ".(($this->arrCatOperations['allow_colors']) ? "style=color:".$cal['color'] : "").">".$cal['name']."</label><br>";
				}
				$output .= "');\" onmouseout='return nd();'>".$this->lang["view"]." (".$events_count.") &raquo;</div>";				
			}
		}else{
			foreach($events as $key => $cal){
				$cal_name = (strlen($cal['name']) > 10) ? substr($cal['name'], 0, 10)."..." : $cal['name'];
				$output .= "<span class='event_wrapper' title='".$cal['description']."' style='".(($this->arrCatOperations['allow_colors']) ? "color:".$cal['color'].";" : "")."width:".$this->weekColWidth.";'>";
				$output .= "&#8226;<img onclick=\"__DeleteEvent('".$cal['id']."');\" title='".$this->lang["click_to_delete"]."' src='".$this->calDir."style/".$this->cssStyle."/images/delete.gif' alt='' /><label>".$cal_name."</label>";
				$output .= "</span>";
			}
		}
		return $output;
	}	

	/**
	 *	Returns list of events for certain hour
	 *  	@param $events - array of events
	*/	
	private function GetEventsListForHour($events = array(), $max_length = "")
	{
		$output = "";
		foreach($events as $key => $cal){
			if($output != "") $output .= ", ";
			$output .= "<span title='".$cal['description']."' ".(($this->arrCatOperations['allow_colors']) ? "style='color:".$cal['color']."'" : "").">".$cal['name']."</span>";
			if($max_length == "" && $this->arrEventsOperations['delete']){
				$output .= " <a href='javascript:void(0);' onclick=\"javascript:__DeleteEvent('".$cal['id']."');\" title='".$this->lang['click_to_delete']."'><img src='".$this->calDir."style/".$this->cssStyle."/images/delete.gif' title='".$this->lang["click_to_delete"]."' style='border:0px;vertical-align:middle;' alt='' /></a>";
			}
		}
		if($max_length != "" && strlen($output) > $max_length){
			$output = "<label title='".$output."' style='cursor:help;'>".substr($output, 0, $max_length)."...</label>";
		}
		return $output;
	}	
				
	/**
	 *	Returns count of events for the certain day
	 *  	@param $event_date - day of events
	*/	
	private function GetEventCountForDay($event_date = "")
	{
		// prepare events for this day of week
		$sql = "SELECT
					".DB_PREFIX."calendar.event_date,
					".DB_PREFIX."calendar.event_time,
					DATE_FORMAT(".DB_PREFIX."calendar.event_time, '%H') as event_time_formatted,
					".DB_PREFIX."events.name,
					".DB_PREFIX."events.description
				FROM ".DB_PREFIX."calendar
					INNER JOIN ".DB_PREFIX."events ON ".DB_PREFIX."calendar.event_id = ".DB_PREFIX."events.id
				WHERE ".DB_PREFIX."calendar.company_id = '".$_SESSION['c_id']."' AND 
					".DB_PREFIX."calendar.event_date = ".$event_date."					
					".$this->PrepareWhereClauseEventTime()."
				GROUP BY ".DB_PREFIX."events.id"; //".(($this->userID) ? " AND ".DB_PREFIX."calendar.user_id = ".(int)$this->userID : "")."
		$result = database_query($sql, ROWS_ONLY);
		if($this->isDebug) $this->arrSQLs[] =  $sql."<br /><br />";
		return $result;
	}

	/**
	 *	Returns count of events for the certain month
	 *  	@param $event_year - $year of events
	 *  	@param $event_month - $month of events
	*/	
	private function GetEventsCountForMonth($event_year = "", $event_month = "")
	{
		// prepare events for this day of week
		$sql = "SELECT
					GROUP_CONCAT(DISTINCT ".DB_PREFIX."events.id ORDER BY ".DB_PREFIX."events.id ASC SEPARATOR '$') as cnt,
					".DB_PREFIX."calendar.event_date,
					SUBSTRING(".DB_PREFIX."calendar.event_date, 9, 2) as day
				FROM ".DB_PREFIX."calendar
					INNER JOIN ".DB_PREFIX."events ON ".DB_PREFIX."calendar.event_id = ".DB_PREFIX."events.id
				WHERE
					SUBSTRING(".DB_PREFIX."calendar.event_date, 1, 4) =  '".$event_year."' AND 
					SUBSTRING(".DB_PREFIX."calendar.event_date, 6, 2) =  '".$event_month."'
					AND ".DB_PREFIX."calendar.company_id = '".$_SESSION['c_id']."'".$this->PrepareWhereClauseEventTime()."					
				GROUP BY
					SUBSTRING(".DB_PREFIX."calendar.event_date, 9, 2)";
					
				/*".(($this->userID) ? " AND ".DB_PREFIX."calendar.user_id = ".(int)$this->userID : "")."
					*/
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
		if($this->isDebug) $this->arrSQLs[] = $sql."<br /><br />";

		$arrEventsCount = array(
			"01"=>0, "02"=>0, "03"=>0, "04"=>0, "05"=>0, "06"=>0, "07"=>0, "08"=>0, "09"=>0, "10"=>0, "11"=>0, "12"=>0, "13"=>0, "14"=>0, "15"=>0,
			"16"=>0, "17"=>0, "18"=>0, "19"=>0, "20"=>0, "21"=>0, "22"=>0, "23"=>0, "24"=>0, "25"=>0, "26"=>0, "27"=>0, "28"=>0, "29"=>0, "30"=>0, "31"=>0);
			 
		foreach($result[0] as $key => $val){
			$cnt_array = explode("$", $val['cnt']);
			$arrEventsCount[$val['day']] = count($cnt_array);
		}		
		return $arrEventsCount;
	}

	/**
	 *	Returns list of events for the certain month
	 *  	@param $event_year - $year of events
	 *  	@param $event_month - $month of events
	*/	
	private function GetEventsListForMonth($event_year = "", $event_month = "", $show_id = false)
	{
		// prepare events for this day of week
		$sql = "SELECT ";
		if($this->arrParameters["view_type"] == "monthly" && $this->eventsDisplayType["monthly"] == "tooltip"){
			if($this->arrCatOperations['allow_colors']) $span_color = "<span style=color:', ".DB_PREFIX."events_categories.color, ';>";
			else $span_color = "";
			$sql .= "GROUP_CONCAT(CONCAT('".$span_color."', ".DB_PREFIX."events.name, '</span>') ORDER BY ".DB_PREFIX."calendar.event_time ASC SEPARATOR '$') as cnt, ";
		}else{
			if($this->arrCatOperations['allow_colors']) $span_color = "style=\"color:', IF(".DB_PREFIX."events_categories.color IS NOT NULL, ".DB_PREFIX."events_categories.color, \"#000000\"), ';\"";
			else $span_color = "";
			if($show_id){
				$sql .= "GROUP_CONCAT(CONCAT('<a href=\"javascript:__EventsDetails(', ".DB_PREFIX."events.id, ')\" title=\"', ".DB_PREFIX."events.description, '\">', TIME_FORMAT(".DB_PREFIX."calendar.event_time, '".$this->timeFormatSQL."'), ' - ', ".DB_PREFIX."events.name, '</a>') ORDER BY ".DB_PREFIX."calendar.event_time ASC SEPARATOR '$') as cnt, ";
			}else{
				$sql .= "GROUP_CONCAT(CONCAT('<span class=\"event_descr\" title=\"', ".DB_PREFIX."events.description, '\" ".$span_color.">', ".DB_PREFIX."events.name, '</span>') ORDER BY ".DB_PREFIX."calendar.event_time ASC SEPARATOR '$') as cnt, ";				
			}
		}
		$sql .= "".DB_PREFIX."calendar.event_date,
					SUBSTRING(".DB_PREFIX."calendar.event_date, 9, 2) as day
				FROM ".DB_PREFIX."calendar
					INNER JOIN ".DB_PREFIX."events ON ".DB_PREFIX."calendar.event_id = ".DB_PREFIX."events.id
					LEFT OUTER JOIN ".DB_PREFIX."events_categories ON ".DB_PREFIX."events.category_id = ".DB_PREFIX."events_categories.id
				WHERE
					SUBSTRING(".DB_PREFIX."calendar.event_date, 1, 4) =  '".$event_year."' AND 
					SUBSTRING(".DB_PREFIX."calendar.event_date, 6, 2) =  '".$event_month."'					
					".$this->PrepareWhereClauseEventTime()."
					".$this->PrepareWhereFromToTime()."
				GROUP BY
					SUBSTRING(".DB_PREFIX."calendar.event_date, 9, 2)
				";
				//".(($this->userID) ? " AND ".DB_PREFIX."calendar.user_id = ".(int)$this->userID : "")."
		$result = database_query($sql, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
		if($this->isDebug) $this->arrSQLs[] = htmlentities($sql)."<br /><br />";
		
		$arrEventsList = array(
			"01"=>0, "02"=>0, "03"=>0, "04"=>0, "05"=>0, "06"=>0, "07"=>0, "08"=>0, "09"=>0, "10"=>0, "11"=>0, "12"=>0, "13"=>0, "14"=>0, "15"=>0,
			"16"=>0, "17"=>0, "18"=>0, "19"=>0, "20"=>0, "21"=>0, "22"=>0, "23"=>0, "24"=>0, "25"=>0, "26"=>0, "27"=>0, "28"=>0, "29"=>0, "30"=>0, "31"=>0);
			 
		foreach($result[0] as $key => $val){
			$cnt_array = explode("$", $val['cnt']);
			$arrEventsList[$val['day']] = $cnt_array;
		}

		return $arrEventsList;
	}
	
	/**
	 *	Returns list of events for the certain month's day
	 *  	@param $events - array of month's events
	 *  	@param $actday - day of month
	*/	
	function GetMonthlyDayEvents($events = array(), $actday, $total = "")
	{
		$events_list = "";
		$events_count = 0;
		// display events
		
		if(isset($events[$this->ConvertToDecimal($actday)]) && is_array($events[$this->ConvertToDecimal($actday)])){			
			if($this->arrParameters["view_type"] == "monthly" && $this->eventsDisplayType["monthly"] == "tooltip"){
				//in check [#001 17.03.2010] $arrEvents = explode("$", $events[$this->ConvertToDecimal($actday)][0]);
				$arrEvents = $events[$this->ConvertToDecimal($actday)];
				$events_list .= "<div class='events_list_tooltip' onmouseover=\"return overlib('";	
				foreach($arrEvents as $event){
					$events_list .= "&#8226; ".$event."<br />";
					if($total != "" && ++$events_count >= $total) break;
				}
				$events_list .= "');\" onmouseout='return nd();'>".$this->lang["view_events"]." &raquo;</div>";
			}else{ // inline
				$events_list .= "<div class='events_list_inline'>";	
				foreach($events[$this->ConvertToDecimal($actday)] as $event){
					$events_list .= "&#8226; ".$event."<br />";
					if($total != "" && ++$events_count >= $total) break;
				}
				/*$varYearInd = $this->arrParameters["year"];
				$varMonthInd = $this->arrParameters["month"];
				$testdayInd = $varYearInd."-".$varMonthInd."-".$this->ConvertToDecimal($actday);				
				$calqrycInd = "SELECT ce.name
				FROM cal_calendar as cl 
				LEFT JOIN cal_events ce ON ce.id = cl.event_id
				WHERE cl.event_date ='".$testdayInd."' AND 
				(ce.company_id = '".$_SESSION['c_id']."' OR cl.company_id = '".$_SESSION['c_id']."')";
				
				$calqrycTotInd = database_query($calqrycInd, DATA_AND_ROWS, ALL_ROWS, FETCH_ASSOC);
				foreach($calqrycTotInd[0] as $key => $event){						
					$events_list .= "&#8226; ".$event['name']." <br />";
					if($total != "" && $events_count++ >= $total) break;
				}*/	
				$events_list .= "</div>";				
			}
			
		}		
		return $events_list;		
	}
	
	/**
	 *	Draws monthly day cell with events and scrolling
	 *  	@param $events_count - count of events
	 *  	@param $arrEventsList - list of events for this day
	 *  	@param $actday - day of month
	*/	
	function DrawMonthlyDayCell($events_count, $arrEventsList, $actday){
		if($events_count > 5){
			$cel_height = number_format(((int)$this->calHeight)/6 * 4/5, "0")."px";
			$cel_id = $this->arrParameters["month"].$this->ConvertToDecimal($actday);
			if($this->eventsDisplayType['monthly'] == "inline"){
				echo "<div style='height:".$cel_height.";overflow-y:hidden;overflow-x:hidden;' id='divDayEventContainer".$cel_id."'>";
			}
			echo $this->GetMonthlyDayEvents($arrEventsList, $actday);
			if($this->eventsDisplayType['monthly'] == "inline"){
				echo "</div>";
				echo "<a id='dayEventLinkShow".$cel_id."' style='display:' href='javascript:__toggleCellScroll(\"".$cel_id."\");'>".$this->lang['show_all']." &raquo;</a>";
				echo "<a id='dayEventLinkCollapse".$cel_id."' style='display:none;' href='javascript:__toggleCellScroll(\"".$cel_id."\");'>&laquo; ".$this->lang['close_lc']."</a>";
			}
		}else{
			echo $this->GetMonthlyDayEvents($arrEventsList, $actday);
		}
	}

	/**
	 *	Check if parameters is 4-digit year
	 *  	@param $year - string to be checked if it's 4-digit year
	*/	
	private function IsYear($year = "")
	{
		if(!strlen($year) == 4 || !is_numeric($year)) return false;
		for($i = 0; $i < 4; $i++){
			if(!(isset($year[$i]) && $year[$i] >= 0 && $year[$i] <= 9)){
				return false;	
			}
		}
		return true;
	}

	/**
	 *	Check if parameters is month
	 *  	@param $month - string to be checked if it's 2-digit month
	*/	
	private function IsMonth($month = "")
	{
		if(!strlen($month) == 2 || !is_numeric($month)) return false;
		for($i = 0; $i < 2; $i++){
			if(!(isset($month[$i]) && $month[$i] >= 0 && $month[$i] <= 9)){
				return false;	
			}
		}
		return true;
	}

	/**
	 *	Check if parameters is day
	 *  	@param $day - string to be checked if it's 2-digit day
	*/	
	private function IsDay($day = "")
	{
		if(!strlen($day) == 2 || !is_numeric($day)) return false;
		for($i = 0; $i < 2; $i++){
			if(!(isset($day[$i]) && $day[$i] >= 0 && $day[$i] <= 9)){
				return false;	
			}
		}
		return true;
	}

	/**
	 *	Prepare minutes and houres
	 *  	@param $minutes_part
	 *  	@param &$hours_part
	*/	
	private function PrepareMinutesHoures(&$minutes_part, &$hours_part)
	{
		if($minutes_part == "0" || $minutes_part == "60"){
			$minutes_part = "00";
			if($minutes_part == "60") $hours_part += 1;						
		}
	}

	/**
	 *	Convert to decimal number with leading zero
	 *  	@param $number
	*/	
	private function ConvertToDecimal($number)
	{
		return (($number < 0) ? "-" : "").((abs($number) < 10) ? "0" : "").abs($number);
	}

	/**
	 *	Convert to hour formar with leading zero
	 *  	@param $number
	*/	
	private function ConvertToHour($number, $minutes = "00", $use_format = false)
	{
		$number = (($number < 10 && strlen($number) == 1) ? "0".$number : $number);
		if($use_format){
			if($this->timeFormat == "24"){
				return $number.":".$minutes;	
			}else{
				return (($number <= 12) ? $number : ($number - 12)).":".$minutes." ".(($number < 12) ? "AM" : "PM");	
			}
		}else{
			return $number.":".$minutes;	
		}		
	}
	
	/**
	 *	Parse hour from hour format string
	 *  	@param $hour
	*/	
	private function ParseHour($hour)
	{
		$hour_array = explode(":", $hour);
		return (isset($hour_array[0]) ? $hour_array[0] : "0");
	}	

	/**
	 *	Parse minutes from hour format string
	 *  	@param $hour
	*/	
	private function ParseMinutes($hour)
	{
		$hour_array = explode(":", $hour);
		return (isset($hour_array[1]) ? $hour_array[1] : "0");
	}	

	/**
	 *	Get formatted microtime
	*/	
    private function GetFormattedMicrotime(){
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }
	
	/**
	 *	Prepare option for hours dropdown box
	*/
	function PrepareOption($hour, $i_hour, $i_block = ""){
		if($this->timeBlock == "15"){
			$hours_part = $i_hour;
			$minutes_part = ($i_block)*$this->timeBlock;					
			$this->PrepareMinutesHoures($minutes_part, $hours_part);
			$i_converted = $this->ConvertToDecimal($hours_part);
			$i_converted_hour = $this->ConvertToHour($hours_part, $minutes_part);
			$i_converted_hour_formated = $this->ConvertToHour($hours_part, $minutes_part, true);
			return "<option value='".$i_converted_hour."'".(($hour == $i_converted) ? " selected='selected'" : "").">".(($this->timeFormat == "24") ? $i_converted_hour : $i_converted_hour_formated)."</option>";
		}else if($this->timeBlock == "30"){
			$hours_part = $i_hour;
			$minutes_part = ($i_block)*$this->timeBlock;					
			$this->PrepareMinutesHoures($minutes_part, $hours_part);
			$i_converted = $this->ConvertToDecimal($hours_part);
			$i_converted_hour = $this->ConvertToHour($hours_part, $minutes_part);
			$i_converted_hour_formated = $this->ConvertToHour($hours_part, $minutes_part, true);			
			return "<option value='".$i_converted_hour."'".(($hour == $i_converted) ? " selected='selected'" : "").">".(($this->timeFormat == "24") ? $i_converted_hour : $i_converted_hour_formated)."</option>";
		}else{
			$i_converted = $this->ConvertToDecimal($i_hour);
			$i_converted_hour = $this->ConvertToHour($i_hour);
			$i_converted_hour_formated = $this->ConvertToHour($i_hour, "00", true);
			return "<option value='".$i_converted_hour."'".(($hour == $i_converted) ? " selected='selected'" : "").">".(($this->timeFormat == "24") ? $i_converted_hour : $i_converted_hour_formated)."</option>";			
		}	
	}

	/**
	 *	Prepare text for SQL
	*/
	function PrepareText($str){
		$str = str_replace("'", "\'", $str);
		return $str;
	}
	
	/**
	 *	Prepare text for HTML
	*/
	function PrepareFormatedText($str){
		$str = str_replace("'", "&#039;", $str);
		return $str;
	}
	
	/**
	 *	Prepare Event Type where clause for SELECT SQL 
	*/
	function PrepareWhereClauseEventTime(){
		$output = "";
		if($this->timeBlock == "60"){
			$output = " AND SUBSTRING(".DB_PREFIX."calendar.event_time, 4, 2) = '00' ";
		}else if($this->timeBlock == "30"){
			$output = " AND (SUBSTRING(".DB_PREFIX."calendar.event_time, 4, 2) = '00' OR SUBSTRING(".DB_PREFIX."calendar.event_time, 4, 2) = '30') ";
		}else{
			// 15 min. - all variations
		}
		return $output;
	}
	
	/**
	 *	Prepare From-To where clause for SELECT SQL 
	*/
	function PrepareWhereFromToTime(){
		$output = "";
		if($this->fromHour != "0") $output .= " AND SUBSTRING(".DB_PREFIX."calendar.event_time, 1, 2) >= '".$this->ConvertToDecimal($this->fromHour)."' ";
		if($this->toHour != "0") $output .= " AND SUBSTRING(".DB_PREFIX."calendar.event_time, 1, 2) < '".$this->ConvertToDecimal($this->toHour)."' ";	
		return $output;
	}

	/**
	 *	Insert Events Occurrences
	*/
	function InsertEventsOccurrences($insert_id, $start_date, $finish_date, $event_from_hour, $event_from_day, $event_from_month, $event_from_year, $check_if_exists = true){
		$current_date = $start_date;
		$start_hour = $this->ParseHour($event_from_hour);
		$start_minutes = $this->ParseMinutes($event_from_hour); //user_id = ".(int)$this->userID." AND
		$sql_check = "SELECT id FROM ".DB_PREFIX."calendar WHERE company_id = '".$_SESSION['c_id']."' AND event_id = ".(int)$insert_id." AND (";
		$sql = "INSERT INTO ".DB_PREFIX."calendar (id, event_id, event_date, event_time,company_id,usertype_id,user_id) VALUES ";				
		$offset = 0;
		$can_add = true;
		$convToHour = $this->ConvertToHour($this->toHour);
		$convFromHour = $this->ConvertToHour($this->fromHour);
		$sql_check_inner = "";
		while($current_date < $finish_date){
			$current = getdate(mktime($start_hour,$start_minutes+$offset,0,$event_from_month,$event_from_day,$event_from_year));
			$curr_date = $current['year']."-".$this->ConvertToDecimal($current['mon'])."-".$this->ConvertToDecimal($current['mday']);
			$curr_time = $this->ConvertToDecimal($current['hours']).":".$this->ConvertToDecimal($current['minutes']);
			$current_date = $curr_date." ".$curr_time;					
			if(!$this->allowEditingEventsInPast && ($current_date < date("Y-m-d H:i:s"))){						
				$can_add = false;
			}					
			if($current_date < $finish_date && ($curr_time < $convToHour) && ($curr_time >= $convFromHour)){
				if($offset > 0) $sql .= ", ";
				$sql .= "(NULL, ".(int)$insert_id.", '".$curr_date."', '".$curr_time."','".$_SESSION['c_id']."','".$_SESSION['USERTYPE_ID']."','".$_SESSION['c_id']."')";
				if($offset > 0) $sql_check_inner .= " OR ";
				$sql_check_inner .= "(event_date = '".$curr_date."' AND event_time = '".$curr_time."')";
			}											
			$offset += $this->timeBlock;
		}
		$sql_check .= (($sql_check_inner != "") ? $sql_check_inner : "1=1").")";
		if(!$can_add){
			$this->arrMessages[] = $this->GetMessage("error", $this->lang['msg_editing_event_in_past']);		
		}else{
			// check if such event occurrences already exist
			if($this->isDebug) $this->arrSQLs[] = $sql_check."<br /><br />";					
			if($check_if_exists && database_query($sql_check, ROWS_ONLY, FIRST_ROW_ONLY, FETCH_ASSOC) > 0){
				$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_duplicate_event_inserting']);		
			}else{
				// add event occurrences to calendar
				if($this->isDebug) $this->arrSQLs[] = $sql."<br /><br />";
				if(!database_void_query($sql)){
					$this->arrMessages[] = $this->GetMessage("error", $this->lang['error_inserting_new_events']);		
				}else{
					return true;
					$this->DeleteCache();					
				}
			}				
		}
		return false;
	}

	/**
	 *	Get max day for month
	 *	  	@param $month - month
	 *  	@param $day - day
	 **/
	function GetDayForMonth($month = "", $day = ""){
		if($day < 29){
			return $day;
		}else if($day == 29){			
			if((int)$month == 2){
				return 28;
			}else{
				return 29;
			}			
		}else if($day == 30){
			if((int)$month != 2){
				return 30;
			}else{
				return 28;
			}
		}else if($day == 31){
			if((int)$month == 2){
				return 28;
			}else if((int)$month == 4 || (int)$month == 6 || (int)$month == 9 || (int)$month == 11){
				return 30;
			}else{
				return 31;
			}			
		}else{
			return 30;	
		}		
	}

	/**
	 *	Draws messages
	 *	  	@param $type - message type
	 *  	@param $message - message text
	 *      @param $draw
	 **/
	function GetMessage($type, $message, $return=true)
	{
		if (!empty($message)) $message = "<div class='message_box_".$type."'><div class='message_content'>".$message."</div></div>";
		if($return) return $message;
		else echo $message;	
	}

	/**
	 *	Get query string parameter value
	 *	  	@param $var - parameter
	 *	  	@param $default_value
	 *  	@param $method - method
	*/
    private function GetParameter($var = '', $default_value = '', $method = 'request')
	{
		$output = '';
        switch($method){
            case 'get':
                $output = isset($_GET[$var]) ? $_GET[$var] : $default_value;                                
                break;
            case 'post':
                $output = isset($_POST[$var]) ? $_POST[$var] : $default_value;                                
                break;
            default:
                $output = isset($_REQUEST[$var]) ? $_REQUEST[$var] : $default_value;                                
                break;
        }
		if($output == '' && $default_value != '') $output = $default_value;
		if(!$this->CheckInput($output)) $output = '';
		return $output;
    }
	
	/**
	 *	Check input for bad characters
	 *      @param $input
	*/
	private function CheckInput($input)
	{		
		if($input == '') return true;
		
		$error = 0;
		// removed - because WYSIWYG makes problems in FF
		// '<img', 
		$bad_string = array('%20union%20', '/*', '*/union/*', '+union+', 'load_file', 'outfile', 'document.cookie', 'onmouse', '%3Cscrip', 'javascript:', '<script', 'script>', 'expression(', '<frame', '<iframe', '<applet', '<meta', '<style', '<form', '<body', '<link', '_GLOBALS', '_REQUEST', '_GET', '_POST', 'include_path', 'prefix', 'https://', 'ftp://', 'smb://');
		foreach($bad_string as $string_value){
			if(strstr($input, $string_value)) $error = 1;
		}
			
		// removed - because WYSIWYG makes problems in FF
		// (preg_match('/<[^>]*style*\"?[^>]*>/i', $input)) ||
		// (preg_match('/<[^>]*img*\"?[^>]*>/i', $input)) ||
		// (preg_match('/http:\/\//i', $input)) )
		if((preg_match('/<[^>]*script*\"?[^>]*>/i', $input)) ||
			(preg_match('/<[^>]*object*\"?[^>]*>/i', $input)) ||
			(preg_match('/<[^>]*iframe*\"?[^>]*>/i', $input)) ||
			(preg_match('/<[^>]*applet*\"?[^>]*>/i', $input)) ||
			(preg_match('/<[^>]*meta*\"?[^>]*>/i', $input)) ||			
			(preg_match('/<[^>]*form*\"?[^>]*>/i', $input)) ||			
			(preg_match('/<[^>]*onmouseover*\"?[^>]*>/i', $input)) ||
			(preg_match('/<[^>]*body*\"?[^>]*>/i', $input)) ||
			(preg_match('/\([^>]*\"?[^)]*\)/i', $input)) || 
			(preg_match('/ftp:\/\//i', $input)) || 
			(preg_match('/https:\/\//i', $input))
			)			
		{
			$error = 1;
		}
		
		$ss = $_SERVER['HTTP_USER_AGENT'];
		
		if((preg_match('/libwww/i',$ss)) ||
			(preg_match('/^lwp/i',$ss))  ||
			(preg_match('/^Jigsaw/i',$ss)) ||
			(preg_match('/^Wget/i',$ss)) ||
			(preg_match('/^Indy\ Library/i',$ss)) )
		{ 
			$error = 1;
		}
		
		if($error){
			return false;
		}
		return true;
	}
  
	/**
	 *	Remove bad chars from input
	 *	  	@param $str_words - input
	*/
    private function RemoveBadChars($str_words)
	{
        $found = false;
		// removed - because WYSIWYG makes problems in FF
		// '<img', 		
        $bad_string = array('select', 'drop', '--', 'insert', 'delete', 'xp_', '%20union%20', '/*', '*/union/*', '+union+', 'load_file', 'outfile', 'document.cookie', 'onmouse', '<script', 'script>', '<iframe', '<applet', '<meta', '<style', '<form', '<body', '<link', '_GLOBALS', '_REQUEST', '_GET', '_POST', 'include_path', 'prefix', 'https://', 'ftp://', 'smb://', 'onmouseover=', 'onmouseout=');
        for($i = 0; $i < count($bad_string); $i++){
            $str_words = str_ireplace($bad_string[$i], '', $str_words);
        }
        return $str_words;            
    }
    
}
