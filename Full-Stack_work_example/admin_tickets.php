<?php
/***********************************/
/* script: admin_tickets.php       */
/* author: Francesco Allegrini     */
/***********************************/

//-------------------------------------------------------------------------------------------------- INCLUDES 

include ("languages/admin_$GLOBAL_LANGUAGE.php");
include ("languages/admin_tickets_$GLOBAL_LANGUAGE.php");

//-------------------------------------------------------------------------------------------------- SESSION CONTROL

session_check(true);

//-------------------------------------------------------------------------------------------------- JAVASCRIPT

$jsScript.=
	"<script type=\"text/javascript\"> ".

	"function chkTicketsData() { ". 	
	"  if(!isStrn('frmTckDescription')) return false;".
	"  if(!isDate('frmTckCustomerDate')) return false; ".
	"  if(!isNull('frmTckUsrId')) return false;".
	"  if(!isNull('frmTckMain')) return false; ".
	"  if(!isNull('frmTckStatus')) return false; ".
	"  return true; ".
	"} ".

	"function setTicketsBilled(idx,rid) { ".
		"  var ip = GetControlByID('frmTckHostIp'+rid).value; ".
		"  var id = GetControlByID('frmTckHostId'+rid).value; ".
		"  var pw = GetControlByID('frmTckHostPassword'+rid).value; ".
		"  var dbname = GetControlByID('frmTckHostDbName'+rid).value; ".
		"  ajaxCallPhpScriptSync('setTicketsBilled','action=setticketsbilled&key='+idx+'&rid='+rid+'&dbip='+ip+'&dbid='+id+'&dbpw='+pw+'&dbname='+dbname,'$GLOBAL_LANGUAGE'); ".
	"} ".

	"function setTicketsPaid(idx,rid) { ".
		"  var ip = GetControlByID('frmTckHostIp'+rid).value; ".
		"  var id = GetControlByID('frmTckHostId'+rid).value; ".
		"  var pw = GetControlByID('frmTckHostPassword'+rid).value; ".
		"  var dbname = GetControlByID('frmTckHostDbName'+rid).value; ".
		"  ajaxCallPhpScriptSync('setTicketsPaid','action=setticketspaid&key='+idx+'&rid='+rid+'&dbip='+ip+'&dbid='+id+'&dbpw='+pw+'&dbname='+dbname,'$GLOBAL_LANGUAGE'); ".
	"} ".

	"function TckChoseLevel(obj) { ".
		"  var level = GetControlByID('frmTckMain').value; ".
		"  GetControlByID('divTckImplementazione').style.display = level=='1'?'block':'none'; ".
		"  GetControlByID('divTckAssistenza').style.display = level=='2'?'block':'none'; ".
	"} ".

	"function setConTotVatByNoVat() { ".
		"  var cost = GetControlByID('frmTckCost'); ".
		"  doCurrency(cost); ".
	"} ".

	"function TckChoseServer() { ".
		"  var server = GetControlByID('frmTckUsrServer').value; ".
		"  ajaxCallPhpScriptSync('TckChoseServer','action=tckchoseserver&uid='+ server,'$GLOBAL_LANGUAGE'); ".
		"  GetControlByID('divTckUsers').style.display = server!==''?'block':'none'; ".
	"} ".
	
	"function ajaxGetResponseTickets(response) { ".
		"  if(GetXMLValue(response,'action')=='tckchoseserver'){ ".
			"  var action = GetXMLValue(response,'action'); ".
			"  var result = GetXMLValue(response,'result'); ".
			"  var ctrl = GetControlByID('frmTckUsrId'); ".
			"  GetControlByID('frmTckHostIp').value = GetXMLDetailValue(response,'usr_dbRemoteIp');".
			"  GetControlByID('frmTckHostId').value = GetXMLDetailValue(response,'usr_dbRemoteUserId');".
			"  GetControlByID('frmTckHostPassword').value = GetXMLDetailValue(response,'usr_dbRemoteUserPassword');".
			"  GetControlByID('frmTckHostDbName').value = GetXMLDetailValue(response,'usr_dbRemoteName');".
			"  try {ctrl.innerHTML = null;} catch(e){} ".
			"  if((action == 'tckchoseserver')&&(result == 'ok')) { ".
				"  var options = GetXMLDetailValue(response,'usr_options'); ".
				"  if(options!='') { ".
					"  SetSelectOptions(ctrl,options); ".
				"  } ".
			"  } ".
		"  } ".
	"  }".

	"function CheckForInvoice() { ".
		"  client = GetControlByID('frmTckCustDesignation1').innerText; ".
		"  var checkFlag = TestCheckedBox('Nessun record selezionato','Tck'); ".
		"  if(checkFlag) { ".
			"  if(window.confirm('Procedere con la fatturazione del cliente ' + client + '?')) { ".
				"  checkBilled(); ".
				"  return true; ".
			"  } ".
			"  else { ".
				"  return false; ".
			"  } ".
		"  } ".
		"  else { ".
			"  return false; ".
		"  } ".
	"} ".

	"function checkBilled() { ".
		"  var checked = 0; ".
		"  for(let i = 1; i <= GetControlByID('frmTckRows').value; i++) { ".
		"	 if(GetControlByID('frmTckCheck'+i).checked) { ".
		"	 	checked+= GetControlByID('frmTckCheck'+i).checked; ".
		"	 	idx = GetControlByID('frmTckCheck'+i).value; ".
		"	 	setTicketsBilled(idx,i); ".
		"	 } ".
		"  } ".
	"} ".
	"</script>".
	$jsTableView;

