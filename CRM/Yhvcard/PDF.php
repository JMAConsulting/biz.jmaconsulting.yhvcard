<?php

require_once 'tcpdf/tcpdf.php';

class CRM_Yhvcard_PDF extends TCPDF {
    /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx;

    /**
     * include a background template for every page
     */
    function Header() {
      $pdf_template_file = Civi::settings()->get('receipt_pdftemplate');
      if (!empty($pdf_template_file)) {

        if (is_null($this->_tplIdx)) {
          $pdf_template_file = Civi::settings()->get('receipt_pdftemplate');
          $this->setSourceFile($pdf_template_file);
          $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx);
      }
      else {
        $this->parsers = array();
      }
    }

    function Footer() {}
  }
