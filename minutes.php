
       

<html>
<head>
    
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script type="text/javascript">
var doc = new jsPDF();
var specialElementHandlers = {
'#editor': function (element, renderer) {
return true;
}
};

$(document).ready(function() {
$('#btn').click(function () {
doc.fromHTML($('#area').html(), 15, 15, {
'width': 170,
'elementHandlers': specialElementHandlers
});
    var name = doc
doc.save(name);
});
});
</script>
    <script>
		function printt(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
	</script>
    <script type="text/javascript">
    
    document.getElementById("head").defaultValue = "Goofy";

    </script>
    <link rel="stylesheet" href="style.css">
    <style>
       
        #area{
background: rgb(100,100,120);
            height: auto;
            width: 830px;
            padding: 10px 15px 40px 15px;
            border-radius:0px 100px 0px 100px ;
            color: white;
        }
        #final_span{
            min-height: 320px;
            height: auto;
            width: auto;
  background: rgb(100,100,145);
            border-radius:0px 100px 0px 100px ;
            border: 1px solid rgb(230,230,230);
            padding: 20px 30px 40px 20px;
            outline: none;
            text-align: left;
            font-family:serif;
        }
        .cont{
            width: 28%;
            text-align: center;
            float: left; 
            margin:0% 9%;
            border: 1px solid rgb(250,250,250);
            border-radius: 5px;
        }
        button{
            margin-bottom:5px;
            padding:0px;
            background:white;
        }
        h3{padding:0px;
            margin:7px;
            
        }
       
    </style>
    </head>

<body>
    <center>
<div>
    <h2 id="start_button"> <i>Summarized Text </i></h2> 
</div>
    

    <div id="area">
        <h3 style="padding:0px;margin:4px;"> <div style="text-align:center;margin:5px 10% 15px 10%;border: 2px solid rgb(230,230,230);width:70%;border-radius:5px;" contenteditable="true" id="head">Remote Sensing Applications Centre, Lucknow</div> 
        </h3>
        <div class="member" style="text-align:left;padding:4px 30px" contenteditable="true">  &nbsp;&nbsp;&nbsp;&nbsp;Type Member names here ........</div>

           <!--  <span id="interim_span" class="interim"> </span> -->
           
        <div contenteditable="true" 
 id="final_span" class="final" name="final_text"> 
 <?php 
        
         if(isset($_POST['subb'])) {
           $MyText = $_POST['hidden'];
           //  echo $MyText;
            $webService = 'https://resoomer.pro/analyzer/';

$datasPost = 'API_KEY=CF2B178A234D828A59BEA309F68BDF7C&text='.$MyText;

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $webService);

curl_setopt($ch,CURLOPT_POST, 2);

curl_setopt($ch,CURLOPT_POSTFIELDS, $datasPost);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

$result = curl_exec($ch);


curl_close($ch);
                   
            $data = json_decode($result);
         if($data->codeResponse ==200){
       $MyText= $data->textAnalyzed;

              $webService = 'https://resoomer.pro/summarizer/';

$datasPost = 'API_KEY=CF2B178A234D828A59BEA309F68BDF7C&text='.$MyText;

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $webService);

curl_setopt($ch,CURLOPT_POST, 2);

curl_setopt($ch,CURLOPT_POSTFIELDS, $datasPost);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

$result = curl_exec($ch);


curl_close($ch);
                   
            $data = json_decode($result);
             if($data->codeResponse == 200)
                 echo $data->text->content;
             
         }
             
             else if($data->codeResponse ==7)
                 echo "$data->codeResponse Maybe Text not well punctuated :(" ;
             
                          else if($data->codeResponse ==8)
                 echo "$data->codeResponse Maybe Text too short to summarize or not well punctuated :(" ;
             
                                           else if($data->codeResponse ==6)
                 echo "$data->codeResponse Maybe Text contains too many words :(" ;
             else
                 echo "$data->codeResponse Some Other Error :(";


                  }
                
                

        ?>

        </div>
        
        <div class="contt">
            <div contenteditable="true" class="cont cont1">
                    
                signature<br>
                (Default1)
                
            </div>
            
            <div contenteditable="true" class="cont cont2">
            
                signature<br>
                (Default2)
            </div>
            
        
        </div>
        
        </div>
         
        <br>
                
        
        
<div id="editor"></div>
        
        
        <button onclick="printt('area')" style="color:rgb(50,50,120)"><i><h3>Print Document</h3></i></button> <br><br>
 Filename to Save As: 
        <input id="inputFileNameToSaveAs">  
        <button class="btn"  onclick="saveTextAsFile()"><b><i>Save Text to File</i></b></button> <br>        <script type="text/javascript">
         
    function saveTextAsFile()
{
    var textToSave = document.getElementById("final_span").innerHTML;
     textToSave= textToSave.replace(/<br>/g, "\r\n").replace(/<p>/g,"\r\n\n");    
    var textToSaveAsBlob = new Blob([textToSave], {type:"text/plain"});
    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
    var fileNameToSaveAs = document.getElementById("inputFileNameToSaveAs").value;
 
    var downloadLink = document.createElement("a");
    downloadLink.download = fileNameToSaveAs;
    downloadLink.innerHTML = "Download File";
    downloadLink.href = textToSaveAsURL;
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
 
    downloadLink.click();
}
    
function destroyClickedElement(event)
{
    document.body.removeChild(event.target);
}
        </script>
        
        <div class="bottom">
        
        developer  &copy; Srishti Yadav.
        
        </div>
    </center>
    
    </body></html>