//-------------------------------------------------------------------------------------------------- POST PROCEDURE

// Definisce un'eventuale azione del filtro
FiltersDefine(
	'frmFltTckServers',
	'frmFltTckUsers' ,
	'frmFltTckMain',
	'frmFltTckSecond',
	'frmFltTckDescription',
	'frmFltTckCustomerDateFrom',
	'frmFltTckCustomerDateTo',
	'frmFltTckSystemDateFrom',
	'frmFltTckSystemDateTo',
	'frmFltTckStatus',
	'frmFltTckProgress',
	'frmFltTckCreateDateFrom',
	'frmFltTckCreateDateTo',
	'frmFltTckUpdateDateFrom',
	'frmFltTckUpdateDateTo',
	'frmFltTckMinCost',
	'frmFltTckMaxCost',
	'frmFltTckCostType',
	'frmFltTckTiming',
	'frmFltTckBilled',
	'frmFltTckPaid'
);

// Richiesta di visione
if($action==$GLOBAL_ACTION_VIEW) 
{
	
	$idx = GetIndex('frmTckIdx'); // Recupera l'indice del record selezionato
	$rowid = $_POST['frmTckCurrentRow'];
	$mysql_host_ip = $_POST['frmTckHostIp'.$rowid];
	$mysql_host_id = $_POST['frmTckHostId'.$rowid];
	$mysql_host_pw = $_POST['frmTckHostPassword'.$rowid];
	$mysql_host_dbName = $_POST['frmTckHostDbName'.$rowid];

	// Se la connessione avviene
	$mysql = @mysqli_connect($mysql_host_ip,$mysql_host_id,$mysql_host_pw,$mysql_host_dbName);

	// Seleziona il database di lavoro
	@mysqli_select_db($mysqli,$mysql_host_dbName); 
		
	$htmlPageTitle = $GLOBAL_PAGETITLE4;

	$tck = tickets_getinfo($idx); // Recupera tutte le informazioni
	$pmd = $tck['tck_level1'];
	$htmlContent =
		FormBox($GLOBAL_SUBTITLE,
			FormInputDisabled('frmTckUsrServer',$GLOBAL_TCK_NAME,$GLOBAL_TCK_NAME_EX,300,$mysql_host_dbName).DBRK.
			FormInputDisabled('frmTckUsrId',$GLOBAL_TCK_NAME,$GLOBAL_TCK_NAME_EX,300,$tck['tck_customer']).DBRK.
			FormInputDisabled('frmTckMain',$GLOBAL_TCK_MAIN,$GLOBAL_TCK_MAIN_EX,250,$arrTicketsMain[$pmd]).DBRK.
			($pmd==1?FormInputDisabled('frmTckImplementazione',$GLOBAL_TCK_IMPLEMENTAZIONE,$GLOBAL_TCK_IMPLEMENTAZIONE_EX,400,$arrTicketsImplementazione[$tck['tck_level2']]):FormInputDisabled('frmTckAssistenza',$GLOBAL_TCK_ASSISTENZA,$GLOBAL_TCK_ASSISTENZA_EX,400,$arrTicketsAssistenza[$tck['tck_level2']])).DBRK.
			FormInputTextareaDisabled('frmTckDescription',$GLOBAL_TCK_DESCR,$GLOBAL_TCK_DESCR_EX,800,4,$tck['tck_description']).
			FormInputTextareaDisabled('frmTckTiming',$GLOBAL_TCK_TIMING,$GLOBAL_TCK_TIMING_EX,800,4,$tck['tck_timing']).
			FormInputDisabled('frmTckCustomerDate',$GLOBAL_TCK_CUSTOM_DATE,$GLOBAL_TSK_CUSTOM_DATE_EX,200,$tck['tck_customerDate']).DBRK.
			FormInputDisabled('frmTckSystemDate',$GLOBAL_TCK_CUSTOM_DATE,$GLOBAL_TSK_CUSTOM_DATE_EX,200,$tck['tck_systemDate']).DBRK.
			FormInputDisabled('frmTckStatus',$GLOBAL_TCK_STATUS,$GLOBAL_TSK_STATUS_EX,200,$arrTicketsStatus[$tck['tck_status']]).DBRK.
			FormInputDisabled('frmTckProgress',$GLOBAL_TCK_PROG,$GLOBAL_TCK_PROG_EX,300,$arrTicketsProgress[$tck['tck_progress']]).DBRK.
			FormInputDisabled('frmTckCostType',$GLOBAL_TCK_COSTTY,$GLOBAL_TCK_COSTTY_EX,300,$arrTicketsCostType[$tck['tck_costType']]).DBRK.
			FormInputDisabled('frmTckCost',$GLOBAL_TCK_COST,$GLOBAL_TCK_COST_EX,300,$tck['tck_cost']).DBRK.
			FormInputDisabled('frmTckBilled',$GLOBAL_TCK_BILLED,$GLOBAL_TCK_BILLED_EX,300,$arrTicketsFlag[$tck['tck_billed']]).DBRK.
			FormInputDisabled('frmTckPaid',$GLOBAL_TCK_PAID,$GLOBAL_TCK_PAID_EX,300,$arrTicketsFlag[$tck['tck_paid']])
			).
		TableButtons(
			HtmlButtonSubmit($GLOBAL_BTN_CANCEL)
		);		
}

