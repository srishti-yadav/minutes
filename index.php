<html>

<head>
    
    <style>
        .area{
           background-image: url(images/old3.jpg);
            height: 500px;
            width: 390px;
        }
        #final_span{
            padding: 50px 20px;
            height: 500px;
            width: 390px;
            background: transparent;
            padding: 10px;
            outline: none;
        }
        
        #start_button {
            text-decoration: none;
            color: black;
            
        }
        textarea{
            resize: none;
        }
        
        input{
            padding: 2px;
            border-radius: 4px;
        }
        button{
            border-radius: 4px;
            padding: 3px;
        }
    
    </style>
    
    </head>

    <body>
    <center>
<div>
    <a href="#" id="start_button" onclick="startDictation(event)"><h2> <i>Start Dictation </i></h2> </a>
</div>
        
        
        
       <!--  <table> 
           
          <tr>
        <td colspan="3">
            <textarea id="final_span" cols="80" rows="25">
           
            </textarea>
        </td>
    </tr>
        <tr>
        <td>Filename to Save As:</td>
        <td><input id="inputFileNameToSaveAs"></td>
        <td><button onclick="saveTextAsFile()">Save Text to File</button></td>
    </tr>
    <tr>
        <td>Select a File to Load:</td>
        <td><input type="file" id="fileToLoad"></td>
        <td><button onclick="loadFileAsText()">Load Selected File</button><td>
    </tr>
</table>
      -->
        

       
        <div class="area">
 '<div id="results" >
            <span id="interim_span" class="interim"> </span>
  <textarea id="final_span" class="final"></textarea>
        </div>
        </div>
        
        
        <br>
        Filename to Save As: 
        <input id="inputFileNameToSaveAs">  
        <button onclick="saveTextAsFile()">Save Text to File</button> <br>
        <br>
        Select a File to Load:
          <input type="file" id="fileToLoad">
          <button onclick="loadFileAsText()">Load Selected File</button>
        <br>
    

  <!--       
 < ?php
$MyText =;
        
        $webService = 'https://resoomer.pro/summarizer/';
$datasPost = 'API_KEY=CF2B178A234D828A59BEA309F68BDF7C&text='.$MyText;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $webService);
curl_setopt($ch,CURLOPT_POST, 2);
curl_setopt($ch,CURLOPT_POSTFIELDS, $datasPost);
$result = curl_exec($ch);
curl_close($ch);
echo $result;

    
?>
-->
        </center>
        
        
<script type="text/javascript">
    
    function saveTextAsFile()
{
    var textToSave = document.getElementById("final_span").value;
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
 
function loadFileAsText()
{
    var fileToLoad = document.getElementById("fileToLoad").files[0];
 
    var fileReader = new FileReader();
    fileReader.onload = function(fileLoadedEvent) 
    {
        var textFromFileLoaded = fileLoadedEvent.target.result;
        document.getElementById("final_span").value = textFromFileLoaded;
    };
    fileReader.readAsText(fileToLoad, "UTF-8");
}    
        
var final_transcript = '';
var recognizing = false;

if ('webkitSpeechRecognition' in window) {

  var recognition = new webkitSpeechRecognition();

  recognition.continuous = true;
  recognition.interimResults = true;

  recognition.onstart = function() {
    recognizing = true;
  };

  recognition.onerror = function(event) {
    console.log(event.error);
  };

  recognition.onend = function() {
    recognizing = false;
  };

  recognition.onresult = function(event) {
    var interim_transcript = '';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        final_transcript += event.results[i][0].transcript;
      } else {
        interim_transcript += event.results[i][0].transcript;
      }
    }
    final_transcript = capitalize(final_transcript);
    final_span.innerHTML = linebreak(final_transcript);
    interim_span.innerHTML = linebreak(interim_transcript);
    
  };
}

var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
}

function capitalize(s) {
  return s.replace(s.substr(0,1), function(m) { return m.toUpperCase(); });
}

function startDictation(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  final_transcript = '';
  recognition.lang = 'en-IN';
  recognition.start();
  final_span.innerHTML = '';
  interim_span.innerHTML = '';
}
</script>
    
    </body>
</html>