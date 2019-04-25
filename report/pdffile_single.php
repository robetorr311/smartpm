<?php
require('fpdf.php');
include('connection.php');

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
$sql = "SELECT * FROM roofing_project where id=".$_GET['id1']." ORDER BY id DESC LIMIT 1";
$sql1 = "SELECT * FROM jobs where id=".$_GET['id2'];

$result = $conn->query($sql);
$result1 = $conn->query($sql1);
while($row1 = $result1->fetch_assoc()) {
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       
	    $a= json_decode($row['imagebox'], TRUE);

//print_r($a);
//die;
$imageLocation = 'image/logo.png';
$ext = end(explode(".", $imageLocation));
$image = base64_encode(file_get_contents($imageLocation));
$img="<img src='data:image/$ext;base64,$image'>";

$html='<p ><b>Name: </b>'.$row1['firstname'].' '.$row1['lastname'].'<br><b>Address: </b>'.$row1['address'].', '.$row1['city'].', '.$row1['state'].'<br><b>Phone: </b>'.$row1['phone1'].'</p>';
       // $html = "<p style='margin-left:100px'>".$row1['firstname']." ".$row1['lastname']."<br>".$row1['address'].", ".$row1['city'].", ".$row1['state']."<br>".$row1['phone1']."</p>";
         $j=count($a);
    	for($i=0;$i<count($a);$i++)
    	{ $j--;
    	$pdf->AddPage();
    	$pdf->SetFont('Arial','',13);
    	$pdf->SetLeftMargin(45);
    	$pdf->WriteHTML($html);
    	$pdf->Image('image/logo.png',10,4,30,0,'','#');
    	$pdf->Image('output/'.$a[$j],10,40,190,0,'','');
    	//$pdf->Image('output/'.$a[0],10,100,190,0,'','');
    
    	$pdf->SetFontSize(14);
    
    	}

	  
    }
        } else {
        echo "No Record";
    }
}

$pdf->Output();
?>