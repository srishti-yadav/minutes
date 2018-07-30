
       
<!DOCTYPE HTML5>
<html>
<head>
    
    
    <style>
        body{
        margin: 0px;
        }
        .area{
background: rgb(100,100,140);
            color: white;
            height: 500px;
            width: 600px;
            border-radius:0px 100px 0px 100px ;
        }
     #final_span{
            padding: 50px 20px;
            height: 400px;
            width: 460px;
            background: transparent;
            padding: 10px;
            outline: none;
            padding: 20px;
        }
        
        #start_button {
            text-decoration: none;
            color: black;
            
        }
        
        
    
    </style>
    </head>

<body>
    <center>
<div>
    <h2> <i>Start Summarization </i></h2> 
</div>
    

    <div class="area">
 '<div id="results" >
           <!--  <span id="interim_span" class="interim"> </span> -->
           
        <div contenteditable="true" 
 id="final_span" class="final" name="final_text">
            <?php 
        
         if(isset($_POST['subb'])) {
           $MyText= $_POST['final_text'];
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
echo $data->text->content;
                  }

        ?>
        </div>
        </div>
        </div>
                 
        
        <br>
        Filename to Save As: 
        <input id="inputFileNameToSaveAs">  
        <button onclick="saveTextAsFile()">Save Text to File</button> <br>
        <br>

          
<script type="text/javascript">
    
    function saveTextAsFile()
{
    var textToSave = document.getElementById("final_span").innerHTML;
   //  textToSave= textToSave.replace(/\n/g, "\r\n");        
    // textToSave= textToSave.replace(/\r\n|\n|<br >|\r/g,"\r\n"); 
      //textToSave= textToSave.replace("br>", "\r\n");        

//  textToSave= textToSave.replace('<br><br>',"\r\n");
 // textToSave= textToSave.replace("br>", "\r\n");        
    


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
        
        
    
 
        </center>
    
    
    </body>
</html>