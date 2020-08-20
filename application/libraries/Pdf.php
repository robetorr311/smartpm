    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
    class Pdf extends TCPDF
    {
        private $company_name = '';
        private $company_address = '';
        private $company_email = '';
        private $company_phone = '';

        public function setCompanyData($company_name, $company_address, $company_email, $company_phone)
        {
            $this->company_name = $company_name;
            $this->company_address = $company_address;
            $this->company_email = $company_email;
            $this->company_phone = $company_phone;
        }

        public function Footer()
        {
            $this->SetY(-23);
            $content = "<div style=\"letter-spacing: 2px; line-height: 20px; text-align: center;\">{$this->company_name} | <span style=\"letter-spacing: normal;\">{$this->company_address}</span><br />{$this->company_email} | {$this->company_phone}</div>";
            $this->writeHTML($content, true, false, true, false, '');
        }
    }
    /*Author:Tutsway.com */  
    /* End of file Pdf.php */
    /* Location: ./application/libraries/Pdf.php */