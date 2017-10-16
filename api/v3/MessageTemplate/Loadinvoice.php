<?php

/**
 * MessageTemplate.Loadinvoice API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_message_template_Loadinvoice_spec(&$spec) {
}

/**
 * MessageTemplate.Loadinvoice API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_message_template_Loadinvoice($params) {

  $messageTemplateId = CRM_Core_DAO::singleValueQuery("
  SELECT mt.id
  FROM   civicrm_option_group og
  JOIN   civicrm_option_value ov ON (og.id = ov.option_group_id)
  JOIN   civicrm_msg_template mt ON (mt.workflow_id = ov.id)
  WHERE og.name = 'msg_tpl_workflow_contribution'
  AND ov.name = 'contribution_invoice_receipt'
  AND mt.is_default = 1
  ");

  // return template id for debugging purposes.
  $returnValues['messageTemplateId']=$messageTemplateId;

  if(empty($messageTemplateId)){
    throw new API_Exception('Unable to identify message templateId');
  }

  $invoiceHtml = Civi::resources()->getPath('org.ilga.loadinvoice','resources/invoice.html');
  $returnValues['invoiceHtml']=$invoiceHtml;

  $msgtxt = file_get_contents($invoiceHtml);

  if(!$msgtxt){
    throw new API_Exception('Unable to read invoice text');
  }

  $result = civicrm_api3('MessageTemplate', 'create', array(
    'id' => $messageTemplateId,
    'msg_html' => $msgtxt));

  $returnValues =  $returnValues + $result;
  $returnValues['loadinvoice'] = 'Loading succesful';
  return civicrm_api3_create_success($returnValues, $params, 'MessageTemplate', 'Loadinvoice');

}
