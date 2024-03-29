function __JumpTodayDate(){
   var jump_day   = GL_jump_day;
   var jump_month = GL_jump_month;
   var jump_year  = GL_jump_year;
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : GL_view_type;

   __doPostBack('view', view_type, jump_year, jump_month, jump_day);
}

function __JumpToDate(){
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';

   __doPostBack('view', view_type, jump_year, jump_month, jump_day);
}

function __doPostBack(action, view_type, year, month, day, event_action, event_id, page, chart_type, category_id)
{			
   var action     = (action != null) ? action : 'view';
   var view_type  = (view_type != null) ? view_type : 'monthly';
   var year       = (year != null) ? year : GL_today_year;
   var month      = (month != null) ? month : GL_today_mon;
   var day        = (day != null) ? day : GL_today_mday;
   var event_action = (event_action != null) ? event_action : '';
   var event_id   = (event_id != null) ? event_id : '';
   var page       = (page != null) ? page : '1';
   var chart_type = (chart_type != null) ? chart_type : 'columnchart';
   var category_id = (category_id != null) ? category_id : '';
   
   document.getElementById('hid_event_action').value = event_action;
   document.getElementById('hid_event_id').value = event_id;
   document.getElementById('hid_action').value = action;
   document.getElementById('hid_view_type').value = view_type;
   document.getElementById('hid_year').value = year;
   document.getElementById('hid_month').value = month;
   document.getElementById('hid_day').value = day;
   document.getElementById('hid_page').value = page;
   document.getElementById('hid_chart_type').value = chart_type;
   document.getElementById('hid_category_id').value = category_id;
   
   document.getElementById('frmCalendar').submit();
}

function __HideEventForm(el)
{
   document.getElementById(el).style.display = 'none';
}

function __ShowEventForm(el)
{
   document.getElementById(el).style.display = 'block';
}

function __CallAddEventForm(el, year, month, day, hour)
{			
   document.getElementById(el).style.display = 'block';
   var event_from_year  = document.getElementById('event_from_year');
   var event_to_year 	 = document.getElementById('event_to_year');				
   var event_from_month = document.getElementById('event_from_month');
   var event_to_month 	 = document.getElementById('event_to_month');				
   var event_from_day   = document.getElementById('event_from_day');
   var event_to_day 	 = document.getElementById('event_to_day');				
   var event_from_hour  = document.getElementById('event_from_hour');
   var event_to_hour 	 = document.getElementById('event_to_hour');      

   for(i = 0; i < event_from_hour.length; i++){
      if(event_from_hour.options[i].value == hour){
         event_from_hour.options[i].selected = true;
         //if(i < event_from_hour.length-1){
            event_to_hour.options[i+1].selected = true;   
         //}else{
         //   event_to_hour.options[i].selected = true;   
         //}
      }
   }

   for(i = 0; i < event_from_day.length; i++){
      if(event_from_day.options[i].value == day){
         event_from_day.options[i].selected = true;
         event_to_day.options[i].selected = true;
      }
   }

   for(i = 0; i < event_from_month.length; i++){
      if(event_from_month.options[i].value == month){
         event_from_month.options[i].selected = true;
         event_to_month.options[i].selected = true;
      }
   }
   
   for(i = 0; i < event_from_year.length; i++){
      if(event_from_year.options[i].value == year){
         event_from_year.options[i].selected = true;
         event_to_year.options[i].selected = true;
      }
   }
   
   document.getElementById('divAddEvent_msg').innerHTML = '';
   document.getElementById('event_name').value = '';
   document.getElementById('event_description').value = '';
   document.getElementById('event_name').focus();
}

/////////////////////////////////////////////////////////////////////////////   
// EVENTS

// Cancel event inserting 
function __EventsCancel(){      
   __doPostBack('view', null, null, null, null, 'events_management');
   return true;
}

// Back to events management
function __EventsBack(event_name){
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
   var event_name  = (event_name) ? event_name : 'events_management';

   __doPostBack('view', view_type, jump_year, jump_month, jump_day, event_name);
   return true;
}

// Delete event 
function __EventsDelete(eid){			
   if(confirm(Vocabulary._MSG["alert_delete_event_occurrences"])){			
      var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
      var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
      var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
  
      __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_delete', eid);
      return true;
   }
   return false;
}

// Edit event
function __EventsEdit(eid){
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';

   __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_edit', eid);
   return true;
}   