// Richiesta di inserimento
if($action==$GLOBAL_ACTION_INSERT) {
	// Imposta il titolo alla pagina
	$htmlPageTitle = $GLOBAL_PAGETITLE2;
	$res = doquery("select usr_id code,concat(usr_surname,' ',usr_name) value from tb_users where usr_type = 'C';");
	$arrServers = rs2arr($res);
	$htmlContent =
		FormInputHidden('frmTckAction','INSERT').
		FormInputHidden('frmTckRandom',SetRandomBuffer(16)).
		FormInputHidden('frmTckIdx',0).
		(!$usergod?FormInputHidden('frmTckUsrId',$userid):'').
		FormInputHidden('frmTckStatus','a').
		FormInputHidden('frmTckEnabled',1).
		FormInputHidden('frmTckProgress',0).
		FormInputHidden('frmTckHostIp',$mysql_host_ip).
		FormInputHidden('frmTckHostId',$mysql_host_id).
		FormInputHidden('frmTckHostPassword',$mysql_host_pw).
		FormInputHidden('frmTckHostDbName',$mysql_host_dbName).
		FormInputHidden('frmTckBilled',0).
		FormInputHidden('frmTckPaid',0).
		FormBox($GLOBAL_SUBTITLE,
			($usergod?FormInputSwitch('frmTckEnabled',$GLOBAL_TCK_ENABLED,$GLOBAL_TCK_ENABLED_EX,true):'').DBRK.
			($usergod?FormInputCombo('frmTckUsrServer',$GLOBAL_TCK_SERVER,$GLOBAL_TCK_SERVER_EX,$arrServers,300,'',"TckChoseServer()"):FormInputDisabled('frmTckUsrServer',$GLOBAL_TCK_NAME,$GLOBAL_TCK_NAME_EX,300,$userid)).DBRK.
			DivStart('divTckUsers','','display:none').
				($usergod?FormInputCombo('frmTckUsrId',$GLOBAL_TCK_NAME,$GLOBAL_TCK_NAME_EX,'',300,'',''):FormInputDisabled('frmTckUsrId',$GLOBAL_TCK_NAME,$GLOBAL_TCK_NAME_EX,300,$userid)).DBRK.
			DivEnd().	
			FormInputCombo('frmTckMain',$GLOBAL_TCK_MAIN,$GLOBAL_TCK_MAIN_EX,$arrTicketsMain,200,'','TckChoseLevel(this)').DBRK.
			DivStart('divTckImplementazione','','display:none').
				FormInputCombo('frmTckImplementazione',$GLOBAL_TCK_IMPLEMENTAZIONE,$GLOBAL_TCK_IMPLEMENTAZIONE_EX,$arrTicketsImplementazione,200,'').DBRK.		
			DivEnd().		
			DivStart('divTckAssistenza','','display:none').
				FormInputCombo('frmTckAssistenza',$GLOBAL_TCK_ASSISTENZA,$GLOBAL_TCK_ASSISTENZA_EX,$arrTicketsAssistenza,200,'').DBRK.
			DivEnd().
			($usergod?FormInputCombo('frmTckTiming',$GLOBAL_TCK_TIMING,$GLOBAL_TCK_TIMING_EX,$arrTicketsTiming,200,''):'').DBRK.
			FormInputDate('frmTckCustomerDate',$GLOBAL_TCK_CUSTOM_DATE,$GLOBAL_TCK_CUSTOM_DATE_EX,'').
			($usergod?FormInputDate('frmTckSystemDate',$GLOBAL_TCK_SYSTEM_DATE,$GLOBAL_TCK_SYSTEM_DATE_EX,$GLOBAL_SYSTEM_DATE):FormInputDisabled('frmTckSystemDate',$GLOBAL_TCK_SYSTEM_DATE,$GLOBAL_TCK_SYSTEM_DATE_EX,300)).DBRK.
			FormInputTextarea('frmTckDescription',$GLOBAL_TCK_DESCR,$GLOBAL_TCK_DESCR_EX,2000,800,4,'','','','',false,'',true).
			($usergod?FormInputCombo('frmTckProgress',$GLOBAL_TCK_PROGRESS, $GLOBAL_TCK_PROGRESS_EX,$arrTicketsProgress,200,$tck):FormInputDisabled('frmTckProgress',$GLOBAL_TCK_PROGRESS,$GLOBAL_TCK_PROGRESS_EX,200)).DBRK.
			($usergod?FormInputCombo('frmTckCostType',$GLOBAL_TCK_COSTTY,$GLOBAL_TCK_COSTTY_EX,$arrTicketsCostType,200,''):'').DBRK.
			($usergod?FormInputText('frmTckCost',$GLOBAL_TCK_COST,$GLOBAL_TCK_COST_EX,10,100,number(0,2),'','setConTotVatByNoVat()'):'').DBRK.
			($usergod?FormInputCombo('frmTckBilled',$GLOBAL_TCK_BILLED,$GLOBAL_TCK_BILLED_EX,$arrTicketsFlag,200,''):'').DBRK.
			($usergod?FormInputCombo('frmTckPaid',$GLOBAL_TCK_PAID,$GLOBAL_TCK_PAID_EX,$arrTicketsFlag,200,''):'').DBRK
			
		).
		TableButtons(
			HtmlButtonSubmit($GLOBAL_BTN_SAVE,'chkTicketsData()').
			HtmlButtonSubmit($GLOBAL_BTN_CANCEL)
		);
}

