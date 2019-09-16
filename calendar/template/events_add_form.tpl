<style>

#sel_category_name{

	width:140px; 

	padding: 10px 5px !important;

    border-radius: 3px !important;

}

#user_id{

	

	padding: 10px 5px !important;

    border-radius: 3px !important;

	

	}

	

input[type="text"]{

	

	padding: 10px 5px !important;

    border-radius: 3px !important;

	

}	

	

</style>



<fieldset class='cal_fieldset'>

{h:legend}

<table class='fieldset_content' align='center' border='0'>

<tr>

    <td valign='top' align='left'>

        <table align='center' border='0' width='325px'>

        <tr valign='top'>

            <td align='left'>

                {h:lan_event_name}:<br />

                <input type='text' style='width:320px' id='event_name' name='event_name' />

            </td>

        </tr>

        <!--<tr valign='top'>

            <td align='left'>

                Select User:<br />

               

                <select style='width:320px' name="user_id" id="user_id">

                <option value="">-- Select --</option>

                <option value="2">Twooo</option>

                <option value="3">Threee</option>

                </select>

            </td>

        </tr>-->

        <tr valign='top'>

            <td align='left'>

                {h:lan_event_description}:<br />

                <textarea style='width:320px; height:65px;' id='event_description' name='event_description'></textarea>

            </td>

        </tr>

        </table>

    </td>

    <td width='30px' nowrap='nowrap'></td>

    <td valign='top'>

        <table align='right' border='0' width='310px'>				

        <tr>

            <td colspan='3' align='left'>

                {h:lan_category_name}

                {h:ddl_categories}

            </td>

        </tr>

        <tr><td colspan='3' align='left' nowrap='nowrap' height='9px'></td></tr>

        <tr>

            <td colspan='3' align='left'>

                <input type="radio" class="btn_radio" name="event_insertion_type" value="1" checked="checked" onclick="__eventInsertionType(1)" /> {h:lan_add_event_to_list}

                <br />

                <input type="radio" class="btn_radio" name="event_insertion_type" value="2" onclick="__eventInsertionType(2)" /> {h:lan_add_event_occurrences}

            </td>

        </tr>

        <tr valign='top'>

            <td align='right' nowrap='nowrap'>{h:lan_from}:</td>

            <td></td>

            <td align='right' nowrap='nowrap'>{h:ddl_from}</td>

        </tr>

        <tr valign='top'>

            <td align='right' nowrap='nowrap'>{h:lan_to}:</td>

            <td></td>

            <td align='right' nowrap='nowrap'>{h:ddl_to}</td>

        </tr>

        </table>

    </td>

</tr>  

<tr><td align='center' colspan='3' style='height:30px;padding:0px;'><div id='divEventsAdd_msg'></div></td></tr>

<tr>

    <td align='left' colspan='3'>

        <input class='form_button' type='button' name='btnSubmit' value='{h:lan_add_event}' onclick='javascript:__EventsAdd();' />

        &nbsp;- {h:lan_or} -&nbsp;

        <a class='form_cancel_link' name='lnkCancel' href='javascript:void(0);' onclick='javascript:__EventsCancel();'>{h:lan_cancel}</a>

    </td>

</tr>

</table>

</fieldset>



<script type='text/javascript'>

<!--

__SetFocus('event_name');

__InitEventsAddForm();

//-->

</script>