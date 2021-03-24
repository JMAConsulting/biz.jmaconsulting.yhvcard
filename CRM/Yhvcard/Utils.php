<?php
use CRM_Yhvcard_ExtensionUtil as E;

abstract class CRM_Yhvcard_Utils {

  public static function openCollectedPDF() {

    static $pdf;

    if (!isset($pdf)) {
      //define ('K_PATH_IMAGES', '');

      $pdf = new CRM_Yhvcard_PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', TRUE, 'UTF-8', FALSE);
      $pdf->Open();

      $pdf->SetAuthor(Civi::settings()->get('org_name'));

      $mymargin_left = 12;
      $mymargin_top = 6;
      $mymargin_right = 12;
      $pdf->SetMargins($mymargin_left, $mymargin_top, $mymargin_right);

      $pdf->setJPEGQuality('100');

      $pdf->SetAutoPageBreak('', $margin=0);
    }
    return $pdf;
  }

  public static function writeCard(&$pdf, $pdf_variables) {
    // Extract variables
    $mymargin_left = $pdf_variables["mymargin_left"];
    $mymargin_top = $pdf_variables["mymargin_top"];
    $pdf->AddFont('Calibri', 'B', E::path('Fonts/calibrib.php'));
    $pdf->AddFont('SimSun', 'B', E::path('Fonts/simsunb.php'));
    $pdf->AddFont('SimSun', '', E::path('Fonts/simsun.php'));
    $pdf->AddFont('Calibri', '', E::path('Fonts/calibri.php'));
    $rightColumnLeftMargin = ($pdf->getPageWidth() / 2);
    // Front section
    $pdf->Image(E::path('images/front-background.jpg'), $mymargin_left, $mymargin_top, 90, 60);
    $pdf->Image(E::path('images/back-background.png'), $rightColumnLeftMargin, $mymargin_top, '', 60);
    $pdf->setY($mymargin_top + 18);
    $pdf->setX($mymargin_left);
    $pdf->Write(10, 'No. ', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setFont('SimSun', 'b', 10);
    $pdf->setY($mymargin_top + 18);
    $pdf->setX($mymargin_left + 8);
    $pdf->Write(10, ' 編號:', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 18);
    $pdf->setX($mymargin_left + 24);
    $pdf->SetFont('Calibri', 'b', 15);
    $pdf->Write(10, $pdf_variables['contact_id'], '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 24);
    $pdf->setX($mymargin_left);
    $pdf->SetFont('Calibri', 'b', 10);
    $pdf->Write(10, 'Name', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setFont('SimSun', 'b', 10);
    $pdf->setY($mymargin_top + 24);
    $pdf->setX($mymargin_left + 12);
    $pdf->Write(10, '姓名:', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 24);
    $pdf->setX($mymargin_left + 24);
    $pdf->SetFont('Calibri', 'b', 15);
    $pdf->Write(10, strtoupper($pdf_variables['name']), '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 30);
    $pdf->setX($mymargin_left + 24);
    $pdf->setFont('SimSun', 'b', 15);
    $pdf->write(10, $pdf_variables['chinese_name'], '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 44);
    $pdf->setX($mymargin_left);
    $pdf->SetFont('SimSun', 'b', 10);
    $pdf->Write(10, '有效日期:', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setFont('Calibri', 'b', 10);
    $pdf->setY($mymargin_top + 40);
    $pdf->setX($mymargin_left);
    $pdf->Write(10, 'Expiry Date:', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 40);
    $pdf->setX($mymargin_left + 24);
    $pdf->SetFont('SimSun', 'b', 10);
    $pdf->Write(10, $pdf_variables ['expiry_date_year'], '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 40);
    $pdf->setX($mymargin_left + 40);
    $pdf->Write(10, '-', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 40);
    $pdf->setX($mymargin_left + 50);
    $pdf->Write(10, $pdf_variables ['expiry_date_month'], '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 40);
    $pdf->setX($mymargin_left + 65);
    $pdf->Write(10, '-', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 40);
    $pdf->setX($mymargin_left + 75);
    $pdf->Write(10, $pdf_variables['expiry_date_day'], '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 44);
    $pdf->setX($mymargin_left + 24);
    $pdf->SetFont('SimSun', 'b', 10);
    $pdf->Write(10, '年 Year', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 44);
    $pdf->setX($mymargin_left + 40);
    $pdf->Write(10, '-', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 44);
    $pdf->setX($mymargin_left + 45);
    $pdf->Write(10, '月 Month', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 44);
    $pdf->setX($mymargin_left + 65);
    $pdf->Write(10, '-', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->setY($mymargin_top + 44);
    $pdf->setX($mymargin_left + 70);
    $pdf->Write(10, '日 Day', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);

    // Back of the card
    $pdf->SetY($mymargin_top);
    $pdf->setX($rightColumnLeftMargin);
    $pdf->SetFont('Calibri', 'b', 10);
    $backText = 'This Volunteer Identity Card is the property of Yee Hong Centre for Geriatric Care and must be surrendered upon request or at the termination of volunteer services. All volunteers should wear this card to identify themselves when they are performing volunteer services. Report for loss of card should be made immediately to the Volunteer & Advocacy Services.

For inquiry, please contact Yee Hong Centre for Geriatric Care at (416) 412-4571 ext. 2619 or 2611 during office hours.';
    $pdf->MultiCell($rightColumnLeftMargin - 12, 5, $backText, 0, 'L');
    $pdf->SetFont('Calibri', 'b', 10);
    $pdf->SetY($mymargin_top + 50);
    $pdf->setX($rightColumnLeftMargin);
    $pdf->write(10, 'Issued by: ' . $pdf_variables['issued_by'] . '  Date:' . date('M d, Y'), '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
  }

}
