<?php 
include('connection.php');
require('fpdf.php');
if($_POST['imagebox']!=''){
/*	echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	
$sql = "INSERT INTO roofing_project (job_id, firstname, lastname, address, phone, imageboxdata, imagebox, entry_date, active)
VALUES ('".$_POST['id']."',' ',' ',' ',1,'".json_encode($_POST['imageboxdata'])."','".json_encode($_POST['imagebox'])."','".date('Y-m-d h:i:s')."',1)";

if ($conn->query($sql) === TRUE) {
   header('Location: https://smartpm.app/report/pdffile.php?id='.$_POST['id']);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

/*
class PDF extends FPDF
{
protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
}


$pdf = new PDF();
$sql = "SELECT * FROM roofing_project where phone=".$_POST['phone'];


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       
	$a= json_decode($row['imagebox'], TRUE);



	for($i=0;$i<count($a);$i++)
	{
	$pdf->AddPage();
	$pdf->SetFont('Arial','',20);
	$pdf->Image('image/logo.png',10,12,30,0,'','#');
	$pdf->Image('output/'.$a[$i],10,50,190,0,'','');
	//$pdf->Image('output/'.$a[0],10,100,190,0,'','');
	$pdf->SetLeftMargin(45);
	$pdf->SetFontSize(14);
	$pdf->WriteHTML('<p></p>');
	}

	  
    }
} else {
    echo "Something Wrong";
}

$pdf->Output();
*/
}else{
	
	echo "<script>alert('something went wrong'); window.location.href='index.php'</script>";
}

?> 