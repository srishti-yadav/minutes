<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    
<style>
   
    .results{
        color: white;
        font-size: 15px;
        text-align: left;
    
    }
    .box1{
        float: right;
        height: 200px;
        padding: 70px 150px 70px 10px;
    }
    </style>
    
    
    </head>

    <body>
    <center>
<div>
    <a href="#" id="start_button" onclick="startDictation(event)"><button style="margin-bottom:10px;padding:5px;background:white"><i> <h2 style="margin:0px;padding:0px;color:rgb(100,100,120);">Start Dictation</h2></i></button> </a>  &nbsp;&nbsp;
    
                   
</div>
                        <div class="box1"> 
                               <button style="margin-top:7px;width:70px" onclick="pause(event)" class="btn"><b><i>Pause</i></b></button> <br> <br>
                   <button style="margin-top:7px;width:70px" onclick="reset(event)" class="btn"><b><i>Reset</i></b></button>

                        
            </div>

               <form method="post" action="minutes.php" onsubmit="javascript: return process();"> 
    <div class="area area2">
 <div class="results" contenteditable="true" >

            <span id="final_span"  class="final" name="final_text">
    
        </span> 
                      <span id="interim_span" class="interim"> </span> 

        </div>
               
        
        </div>
                   
                      <input type="hidden" id ="hidden" name="hidden">
                    <script type="text/javascript">
function process() {
  document.getElementById("hidden").value = document.getElementById("final_span").innerHTML;
  return true;
}
</script>
        
                 

                   <button style="margin-top:7px;" class="btn" name="subb"><b><i>Summarize</i></b></button>
        </form>

        
        <div class="aft">
        Filename to Save As: 
        <input id="inputFileNameToSaveAs">  
        <button class="btn"  onclick="saveTextAsFile()"><b><i>Save Text to File</i></b></button> <br>
    <br>
        Select a File to Load:
          <input type="file" id="fileToLoad">
        <button class="btn" onclick="loadFileAsText()"><b><i>Load Selected File</i></b></button>
        
        </div>
  
        </center>
        
        
<script type="text/javascript">
    
    function saveTextAsFile()
{
    var textToSave = document.getElementById("final_span").innerHTML;
     textToSave= textToSave.replace("<br>", "\r\n").replace("<p></p>","\r\n\n");    
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
        document.getElementById("final_span").innerHTML= textFromFileLoaded;
    };
    fileReader.readAsText(fileToLoad, "UTF-8");
}    
        
var recognizing = false;

if ('webkitSpeechRecognition' in window) {
var final_transcript = '';

    var interim_transcript = '';

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
      interim_transcript='';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
              final_transcript += event.results[i][0].transcript;
      } else {
        interim_transcript += event.results[i][0].transcript;
      }
         
    } 
      
  final_transcript = lineb(final_transcript);
    interim_transcript= lineb(interim_transcript);
      
    
    interim_transcript = capitalize(interim_transcript);
    final_transcript = capitalize(final_transcript);
      
    final_span.innerHTML = linebreak(final_transcript);
    interim_span.innerHTML = linebreak(interim_transcript);
         
      

    
  };
    
}  
var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
  return s.replace(two_line, '.<p></p>').replace(one_line, '.<br>');
}
    
function lineb(s) {
  return s.replace('period','.').replace('comma',',');
}


function capitalize(s) {
  return s.replace(s.substr(0,2), function(m) { return m.toUpperCase(); });
}

function startDictation(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  final_transcript =final_transcript + ' ';
  recognition.lang = 'en-IN';
  recognition.start();
  //final_span.innerHTML = '';
  interim_span.innerHTML = '';
}
    
function reset(event) {
    document.getElementById("final_span").innerHTML ="";
    final_transcript='';

    
}
    function pause(event){
        recognition.stop();
    }
    
</script>
        
        <div class="bottom">
        
        developer  &copy; Srishti Yadav.
        
        </div>
    
    </body>
</html>