<?php
use CRM_Yhvcard_ExtensionUtil as E;

abstract class CRM_Yhvcard_Utils {

  public static function openCollectedPDF() {

    static $pdf;

    if (!isset($pdf)) {
      //define ('K_PATH_IMAGES', '');
      require_once 'tcpdf/tcpdf.php';

      $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', TRUE, 'UTF-8', FALSE);
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
    TCPDF_FONTS::addTTFfont(E::path('Fonts/CalibriRegular.ttf'), 'TrueTypeUnicode', '', 32);
    TCPDF_FONTS::addTTFfont(E::path('Fonts/calibri-bold.ttf'), 'TrueTypeUnicode', '', 32);
    // Middle center section
    $pdf->Image(E::path('images/front-background.jpg'), $mymargin_left + 15, $mymargin_top, '', 60);
    $receipt_logo = E::path('images/your-logo.png');
    $pdf->Image($receipt_logo, $mymargin_left, $mymargin_top, '', 10);
    $pdf->SetFont('Calibri', 'b', 10);
    $rightColumnLeftMargin = ($pdf->getPageWidth() / 2);
    $pdf->Image(E::path('images/back-background.png'), $rightColumnLeftMargin + 12, $mymargin_top, '', 60);
    $pdf->setX($mymargin_left + 15);
    $pdf->Write(10, 'Yee Hong Centre for Geriatric Care', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0, 0);
    $pdf->SetY($mymargin_top + 6);
    $pdf->setX($mymargin_left + 15);
    $pdf->Write(10, 'Volunteer Identity Card', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0);
    TCPDF_FONTS::addTTFfont(E::path('Fonts/SIMSUN.ttf'), 'TrueTypeUnicode', '', 32);
    TCPDF_FONTS::addTTFfont(E::path('Fonts/SimSun-Bold.ttf'), 'TrueTypeUnicode', '', 32);
    $pdf->SetY($mymargin_top + 12);
    $pdf->setX($mymargin_left + 15);
    $pdf->setFont('SimSun', 'b', 10);
    $pdf->Write(10, '頤康中心  義工証', '', 0, 'L', TRUE, 0, FALSE, FALSE, 0);
    $pdf->SetY($mymargin_top);
    $pdf->setX($rightColumnLeftMargin);
    $pdf->SetFont('Calibri', 'b', 10);
    $backText = 'This Volunteer Identity Card is the property of Yee Hong Centre for Geriatric Care and must be surrendered upon request or at the termination of volunteer services. All volunteers should wear this card to identify themselves when they are performing volunteer services. Report for loss of card should be made immediately to the Volunteer & Advocacy Services.

    For inquiry, please contact Yee Hong Centre for Geriatric Care at (416) 412-4571 ext. 2619 or 2611 during office hours.

    issued by:           Date:' . date('M D, Y');
    $pdf->MultiCell($rightColumnLeftMargin - 12, 5, $backText, 0, 'R');
    $pdf->SetY($mymargin_top + 30);
  }

}