// Richiesta di modifica
if($action==$GLOBAL_ACTION_MODIFY) {
	// Imposta il titolo alla pagina
	$htmlPageTitle = $GLOBAL_PAGETITLE3; 

	$res = doquery("select usr_id code,concat(usr_surname,' ',usr_name) value from tb_users where usr_type = 'C';");
	$arrServers = rs2arr($res);
	// print_r($arrServers);exit;
	$arrAllUsers = users_getusers("");//Recupera tutti i nomi disponibili

	$idx = GetIndex('frmTckIdx'); // Recupera l'indice del record selezionato
	
	// print_r($_POST);exit;
	$rowid = $_POST['frmTckCurrentRow'];
	$clientsName = $_POST['frmTckHostClient'.$rowid];
	$mysql_host_ip = $_POST['frmTckHostIp'.$rowid];
	$mysql_host_id = $_POST['frmTckHostId'.$rowid];
	$mysql_host_pw = $_POST['frmTckHostPassword'.$rowid];
	$mysql_host_dbName = $_POST['frmTckHostDbName'.$rowid];
	
	$mysql = @mysqli_connect($mysql_host_ip,$mysql_host_id,$mysql_host_pw,$mysql_host_dbName);
	// Seleziona il database di lavoro
	@mysqli_select_db($mysqli,$mysql_host_dbName); 


	$lck = tickets_lock($idx); // Blocca la scheda


	if($lck==1) {
		$tck = tickets_getinfo($idx); // Recupera tutte le informazioni
		$pmd = $tck['tck_level1'];
		$htmlContent =
			FormInputHidden('frmTckAction','UPDATE').
			FormInputHidden('frmTckRandom',SetRandomBuffer(16)).
			FormInputHidden('frmTckIdx',$idx).
			FormInputHidden('frmTckHostIp'.$rowid,$mysql_host_ip).
			FormInputHidden('frmTckHostId'.$rowid,$mysql_host_id).
			FormInputHidden('frmTckHostPassword'.$rowid,$mysql_host_pw).
			FormInputHidden('frmTckHostDbName'.$rowid,$mysql_host_dbName).
			FormInputHidden('frmTckCurrentRow',$rowid).
			FormInputHidden('frmTckBilled',0).
			FormInputHidden('frmTckPaid',0).
			FormBox($GLOBAL_SUBTITLE,
				FormInputSwitch('frmTckEnabled',$GLOBAL_TCK_ENABLED,$GLOBAL_TCK_ENABLED_EX,($tck['tck_enabled']=='1')).DBRK.
				FormInputCombo('frmTckUsrServer',$GLOBAL_TCK_SERVER,$GLOBAL_TCK_SERVER_EX,$arrServers,300,$clientsName,"TckChoseServer(this)").DBRK.
				($usergod?FormInputCombo('frmTckUsrId',$GLOBAL_TCK_NAME,$GLOBAL_TCK_NAME_EX,$arrAllUsers,300,$tck['tck_usr_id']):'').DBRK.
				FormInputCombo('frmTckMain',$GLOBAL_TCK_MAIN,$GLOBAL_TCK_MAIN_EX,$arrTicketsMain,250,$pmd,'TckChoseLevel(this)').DBRK.
				DivStart('divTckImplementazione','','display:'.($pmd=='1'?'block':'none')).
					FormInputCombo('frmTckImplementazione',$GLOBAL_TCK_IMPLEMENTAZIONE,$GLOBAL_TCK_IMPLEMENTAZIONE_EX,$arrTicketsImplementazione,250,$tck['tck_level2']).DBRK.		
				DivEnd().
				DivStart('divTckAssistenza','','display:'.($pmd=='2'?'block':'none')).
					FormInputCombo('frmTckAssistenza',$GLOBAL_TCK_ASSISTENZA,$GLOBAL_TCK_ASSISTENZA_EX,$arrTicketsAssistenza,250,$tck['tck_level2']).DBRK.		
				DivEnd().
				($usergod?FormInputCombo('frmTckTiming',$GLOBAL_TCK_TIMING,$GLOBAL_TCK_TIMING_EX,$arrTicketsTiming,150,$tck['tck_timing']):'').DBRK.
				FormInputTextarea('frmTckDescription',$GLOBAL_TCK_DESCR,$GLOBAL_TCK_DESCR_EX,2000,800,4,$tck['tck_description'],'','','',false,'',true).
				FormInputDate('frmTckCustomerDate',$GLOBAL_TCK_CUSTOM_DATE,$GLOBAL_TCK_CUSTOM_DATE_EX,$tck['tck_customerDate']).
				FormInputDate('frmTckSystemDate',$GLOBAL_TCK_SYSTEM_DATE,$GLOBAL_TCK_SYSTEM_DATE_EX,$tck['tck_systemDate']).DBRK.
				($usergod?FormInputCombo('frmTckStatus',$GLOBAL_TCK_STATUS,$GLOBAL_TCK_STATUS_EX,$arrTicketsStatus,200,$tck['tck_status']):FormInputDisabled('frmTckStatus',$GLOBAL_TCK_STATUS,$GLOBAL_TSK_STATUS_EX,200,$arrTicketsStatus[$tck['tck_status']])).DBRK.
				($usergod?FormInputCombo('frmTckProgress',$GLOBAL_TCK_PROGRESS, $GLOBAL_TCK_PROGRESS_EX,$arrTicketsProgress,200,$tck['tck_progress']):'').DBRK.
				($usergod?FormInputCombo('frmTckCostType',$GLOBAL_TCK_COSTTY, $GLOBAL_TCK_COSTTY_EX,$arrTicketsCostType,200,$tck['tck_costType']):'').DBRK.
				($usergod?FormInputText('frmTckCost',$GLOBAL_TCK_COST,$GLOBAL_TCK_COST_EX,10,100,number($tck['tck_cost'],2),'','setConTotVatByNoVat()'):'').DBRK.
				($usergod?FormInputCombo('frmTckBilled',$GLOBAL_TCK_BILLED, $GLOBAL_TCK_BILLED_EX,$arrTicketsFlag,200,$tck['tck_billed']):'').DBRK.
				($usergod?FormInputCombo('frmTckPaid',$GLOBAL_TCK_PAID, $GLOBAL_TCK_PAID_EX,$arrTicketsFlag,200,$tck['tck_paid']):'')

			).
			TableButtons(
				HtmlButtonSubmit($GLOBAL_BTN_SAVE,'chkTicketsData()').
				HtmlButtonSubmit($GLOBAL_BTN_CANCEL)
			);
	} else {
		$htmlMessage =	ShowMessageBox(($lck=='lock')?$GLOBAL_LOCK2:$GLOBAL_LOCK3,'warning');
	}
}