// View event details
function __EventsDetails(eid){
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';

   __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_details', eid);
   return true;
}   

// Update event
function __EventsUpdate(eid){
   var event_name = document.getElementById('event_name').value;
   var event_description = document.getElementById('event_description').value;

   if(trim(event_name) == ''){
      document.getElementById('event_name').focus();
      document.getElementById('divEventsEdit_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_event_name_empty"]+"</span>";
      return false;
   }else if(trim(event_description) == ''){
      document.getElementById('event_description').focus();
      document.getElementById('divEventsEdit_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_event_descr_empty"]+"</span>";
      return false;         
   }

   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';

   __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_update', eid);
   return true;
}   

// Add events 
function __EventsAdd(){
   var event_name = document.getElementById('event_name').value;
   var event_description = document.getElementById('event_description').value;

   var event_from_year  = document.getElementById('event_from_year');
   var event_to_year    = document.getElementById('event_to_year');
   var event_from_month = document.getElementById('event_from_month');
   var event_to_month   = document.getElementById('event_to_month');
   var event_from_day   = document.getElementById('event_from_day');
   var event_to_day 	   = document.getElementById('event_to_day');
   var event_from_hour  = document.getElementById('event_from_hour');
   var event_to_hour    = document.getElementById('event_to_hour');
   var event_insertion_type = __getCheckedValue(document.forms['frmCalendar'].event_insertion_type);

   start_datetime  = event_from_year.value+event_from_month.value+event_from_day.value+event_from_hour.value;
   finish_datetime = event_to_year.value+event_to_month.value+event_to_day.value+event_to_hour.value;

   if(trim(event_name) == ''){
      document.getElementById('event_name').focus();
      document.getElementById('divEventsAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_event_name_empty"]+"</span>";
      return false;
   }else if(trim(event_description) == ''){
      document.getElementById('event_description').focus();
      document.getElementById('divEventsAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_event_descr_empty"]+"</span>";
      return false;         
   }else if(event_insertion_type == 2 && start_datetime >= finish_datetime){
      // event_insertion_type == 2 - add occurrences
      document.getElementById('divEventsAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["msg_start_date_earlier"]+"</span>";
      return false;
   }
   
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
   
   __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_insert');
   return true;
}

// Initiation of EventsAddForm
function __InitEventsAddForm()
{			
   var event_from_hour  = document.getElementById('event_from_hour');
   var event_to_hour    = document.getElementById('event_to_hour');      

   for(i = 0; i < event_from_hour.length; i++){
      if(event_from_hour.options[i].selected == true){
         event_to_hour.options[i+1].selected = true;   
      }
   }
}

// Add single event
function __AddEvent(){			
   var event_name = document.getElementById('event_name').value;
   var sel_event_name = document.getElementById('sel_event_name').value;
   var event_description = document.getElementById('event_description').value;
   var sel_event = __getCheckedValue(document.forms['frmCalendar'].sel_event);

   var event_from_year  = document.getElementById('event_from_year');
   var event_to_year    = document.getElementById('event_to_year');
   var event_from_month = document.getElementById('event_from_month');
   var event_to_month   = document.getElementById('event_to_month');
   var event_from_day   = document.getElementById('event_from_day');
   var event_to_day 	   = document.getElementById('event_to_day');
   var event_from_hour  = document.getElementById('event_from_hour');
   var event_to_hour    = document.getElementById('event_to_hour');
   
   start_datetime  = event_from_year.value+event_from_month.value+event_from_day.value+event_from_hour.value;
   finish_datetime = event_to_year.value+event_to_month.value+event_to_day.value+event_to_hour.value;
   
   if(sel_event == 'new' && trim(event_name) == ''){
      document.getElementById('event_name').focus();
      document.getElementById('divAddEvent_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["msg_enter_event_name"]+"</span>";
      return false;
   }else	if(sel_event == 'new' && trim(event_description) == ''){
      document.getElementById('event_description').focus();
      document.getElementById('divAddEvent_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["msg_enter_event_description"]+"</span>";
      return false;
   }else	if(sel_event == 'current' && sel_event_name == ''){
      document.getElementById('divAddEvent_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["msg_event_not_selected"]+"</span>";
      return false;
   }else if(start_datetime >= finish_datetime){
      document.getElementById('divAddEvent_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["msg_start_date_earlier"]+"</span>";
      return false;
   }
   
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
   
   __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'add');
   __HideEventForm('divAddEvent');
   return true;
}

function __DeleteEvent(eid){			
   if(confirm(Vocabulary._MSG["alert_delete_event"])){			
      var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
      var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
      var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
      var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
   
      __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'delete', eid);				
   }
   return false;
}

function __EventSelectedDDL(sel_type){
   if(sel_type == 1){
      document.getElementById('sel_event_name').selectedIndex = 0;
      document.getElementById('event_name').disabled = false;
      document.getElementById('event_description').disabled = false;
   }else{
      document.getElementById('sel_event_current').checked = true;
      document.getElementById('event_name').value = '';
      document.getElementById('event_name').disabled = true;
      document.getElementById('event_description').value = '';
      document.getElementById('event_description').disabled = true;
   }
}

// Add events 
function __EventsAdd(){
   var event_name = document.getElementById('event_name').value;
   var event_description = document.getElementById('event_description').value;

   var event_from_year  = document.getElementById('event_from_year');
   var event_to_year    = document.getElementById('event_to_year');
   var event_from_month = document.getElementById('event_from_month');
   var event_to_month   = document.getElementById('event_to_month');
   var event_from_day   = document.getElementById('event_from_day');
   var event_to_day 	   = document.getElementById('event_to_day');
   var event_from_hour  = document.getElementById('event_from_hour');
   var event_to_hour    = document.getElementById('event_to_hour');
   var event_insertion_type = __getCheckedValue(document.forms['frmCalendar'].event_insertion_type);

   start_datetime  = event_from_year.value+event_from_month.value+event_from_day.value+event_from_hour.value;
   finish_datetime = event_to_year.value+event_to_month.value+event_to_day.value+event_to_hour.value;

   if(trim(event_name) == ''){
      document.getElementById('event_name').focus();
      document.getElementById('divEventsAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_event_name_empty"]+"</span>";
      return false;
   }else if(trim(event_description) == ''){
      document.getElementById('event_description').focus();
      document.getElementById('divEventsAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_event_descr_empty"]+"</span>";
      return false;         
   }else if(event_insertion_type == 2 && start_datetime >= finish_datetime){
      // event_insertion_type == 2 - add occurrences
      document.getElementById('divEventsAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["msg_start_date_earlier"]+"</span>";
      return false;
   }
   
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
   
   __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'events_insert');
   return true;
}

function __eventInsertionType(val){
   if(val == 1){
      document.getElementById("event_from_hour").disabled = true;
      document.getElementById("event_from_day").disabled = true;
      document.getElementById("event_from_month").disabled = true;
      document.getElementById("event_from_year").disabled = true;
      document.getElementById("event_to_hour").disabled = true;
      document.getElementById("event_to_day").disabled = true;
      document.getElementById("event_to_month").disabled = true;
      document.getElementById("event_to_year").disabled = true;
   }else{
      document.getElementById("event_from_hour").disabled = false;
      document.getElementById("event_from_day").disabled = false;
      document.getElementById("event_from_month").disabled = false;
      document.getElementById("event_from_year").disabled = false;
      document.getElementById("event_to_hour").disabled = false;
      document.getElementById("event_to_day").disabled = false;
      document.getElementById("event_to_month").disabled = false;
      document.getElementById("event_to_year").disabled = false;         
   }      
}

/////////////////////////////////////////////////////////////////////////////   
// CATEGORIES

// Cancel category inserting 
function __CategoriesCancel(){      
   __doPostBack('view', null, null, null, null, 'categories_management');
   return true;
}

// Back to events management
function __CategoriesBack(event_name){
   __doPostBack('view', null, null, null, null, 'categories_management');
   return true;
}

// Add new category
function __CategoriesAdd(){
   var category_name        = document.getElementById('category_name').value;
   var category_description = document.getElementById('category_description').value;

   if(trim(category_name) == ''){
      document.getElementById('category_name').focus();
      document.getElementById('divCategoriesAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_cat_name_empty"]+"</span>";
      return false;
   }else if(trim(category_description) == ''){
      document.getElementById('category_description').focus();
      document.getElementById('divCategoriesAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_cat_descr_empty"]+"</span>";
      return false;         
   }
   
   var jump_day   = (document.getElementById('jump_day')) ? document.getElementById('jump_day').value : '';
   var jump_month = (document.getElementById('jump_month')) ? document.getElementById('jump_month').value : '';
   var jump_year  = (document.getElementById('jump_year')) ? document.getElementById('jump_year').value : '';
   var view_type  = (document.getElementById('view_type')) ? document.getElementById('view_type').value : '';
   
   __doPostBack('view', view_type, jump_year, jump_month, jump_day, 'categories_insert');
   return true;
}

// View category details
function __CategoriesEdit(cid){
   __doPostBack('view', null, null, null, null, 'categories_edit', '', '', '', cid);
   return true;
}   

// Update category
function __CategoriesUpdate(cid){
   var category_name        = document.getElementById('category_name').value;
   var category_description = document.getElementById('category_description').value;

   if(trim(category_name) == ''){
      document.getElementById('category_name').focus();
      document.getElementById('divCategoriesAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_cat_name_empty"]+"</span>";
      return false;
   }else if(trim(category_description) == ''){
      document.getElementById('category_description').focus();
      document.getElementById('divCategoriesAdd_msg').innerHTML = "<span class='msg_error'>"+Vocabulary._MSG["err_cat_descr_empty"]+"</span>";
      return false;
   }

   __doPostBack('view', false, false, false, false, 'categories_update', '', '', '', cid);
   return true;
}   

// View category details
function __CategoriesDetails(cid){
   __doPostBack('view', null, null, null, null, 'categories_details', '', '', '', cid);
   return true;
}

// Delete category
function __CategoriesDelete(cid){
   if(confirm(Vocabulary._MSG["alert_delete_category"])){			     
      __doPostBack('view', null, null, null, null, 'categories_delete', '', '', '', cid);
      return true;
   }
   return false;      
}

// Change color
function __ChangeColor(el, color){
   if(document.getElementById(el)){
      document.getElementById(el).style.backgroundColor = color;      
   }
   return true;
}


/////////////////////////////////////////////////////////////////////////////
// AUXILIARY
   
function __getCheckedValue(el) {
   if(!el) return "";
   var radioLength = el.length;
   if(radioLength == undefined)
     if(el.checked)
         return el.value;
     else
         return "";
   for(var i = 0; i < radioLength; i++) {
     if(el[i].checked) {
         return el[i].value;
     }
   }
   return "";
}

// refill days in days dropdown box
function __refillDaysInMonth(type)
{
   var years_dll = document.getElementById(type+'year');
   var months_dll = document.getElementById(type+'month');
   var days_dll = document.getElementById(type+'day');
   var selected_day = document.getElementById(type+'day').selectedIndex;
   var day_in_month = __daysInMonth(months_dll.value-1, years_dll.value);
   
   //alert(selected_day);

   var option;
   var day_value;
   var ind = 0;
   if(selected_day > (day_in_month-1)) selected_day = (day_in_month-1);
   
   __cleanDDL(days_dll);
   for(i = 1; i <= day_in_month; i++) {
      option = new Option;
      ind = i - 1;
      
      day_value =  (i < 10) ? '0'+i : i;
      option.text = day_value;
      option.value = day_value;
      days_dll.options[ind] = option;
      if((ind) == selected_day){
         days_dll.options[ind].selected = true;
      }
   }      
}

function __daysInMonth(month, year)
{
   return 32 - new Date(year, month, 32).getDate();
}

function __cleanDDL(obj)
{
   var options_length = obj.options.length;
   for (i=0; i<options_length; i++) {
      obj.remove(0);
   }
   obj.options.length = 0;
}

function __SetFocus(el){
   if(document.getElementById(el)) document.getElementById(el).focus();
}

function __toggleCellScroll(el){
   if(document.getElementById("divDayEventContainer"+el)){
      if(document.getElementById("divDayEventContainer"+el).style.overflowY == "scroll"){
         document.getElementById("divDayEventContainer"+el).style.overflowY = "hidden";
         document.getElementById("dayEventLinkShow"+el).style.display = "";
         document.getElementById("dayEventLinkCollapse"+el).style.display = "none";
      }else{
         document.getElementById("divDayEventContainer"+el).style.overflowY = "scroll";
         document.getElementById("dayEventLinkShow"+el).style.display = "none";
         document.getElementById("dayEventLinkCollapse"+el).style.display = "";
      }
   }
}

function trim(str, chars) {
   return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
   chars = chars || "\\s";
   return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
   chars = chars || "\\s";
   return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}