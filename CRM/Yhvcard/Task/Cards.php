<?php
use CRM_Yhvcard_ExtensionUtil as E;

require_once('CRM/Contact/Form/Task.php');

class CRM_Yhvcard_Task_Cards extends CRM_Contact_Form_task {

  public function buildQuickForm() {
    CRM_Utils_System::setTitle(E::ts('Generate Volunteer Cards'));
    parent::buildQuickForm();
    $buttons = array(
      array(
        'type' => 'cancel',
        'name' => E::ts('Back'),
      ),
      array(
        'type' => 'next',
        'name' => E::ts('Generate Volunteer cards'),
        'isDefault' => TRUE,
      ),
    );
    $this->addButtons($buttons);
  }

  public function postProcess() {
    $params = $this->controller->exportValues($this->_name);
    $cardsForPrinting = CRM_Yhvcard_Utils::openCollectedPDF();
    $filename = 'cards-to-print-' . (int) $_SERVER['REQUEST_TIME'] . '.pdf';
    $count = 0;
    foreach ($this->_contactIds  as $contactId) {
      $contact = civicrm_api3('Contact', 'get', ['id' => $contactId, 'return' => ['first_name', 'last_name', 'custom_24']])['values'][$contactId];
      $loggedInContact = civicrm_api3('Contact', 'getsingle', ['id' => $this->getLoggedInUserContactID()]);
      $mymargin_left = 12;
      $mymargin_top = 6;
      if ($count > 0) {
        $mymargin_top = $mymargin_top + 64 * $count;
      }
      $mymargin_right = 12;
      $pdf_variables = [
        'mymargin_left' => $mymargin_left,
        'mymargin_top' => $mymargin_top,
        'contact_id' => $contactId,
        'name' => $contact['first_name'] . ' ' . $contact['last_name'],
        'chinese_name' => $contact['custom_24'],
        'expiry_date' => date('M d, Y', strtotime('+ 1 year')),
        'issued_by' => $loggedInContact['first_name'] . ' ' . $loggedInContact['last_name'],
      ];
      if ($count === 0) {
        $cardsForPrinting->AddPage();
      }
      if ($count === 3) {
        $count = 0;
      }
      else {
        $count++;
      }
      CRM_Yhvcard_Utils::writeCard($cardsForPrinting, $pdf_variables);
    }
    if ($cardsForPrinting->getNumPages() > 0) {
      $cardsForPrinting->Output($filename, 'D');
    }
    else {
      $cardsForPrinting->Close();
    }
    CRM_Utils_System::civiExit();
  }

}
