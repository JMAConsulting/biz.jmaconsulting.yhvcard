<?php
use CRM_Yhvcard_ExtensionUtil as E;

require_once('CRM/Contact/Form/Task.php');

class CRM_Yhvcard_Task_Cards extends CRM_Contact_Form_task {

  public function buildQuickForm() {
    CRM_Utils_System::setTitle(E::ts('Task_Cards'));
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
        'submitOnce' => TRUE,
      ),
    );
    $this->addButtons($buttons);
  }

  public function postProcess() {
    $params = $this->controller->exportValues($this->_name);
    $cardsForPrinting = CRM_Yhvcard_Utils::openCollectedPDF();
    $filename = 'cards-to-print-' . (int) $_SERVER['REQUEST_TIME'] . '.pdf';
    foreach ($this->_contactIds  as $contactId) {
      $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', TRUE, 'UTF-8', FALSE);
      $pdf->Open();
      $pdf->SetAuthor('Yee Hong Centre for Geriatric Care');
      $mymargin_left = 12;
      $mymargin_top = 6;
      $mymargin_right = 12;
      $pdf->SetMargins($mymargin_left, $mymargin_top, $mymargin_right);
      $pdf->setJPEGQuality('100');
      $pdf->SetAutoPageBreak('', $margin=0);
      $pdf_variables = [
        'mymargin_left' => $mymargin_left,
        'mymargin_top' => $mymargin_top,
        'contact_id' => $contactId,
      ];
      $outputFiles = [$pdf, $cardsForPrinting];
      foreach ($outputFiles as $f) {
        $f->AddPage();
        CRM_Yhvcard_Utils::writeCard($f, $pdf_variables);
      }
      $pdf->Close();
      $pdf_file = CRM_Core_Config::singleton()->uploadDir . 'card-' . $contactId . '.pdf';
      $pdf->Output($pdf_file, 'F');
    }
    if ($cardsForPrinting->getNumPages() > 0) {
      $cardsForPrinting->Output($filename, 'D');
      CRM_Utils_System::civiExit();
    }
    else {
      $cardsForPrinting->Close();
    }
  }

}