// Richiesta di salvataggio (insert/update)
if($action==$GLOBAL_ACTION_SAVE) {
	$view = true;

	// print_r($_POST);exit;
	$rowid = $_POST['frmTckCurrentRow'];
	$mysql_host_ip = $_POST['usr_dbRemoteIP'];
	$mysql_host_id = $_POST['usr_dbRemoteUserId'];
	$mysql_host_pw = $_POST['usr_dbRemoteUserPassword'];
	$mysql_host_dbName = $_POST['frmTckHostDbName'.$rowid];
	$mysql = @mysqli_connect($mysql_host_ip,$mysql_host_id,$mysql_host_pw,$mysql_host_dbName);
	@mysqli_select_db($mysqli,$mysql_host_dbName);

	$idx      = notags($_POST['frmTckIdx']);
	$uid      = notags($_POST['frmTckUsrId']);
	$lv1      = notags($_POST['frmTckMain']);
    $lv2      = ($_POST['frmTckMain']==1?notags($_POST['frmTckImplementazione']):notags($_POST['frmTckAssistenza']));
	$dsc      = notags($_POST['frmTckDescription']);
	$tim 	  = notags($_POST['frmTckTiming']);
	$dtc      = notags($_POST['frmTckCustomerDate']);
	$dts      = notags($_POST['frmTckSystemDate']);
	$sts      = notags($_POST['frmTckStatus']);
	$act      = notags($_POST['frmTckAction']);
	$progress = notags($_POST['frmTckProgress']);
	$cty 	  = notags($_POST['frmTckCostType']);
	$cst	  = notags($_POST['frmTckCost']);
	$bll 	  = notags($_POST['frmTckBilled']);
	$pid 	  = notags($_POST['frmTckPaid']);
	$enb      = notags($_POST['frmTckEnabled']);
	$rnd      = notags($_POST['frmTckRandom']);

	if(tickets_checkrandom($rnd)) {
		
		if($act=='INSERT') {
			$res = tickets_insert($idx,$uid,$lv1,$lv2,$dsc,$tim,$dtc,$dts,$sts,$progress,$cty,$cst,$bll,$pid,$enb,$rnd);
			$htmlMessage = ShowMessageBox($res?$GLOBAL_INSERT2:$GLOBAL_INSERT3,$res?'success':'danger');
		}

		if($act=='UPDATE') {
			$res = tickets_update($idx,$uid,$lv1,$lv2,$dsc,$tim,$dtc,$dts,$sts,$progress,$cty,$cst,$bll,$pid,$enb,$rnd);
			$htmlMessage = ShowMessageBox($res?$GLOBAL_UPDATE2:$GLOBAL_UPDATE3,$res?'success':'danger');
			tickets_unlock($idx);
		}
	}
	mysqli_connect('127.0.0.1','root','','quesada_crm');
	mysqli_select_db($mysqli,'quesada_crm');
}

// Richiesta di cancellazione
if(iin($action,"$GLOBAL_ACTION_DELETE;$GLOBAL_ACTION_KILL")) {
	$view = true;

	$rowid = $_POST['frmTckCurrentRow'];
	$mysql_host_ip = $_POST['frmTckHostIp'.$rowid];
	$mysql_host_id = $_POST['frmTckHostId'.$rowid];
	$mysql_host_pw = $_POST['frmTckHostPassword'.$rowid];
	$mysql_host_dbName = $_POST['frmTckHostDbName'.$rowid];

	if($action==$GLOBAL_ACTION_DELETE) {
		// Recupera gli indici dei record da cancellare
		for($i=1,$ids='';$i<=$GLOBAL_MAX_PAGE_ROWS;$i++) {
			$id = $_POST['frmTckCheck'.$i];
			$ids.=($id>0)?(($ids!='')?',':'').$id:'';
			
		}
	} else {
		// Recupera l'indice del record da cancellare
		$ids = GetIndex('frmTckIdx');
	}

	$mysql = @mysqli_connect($mysql_host_ip,$mysql_host_id,$mysql_host_pw,$mysql_host_dbName);
	@mysqli_select_db($mysqli,$mysql_host_dbName);

	if($ids!='') {
		$res = tickets_delete($ids);
		$htmlMessage =	ShowMessageBox((($res>0)?(($res==1)?($GLOBAL_DELETE2):($res.' '.$GLOBAL_DELETE3)):($GLOBAL_DELETE4)),($res==0)?'warning':'success');
	} else {
		$htmlMessage =	ShowMessageBox($GLOBAL_DELETE5,'danger');
	}	
}

// Azione cancel
if($action==$GLOBAL_ACTION_CANCEL) {
	$idx = notags($_POST['frmTckIdx']);
	tickets_unlock($idx);
	$view = true;
}

// Azione Fatture
if($action==$GLOBAL_ACTION_BILL) {

	$rowid = 1;
	$mysql_host_ip = $_POST['frmTckHostIp1'];
	$mysql_host_id = $_POST['frmTckHostId1'];
	$mysql_host_pw = $_POST['frmTckHostPassword1'];
	$mysql_host_dbName = $_POST['frmTckHostDbName1'];

	$mysql = @mysqli_connect($mysql_host_ip,$mysql_host_id,$mysql_host_pw,$mysql_host_dbName);
	// Seleziona il database di lavoro
	@mysqli_select_db($mysqli,$mysql_host_dbName);


	$rows = doquery("select *,(select usr_custDesignation from `tb_users` where tck_usr_id = usr_id)tck_names from `tb_tickets` where tck_paid = 0 and tck_status = 'c' and tck_billed = 1;");

	mysqli_connect('127.0.0.1','root','','quesada_crm');
	mysqli_select_db($mysqli,'quesada_crm');

	$newid = invoices_getnewid();
	$rnd = SetRandomBuffer(16);
	$date = DenormalizeDate($GLOBAL_SYSTEM_DATE,'');
	$client = $_POST['frmTckHostDbName1'];
	$iva = 0.22;

	//query test stuff
	$fields = "inv_con_id,inv_ref_id,inv_type,inv_status,inv_number,inv_date,".
				"inv_billDesignation,inv_billFiscalCode,inv_billVatNumber,inv_billAddress,inv_billCity,inv_billProvince,inv_billCap,".
				"inv_billSdiDestCode,inv_billSdiDestOffice,inv_billSdiDestPec,".
				"inv_totalNoVat,inv_notes,inv_enabled,inv_createDate,inv_updateDate,inv_random";
	$values = "0,'0','F','C',$newid,$date,".
				"'$client','0000000','','','','','',".
				"'0000000','PROVA','',".
				"0,'',1,now(),now(),'$rnd'";
	//**********
	$res = doquery("insert into tb_invoices ($fields) values ($values);");
	
	$getID = $mysql_insert_id;


	$n = $_POST['frmTckRows'];
	for($i=1;$i<=$n;$i++){
		if(isset($_POST['frmTckCheck'.$i])){
			$tid = $_POST['frmTckId'.$i];


			$mysql = @mysqli_connect($mysql_host_ip,$mysql_host_id,$mysql_host_pw,$mysql_host_dbName);
			@mysqli_select_db($mysqli,$mysql_host_dbName);

			$tck = tickets_getinfo($tid);

			mysqli_connect('127.0.0.1','root','','quesada_crm');
			mysqli_select_db($mysqli,'quesada_crm');

			$description = $tck['tck_description'];
			$paid = $arrTicketsFlag[$tck['tck_paid']];
			$status = $arrTicketsStatus[$tck['tck_status']];
			$costType = $arrTicketsCostType[$tck['tck_costType']];
			$amount = $tck['tck_cost'];
			if($tck['tck_costType'] == 'C') $amount = 0;
			$amountIva = ($amount*$iva) + $amount;
			$totalNoVat = $totalNoVat + $tck['tck_cost']; 

			invoices_products_insert($newid,$getID,'0000',$description,$amount,1,$amount,$iva,$amountIva,1);
			doquery("update tb_invoices set inv_totalNovat = $totalNoVat where inv_id = $getID;");
		}
	}
	
	$htmlMessage = ShowMessageBox($res?$GLOBAL_INSERT2:$GLOBAL_INSERT3,$res?'success':'danger');
	mysqli_connect('127.0.0.1','root','','quesada_crm');
	mysqli_select_db($mysqli,'quesada_crm');
	$view = 1;
}

//-------------------------------------------------------------------------------------------------- PAGE CONTENT

// Utente loggato va in grid view
if($view) {

	// Imposta il titolo alla pagina
	$htmlPageTitle = $GLOBAL_PAGETITLE1;
	
	// Recupera le informazioni del filtro
	$filters = FiltersInitialize($userid,$page);
	$filter = FiltersFields($filters);
	$isInvoice = ($filters['frmFltTckBilled']==0 && $filters['frmFltTckPaid']==0 && $filters['frmFltTckStatus']=='c' && $filters['frmFltTckServers'])?true:false;

	// Loop rows
	$table_rowkey = 'tck';
	$table_rowcount = 0;

	$allClients = doquery("select usr_id,usr_custDesignation from `tb_users` where usr_type = 'C'");
	if($allClients) while($allClient=@mysqli_fetch_array($allClients)) {
		$arrClients [$allClient['usr_id']] = $allClient['usr_custDesignation'];
	}

	// MODIFICAZIONE FILTRI
	$filters['frmFltTckServers']!=''?$userFilter = "and (usr_id = '".$filters['frmFltTckServers']."')":'';
	$tckFilter = str_replace($userFilter,'',$filter);
	$users = doquery("select * from `tb_users` where usr_type = 'C' $userFilter;");
	
	if($users) while($user=@mysqli_fetch_array($users)) {
		$mysql_host_ip = $user['usr_dbRemoteIP'];
		$mysql_host_id = $user['usr_dbRemoteUserId'];
		$mysql_host_pw = $user['usr_dbRemoteUserPassword'];
		$mysql_host_dbName = $user['usr_dbRemoteName'];

		// Se la connessione avviene
		if($mysql = @mysqli_connect($mysql_host_ip,$mysql_host_id,$mysql_host_pw,$mysql_host_dbName)) {
			
			// Seleziona il database di lavoro
			if(@mysqli_select_db($mysqli,$mysql_host_dbName)!==false) {

				// Recupera le informazioni richieste
				$pageid = GetCurrentPageId();
				$rows = tickets_getlist($isInvoice?0:$GLOBAL_MAX_PAGE_ROWS,$isInvoice?1:$pageid,-1,$tckFilter,$orderby);

				if($rows){
					while($row=@mysqli_fetch_array($rows)) {
						$rowid = $table_rowcount+1;
						$idx = $row['tck_id'];
						$enb = $row['tck_enabled'];
						$lvlValue = $row['tck_level1'];
						$prg = $row['tck_progress'];
						$billed = $row['tck_billed']; 
						$paid = $row['tck_paid'];
						$arrAllUsers [$row['tck_usr_id']] = $row['tck_customer'];
						$htmlTableRows.=
							TableRow(
								FormInputHidden('frmTckHostIp'.$rowid,$mysql_host_ip).
								FormInputHidden('frmTckHostId'.$rowid,$mysql_host_id).
								FormInputHidden('frmTckHostPassword'.$rowid,$mysql_host_pw).
								FormInputHidden('frmTckHostDbName'.$rowid,$mysql_host_dbName).
								FormInputHidden('frmTckHostClient'.$rowid,$user['usr_id']).
								FormInputHidden('frmTckId'.$rowid,$row['tck_id']).
								TableCell_CheckOrLock($row,$rowid).
								TableCell($row['tck_id']).
								TableCell(span('frmTckCustDesignation'.$rowid,$user['usr_custDesignation'])).
								TableCell($row['tck_customer'],'left').
								TableCell(substr($arrTicketsMain[$row['tck_level1']],0,4),'left').
								($lvlValue=='2'?TableCell($arrTicketsAssistenza[$row['tck_level2']],'left'):TableCell($arrTicketsImplementazione[$row['tck_level2']],'left')).
								TableCell($row['tck_description'],'left').
								TableCell($arrTicketsTiming[$row['tck_timing']]).
								TableCell((NormalizeDate($row['tck_customerDate']))).
								TableCell((NormalizeDate($row['tck_systemDate']))).
								TableCell(HtmlStatus('status','stato',strtoupper(substr($arrTicketsStatus[$row['tck_status']],0,1))),'center').
								TableCell($arrTicketsProgress[$row['tck_progress']]).
								TableCell(HtmlStatus('progress','progresso',str_replace('%','',$arrTicketsProgress[$prg]))).
								TableCell($arrTicketsCostType[$row['tck_costType']]).
								($row['tck_costType'] == 'E'?TableCell($row['tck_cost']==0?TextRed(euro($row['tck_cost'])):TextGrn(euro($row['tck_cost']))):TableCell('')).
								TableCell(FormInputSwitch('frmTckBilled'.$rowid,'',$GLOBAL_TCK_BILLED_EX,$billed,'',false,"setTicketsBilled($idx,$rowid)")).
								TableCell(FormInputSwitch('frmTckPaid'.$rowid,'',$GLOBAL_TCK_PAID_EX,$paid,'',false,"setTicketsPaid($idx,$rowid)")).
								TableCell_Actions($row,$rowid,true,($prg==0)||($usergod))
							,true,$enb?'':$GLOBAL_ROW_GREY);
					}
					$htmlTableRows.= FormInputHidden('frmTckRows',$rowid);
				}
			}
		}
	}

	$clientFilter = $filters['frmFltTckServers'];
	//FILTRI
	$htmlContent =
		FormInputHidden('frmTckCurrentRow').
		FormInputHidden('frmTckCurrentOldRow').
		FormInputHidden('frmTckOldColor').
		$htmlMessage.
		FormFilterBox(
			FormInputCombo('frmFltTckBilled',$GLOBAL_TCK_BILLED,$GLOBAL_TCK_BILLED_EX,$arrTicketsFlag,100,$filters['frmFltTckBilled']).
			FormInputCombo('frmFltTckPaid',$GLOBAL_TCK_PAID,$GLOBAL_TCK_PAID_EX,$arrTicketsFlag,100,$filters['frmFltTckPaid']).
			FormInputCombo('frmFltTckServers',$GLOBAL_TCK_CLIENTS,$GLOBAL_TCK_CLIENTS_EX,$arrClients,150,$filters['frmFltTckServers']).
			FormInputCombo('frmFltTckUsers',$GLOBAL_TCK_NAME,$GLOBAL_TCK_NAME_EX,$arrAllUsers,150,$filters['frmFltTckUsers']).
			FormInputCombo('frmFltTckMain',$GLOBAL_TCK_MAIN,$GLOBAL_TCK_MAIN_EX,$arrTicketsMain,150,$filters['frmFltTckMain']).
			FormInputCombo('frmFltTckSecond',$GLOBAL_TCK_SECOND,$GLOBAL_TCK_SECOND_EX,$arrTicketsAssistenza + $arrTicketsImplementazione,250,$filters['frmFltTckImplementazione']).
			FormInputText('frmFltTckDescription',$GLOBAL_TCK_DESCR,$GLOBAL_TCK_DESCR_EX,20,250,$filters['frmFltTckDescription']).DBRK.
			FormInputCombo('frmFltTckTiming',$GLOBAL_TCK_TIMING,$GLOBAL_TCK_TIMING_EX,$arrTicketsTiming,100,$filters['frmFltTckTiming']).
			FormInputDate('frmFltTckCustomerDateFrom',$GLOBAL_TCK_CUSTOM_DATE.$GLOBAL_FROM,$GLOBAL_TCK_CUSTOM_DATE_EX.$GLOBAL_FROM,$filters['frmFltTckCustomerDateFrom']).
			FormInputDate('frmFltTckCustomerDateTo',$GLOBAL_TCK_CUSTOM_DATE.$GLOBAL_TO,$GLOBAL_TCK_CUSTOM_DATE_EX.$GLOBAL_TO,$filters['frmFltTckCustomerDateTo']).
			FormInputDate('frmFltTckSystemDateFrom',$GLOBAL_TCK_SYSTEM_DATE.$GLOBAL_FROM,$GLOBAL_TCK_SYSTEM_DATE_EX.$GLOBAL_FROM,$filters['frmFltTckSystemDate']).
			FormInputDate('frmFltTckSystemDateTo',$GLOBAL_TCK_SYSTEM_DATE.$GLOBAL_TO,$GLOBAL_TCK_SYSTEM_DATE_EX.$GLOBAL_TO,$filters['frmFltTckSystemDate']).
			FormInputCombo('frmFltTckStatus',$GLOBAL_TCK_STATUS,$GLOBAL_TCK_STATUS_EX,$arrTicketsStatus,150,$filters['frmFltTckStatus']).
			FormInputCombo('frmFltTckProgress',$GLOBAL_TCK_PROGRESS,$GLOBAL_TCK_PROGRESS_EX,$arrTicketsProgress,180,$filters['frmFltTckProgress']).
			FormInputCombo('frmFltTckCostType',$GLOBAL_TCK_COSTTY,$GLOBAL_TCK_COSTTY_EX,$arrTicketsCostType,150,$filters['frmFltTckCostType']).
			FormInputText('frmFltTckMinCost',$GLOBAL_TCK_COST.$GLOBAL_FROM,$GLOBAL_TCK_COST_EX.$GLOBAL_FROM,20,150,$filters['frmFltTckMinCost']).
			FormInputText('frmFltTckMaxCost',$GLOBAL_TCK_COST.$GLOBAL_TO,$GLOBAL_TCK_COST_EX.$GLOBAL_TO,20,150,$filters['frmFltTckMaxCost'])
			
		).
		//TESTO COLONNE
		FormBox('',
			TableStart().
				TableHeader(
					TableColumn($GLOBAL_COLUMN1,20).
					TableColumnOrderBy($GLOBAL_COLUMN2,'tck_id',20).
					TableColumnOrderBy($GLOBAL_COLUMN15).
					TableColumnOrderBy($GLOBAL_COLUMN10,'tck_usr_id',50).
					TableColumnOrderBy($GLOBAL_COLUMN3,'tck_level1',50).
					TableColumnOrderBy($GLOBAL_COLUMN4,'tck_level2',50).
					TableColumnOrderBy($GLOBAL_COLUMN5,'tck_description',120).
					TableColumnOrderBy($GLOBAL_COLUMN14,'tck_timing',60).
					TableColumnOrderBy($GLOBAL_COLUMN6,'tck_customerDate',80).
					TableColumnOrderBy($GLOBAL_COLUMN7,'tck_systemDate',80).
					TableColumnOrderBy($GLOBAL_COLUMN8,'tck_status',50).
					TableColumnOrderBy($GLOBAL_COLUMN9,'tck_progress',40).
					TableColumn($GLOBAL_COLUMN9,40). //PROGRESS
					TableColumn($GLOBAL_COLUMN12,'tck_costType',20).
					TableColumn($GLOBAL_COLUMN11,'tck_cost',60).
					TableColumn($GLOBAL_COLUMN13,'tck_billed',20).
					TableColumn($GLOBAL_COLUMN16,'tck_paid',20).
					TableColumn($GLOBAL_ACTIONS,50) //ACTIONS
				).
				$htmlTableRows.
			TableEnd().
			($isInvoice?'':TableNavigator($rowid,$pageid)).
			TableButtons(
				HtmlButtonSubmit($GLOBAL_BTN_DELETE,"CanDelete('Tck')").
				HtmlButtonSubmit($GLOBAL_BTN_INSERT).
				($isInvoice?HtmlButtonSubmit($GLOBAL_BTN_BILL,"CheckForInvoice()"):'')
		,'left')).
		TableLegend($GLOBAL_LEGEND1,$GLOBAL_LEGEND2);
}
mysqli_connect('127.0.0.1','root','','quesada_crm');
mysqli_select_db($mysqli,'quesada_crm');
?>